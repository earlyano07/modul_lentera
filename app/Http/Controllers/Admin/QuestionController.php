<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class QuestionController extends Controller
{
    public function create(Assessment $assessment)
    {
        return redirect()->route('admin.assessments.show', $assessment);
    }

    public function store(Request $request, Assessment $assessment)
    {
        $validated = $request->validate([
            'question' => 'required|string',
            'score' => 'required|integer|min:1',
            'urutan' => 'required|integer|min:1',
            'image_upload' => 'nullable|image|max:2048',
            'options' => 'required|array|min:2',
            'options.*.label' => 'required|string|max:5',
            'options.*.option' => 'required|string',
            'correct_option' => 'required|integer|min:0',
        ]);

        $imagePath = null;
        if ($request->hasFile('image_upload')) {
            $imagePath = $request->file('image_upload')->store('questions/images', 'public');
        }

        DB::transaction(function () use ($validated, $assessment, $request, $imagePath) {
            $question = Question::create([
                'assessment_id' => $assessment->id,
                'question' => $validated['question'],
                'image_path' => $imagePath,
                'type' => 'multiple_choice',
                'score' => $validated['score'],
                'urutan' => $validated['urutan'],
            ]);
            foreach ($validated['options'] as $index => $optionData) {
                QuestionOption::create([
                    'question_id' => $question->id,
                    'label' => $optionData['label'],
                    'option' => $optionData['option'],
                    'is_correct' => $index == $request->correct_option,
                ]);
            }
        });
        return redirect()->route('admin.assessments.show', $assessment)->with('success', 'Soal berhasil ditambahkan.');
    }

    public function edit(Question $question)
    {
        $question->load(['assessment', 'options']);
        return view('admin.questions.edit', compact('question'));
    }

    public function update(Request $request, Question $question)
    {
        $validated = $request->validate([
            'question' => 'required|string',
            'score' => 'required|integer|min:1',
            'urutan' => 'required|integer|min:1',
            'image_upload' => 'nullable|image|max:2048',
            'options' => 'required|array|min:2',
            'options.*.label' => 'required|string|max:5',
            'options.*.option' => 'required|string',
            'correct_option' => 'required|integer|min:0',
        ]);

        $imagePath = $question->image_path;
        if ($request->hasFile('image_upload')) {
            // Delete old file if exists
            if ($question->image_path && Storage::disk('public')->exists($question->image_path)) {
                Storage::disk('public')->delete($question->image_path);
            }
            $imagePath = $request->file('image_upload')->store('questions/images', 'public');
        }

        DB::transaction(function () use ($validated, $question, $request, $imagePath) {
            $question->update([
                'question' => $validated['question'],
                'image_path' => $imagePath,
                'score' => $validated['score'],
                'urutan' => $validated['urutan'],
            ]);
            $question->options()->delete();
            foreach ($validated['options'] as $index => $optionData) {
                QuestionOption::create([
                    'question_id' => $question->id,
                    'label' => $optionData['label'],
                    'option' => $optionData['option'],
                    'is_correct' => $index == $request->correct_option,
                ]);
            }
        });
        return redirect()->route('admin.assessments.show', $question->assessment)->with('success', 'Soal berhasil diperbarui.');
    }

    public function destroy(Question $question)
    {
        $assessment = $question->assessment;
        
        // Delete image file if exists
        if ($question->image_path && Storage::disk('public')->exists($question->image_path)) {
            Storage::disk('public')->delete($question->image_path);
        }

        $question->delete();
        return redirect()->route('admin.assessments.show', $assessment)->with('success', 'Soal berhasil dihapus.');
    }
}

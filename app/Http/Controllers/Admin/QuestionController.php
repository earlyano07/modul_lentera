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
            'type' => 'nullable|string|in:single_choice,multiple_choice,checklist,essay',
            'question' => 'required|string',
            'score' => 'required|integer|min:1',
            'urutan' => 'required|integer|min:1',
            'image_upload' => 'nullable|image|max:2048',
            'options' => 'nullable|array',
            'options.*.label' => 'nullable|string|max:5',
            'options.*.option' => 'nullable|string',
            'options.*.score' => 'nullable|numeric|min:0',
            'correct_option' => 'nullable|integer|min:0',
            'correct_options' => 'nullable|array',
            'correct_options.*' => 'integer|min:0',
        ]);

        $type = in_array($request->type, ['checklist', 'essay']) ? $request->type : 'single_choice';

        if ($type !== 'essay' && (empty($validated['options']) || count($validated['options']) < 2)) {
            return back()->withErrors(['options' => 'Soal pilihan ganda dan checklist membutuhkan minimal 2 opsi jawaban.'])->withInput();
        }

        $imagePath = null;
        if ($request->hasFile('image_upload')) {
            $imagePath = $request->file('image_upload')->store('questions/images', 'public');
        }

        DB::transaction(function () use ($validated, $assessment, $request, $imagePath, $type) {
            $question = Question::create([
                'assessment_id' => $assessment->id,
                'question' => $validated['question'],
                'image_path' => $imagePath,
                'type' => $type,
                'score' => $validated['score'],
                'urutan' => $validated['urutan'],
            ]);

            if ($type !== 'essay' && !empty($validated['options'])) {
                $correctOptions = (array) $request->input('correct_options', []);
                $correctOption = $request->input('correct_option', 0);

                foreach ($validated['options'] as $index => $optionData) {
                    $isCorrect = $type === 'checklist' 
                        ? in_array($index, $correctOptions)
                        : ($index == $correctOption);

                    QuestionOption::create([
                        'question_id' => $question->id,
                        'label' => $optionData['label'] ?? chr(65 + $index),
                        'option' => $optionData['option'] ?? '',
                        'score' => isset($optionData['score']) ? (int) $optionData['score'] : 0,
                        'is_correct' => $isCorrect,
                    ]);
                }
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
            'type' => 'nullable|string|in:single_choice,multiple_choice,checklist,essay',
            'question' => 'required|string',
            'score' => 'required|integer|min:1',
            'urutan' => 'required|integer|min:1',
            'image_upload' => 'nullable|image|max:2048',
            'options' => 'nullable|array',
            'options.*.label' => 'nullable|string|max:5',
            'options.*.option' => 'nullable|string',
            'options.*.score' => 'nullable|numeric|min:0',
            'correct_option' => 'nullable|integer|min:0',
            'correct_options' => 'nullable|array',
            'correct_options.*' => 'integer|min:0',
        ]);

        $type = in_array($request->type, ['checklist', 'essay']) ? $request->type : 'single_choice';

        if ($type !== 'essay' && (empty($validated['options']) || count($validated['options']) < 2)) {
            return back()->withErrors(['options' => 'Soal pilihan ganda dan checklist membutuhkan minimal 2 opsi jawaban.'])->withInput();
        }

        $imagePath = $question->image_path;
        if ($request->hasFile('image_upload')) {
            // Delete old file if exists
            if ($question->image_path && Storage::disk('public')->exists($question->image_path)) {
                Storage::disk('public')->delete($question->image_path);
            }
            $imagePath = $request->file('image_upload')->store('questions/images', 'public');
        }

        DB::transaction(function () use ($validated, $question, $request, $imagePath, $type) {
            $question->update([
                'question' => $validated['question'],
                'image_path' => $imagePath,
                'type' => $type,
                'score' => $validated['score'],
                'urutan' => $validated['urutan'],
            ]);

            $question->options()->delete();

            if ($type !== 'essay' && !empty($validated['options'])) {
                $correctOptions = (array) $request->input('correct_options', []);
                $correctOption = $request->input('correct_option', 0);

                foreach ($validated['options'] as $index => $optionData) {
                    $isCorrect = $type === 'checklist' 
                        ? in_array($index, $correctOptions)
                        : ($index == $correctOption);

                    QuestionOption::create([
                        'question_id' => $question->id,
                        'label' => $optionData['label'] ?? chr(65 + $index),
                        'option' => $optionData['option'] ?? '',
                        'score' => isset($optionData['score']) ? (int) $optionData['score'] : 0,
                        'is_correct' => $isCorrect,
                    ]);
                }
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

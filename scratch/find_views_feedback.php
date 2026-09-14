<?php
$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__DIR__ . '/../resources/views'));
foreach ($files as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $content = file_get_contents($file->getPathname());
        if (str_contains($content, 'feedback_step') || str_contains($content, 'Performance Feedback') || str_contains($content, 'feedback_step1')) {
            $lines = explode("\n", $content);
            foreach ($lines as $num => $line) {
                if (str_contains($line, 'feedback_step') || str_contains($line, 'Performance Feedback') || str_contains($line, 'feedback_step1')) {
                    echo $file->getPathname() . " (Line " . ($num + 1) . "): " . trim($line) . "\n";
                }
            }
        }
    }
}

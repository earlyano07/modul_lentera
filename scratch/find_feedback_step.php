<?php
$dirs = [__DIR__ . '/../app', __DIR__ . '/../database', __DIR__ . '/../resources'];
foreach ($dirs as $dir) {
    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($files as $file) {
        if ($file->isFile() && in_array($file->getExtension(), ['php', 'blade.php'])) {
            $content = file_get_contents($file->getPathname());
            if (str_contains($content, 'feedback_step')) {
                $lines = explode("\n", $content);
                foreach ($lines as $num => $line) {
                    if (str_contains($line, 'feedback_step')) {
                        echo $file->getPathname() . " (Line " . ($num + 1) . "): " . trim($line) . "\n";
                    }
                }
            }
        }
    }
}

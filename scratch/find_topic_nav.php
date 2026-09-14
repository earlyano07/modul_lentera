<?php
$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__DIR__ . '/../resources/views'));
foreach ($files as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $content = file_get_contents($file->getPathname());
        if (str_contains($content, 'isActive') || str_contains($content, 'bg-on-primary-fixed') || str_contains($content, 'TOPIK')) {
            $lines = explode("\n", $content);
            foreach ($lines as $num => $line) {
                if (str_contains($line, 'isActive') || str_contains($line, 'bg-on-primary-fixed') || str_contains($line, 'TOPIK')) {
                    echo $file->getPathname() . " (Line " . ($num + 1) . "): " . trim($line) . "\n";
                }
            }
        }
    }
}

<?php
$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__DIR__ . '/../app/Http/Controllers'));
foreach ($files as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $content = file_get_contents($file->getPathname());
        if (str_contains($content, 'admin.modules.show')) {
            $lines = explode("\n", $content);
            foreach ($lines as $num => $line) {
                if (str_contains($line, 'admin.modules.show')) {
                    echo $file->getPathname() . " (Line " . ($num + 1) . "): " . trim($line) . "\n";
                }
            }
        }
    }
}

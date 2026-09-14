<?php
$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__DIR__ . '/..'));
foreach ($files as $file) {
    if ($file->isFile() && in_array($file->getExtension(), ['php', 'json', 'md', 'js'])) {
        $path = $file->getPathname();
        if (str_contains($path, 'vendor') || str_contains($path, '.git') || str_contains($path, 'storage') || str_contains($path, 'node_modules')) {
            continue;
        }
        $content = file_get_contents($path);
        if (str_contains($content, 'minimal_nilai')) {
            $lines = explode("\n", $content);
            foreach ($lines as $num => $line) {
                if (str_contains($line, 'minimal_nilai')) {
                    echo $path . " (Line " . ($num + 1) . "): " . trim($line) . "\n";
                }
            }
        }
    }
}

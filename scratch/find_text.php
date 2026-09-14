<?php

$dir = new RecursiveDirectoryIterator(__DIR__ . '/../resources/views');
$iterator = new RecursiveIteratorIterator($dir);

foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $content = file_get_contents($file->getPathname());
        if (stripos($content, 'batas') !== false || stripos($content, 'minimal nilai') !== false) {
            $lines = explode("\n", $content);
            foreach ($lines as $num => $line) {
                if (stripos($line, 'batas') !== false || stripos($line, 'minimal nilai') !== false) {
                    echo $file->getPathname() . " (Line " . ($num + 1) . "): " . trim($line) . "\n";
                }
            }
        }
    }
}

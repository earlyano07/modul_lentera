<?php

$host = '127.0.0.1';
$db = 'lentera_db';
$user = 'root';
$pass = '';

$pdo = new PDO("mysql:host={$host};dbname={$db};charset=utf8mb4", $user, $pass, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);

$output = "-- Database Export for Hosting / cPanel (Model LENTERA)\n";
$output .= "-- Generated: " . date('Y-m-d H:i:s') . "\n";
$output .= "-- PHP Version: " . phpversion() . "\n\n";

$output .= "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\n";
$output .= "SET AUTOCOMMIT = 0;\n";
$output .= "START TRANSACTION;\n";
$output .= "SET time_zone = \"+00:00\";\n\n";

$output .= "/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;\n";
$output .= "/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;\n";
$output .= "/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;\n";
$output .= "/*!40101 SET NAMES utf8mb4 */;\n";
$output .= "/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;\n\n";

$tables = $pdo->query("SHOW FULL TABLES WHERE Table_type = 'BASE TABLE'")->fetchAll(PDO::FETCH_NUM);

foreach ($tables as $tableRow) {
    $table = $tableRow[0];
    
    $output .= "-- --------------------------------------------------------\n";
    $output .= "-- Table structure for table `{$table}`\n";
    $output .= "-- --------------------------------------------------------\n\n";
    
    $output .= "DROP TABLE IF EXISTS `{$table}`;\n";
    
    $createRow = $pdo->query("SHOW CREATE TABLE `{$table}`")->fetch(PDO::FETCH_NUM);
    $createSql = $createRow[1];
    
    // Replace any utf8mb4_0900_ai_ci with utf8mb4_unicode_ci for 100% hosting compatibility
    $createSql = str_replace('utf8mb4_0900_ai_ci', 'utf8mb4_unicode_ci', $createSql);
    
    $output .= $createSql . ";\n\n";
    
    // Dump data
    $count = $pdo->query("SELECT COUNT(*) FROM `{$table}`")->fetchColumn();
    if ($count > 0) {
        $output .= "-- Dumping data for table `{$table}`\n\n";
        
        $rows = $pdo->query("SELECT * FROM `{$table}`");
        $insertHeader = "INSERT INTO `{$table}` VALUES \n";
        $batch = [];
        
        foreach ($rows as $row) {
            $values = [];
            foreach ($row as $val) {
                if ($val === null) {
                    $values[] = 'NULL';
                } else {
                    $values[] = $pdo->quote($val);
                }
            }
            $batch[] = "(" . implode(', ', $values) . ")";
            
            if (count($batch) >= 100) {
                $output .= $insertHeader . implode(",\n", $batch) . ";\n";
                $batch = [];
            }
        }
        
        if (count($batch) > 0) {
            $output .= $insertHeader . implode(",\n", $batch) . ";\n";
        }
        
        $output .= "\n";
    }
}

$output .= "/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;\n";
$output .= "/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;\n";
$output .= "/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;\n";
$output .= "/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;\n";
$output .= "COMMIT;\n";

$targetFile = __DIR__ . '/../database_lentera_cpanel.sql';
file_put_contents($targetFile, $output);

echo "Successfully exported database to: {$targetFile}\n";
echo "File size: " . round(filesize($targetFile) / 1024, 2) . " KB\n";

<?php
require_once __DIR__ . '/lib/FileOperations.php';

$filesOperations = new FileOperations();

const TEMP_FILES_DIR_PATH = __DIR__ . '/temp/files/';

$startingNumber = 920;


$highestNumber = 921;
//$highestNumber = 1372;

$filesOperations->createDirectories();

//  download cycle
$numberLoop = $startingNumber;

while (($numberLoop - 1) < $highestNumber) {
    $filesOperations->downloadFile($numberLoop, $startingNumber, $highestNumber);
    $numberLoop++;
}

$zipFiles = glob('temp/*.*');
define('_PATH', dirname(__FILE__));
$file1 = fopen(__DIR__ . '/temp/files/final.pgn', 'w+');

foreach ($zipFiles as $zipFile) {
    $filesOperations->mergeFiles($file1, $zipFile, TEMP_FILES_DIR_PATH);
}

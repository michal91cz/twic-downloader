<?php

$number = 920;

$highestNumber = 1364;

mkdir(__DIR__ . '/temp', 0777);
mkdir(__DIR__ . '/temp/files', 0777);

//  download cycle
$numberLoop = $number;
while (($numberLoop - 1) < $highestNumber) {
    file_put_contents(
        'temp\tmp' . $numberLoop . '.zip',
        fopen('https://theweekinchess.com/zips/twic' . $numberLoop . 'g.zip', 'r')
    );

    echo 'Downloaded TWIC' . $numberLoop;
    echo ' [';
    echo ($numberLoop - $number + 1) . ' out of ' . ($highestNumber - $number + 1);
    echo ']';
    echo '  ';
    echo PHP_EOL;

    $numberLoop++;
}

$zipFiles = glob('temp/*.*');
define('_PATH', dirname(__FILE__));
$file1 = fopen(__DIR__ . '/temp/files/final.pgn', 'w+');

//  merge cycle
foreach ($zipFiles as $zipFile) {
    echo('Unzipping ' . $zipFile . PHP_EOL);
    $filename = $zipFile;
    $zip = new ZipArchive;
    $res = $zip->open($filename);
    if ($res === true) {
        // Unzip path
        $path = _PATH . '/temp/files/';

        // Extract file
        $zip->extractTo($path);

        for ($i = 0; $i < $zip->numFiles; $i++) {
            $extractedFile = $zip->getNameIndex($i);
        }

        $zip->close();

        $file2 = file_get_contents(__DIR__ . '/temp/files/' . $extractedFile);

        fwrite($file1, $file2 . PHP_EOL);
        unlink(__DIR__ . '/temp/files/' . $extractedFile);
        echo('Merged ' . $extractedFile . PHP_EOL);
    }

    unlink($zipFile);
}

<?php

class FileOperations
{
    /**
     * FileOperations constructor.
     */
    public function __construct()
    {
    }


    public function mergeFiles($file1, $zipFile, $path): void
    {
        echo('Unzipping ' . $zipFile . PHP_EOL);
        $filename = $zipFile;
        $zip = new ZipArchive;
        $res = $zip->open($filename);
        if ($res === true) {
            // Unzip path
            $path = $path;

            // Extract file
            $zip->extractTo($path);

            for ($i = 0; $i < $zip->numFiles; $i++) {
                $extractedFile = $zip->getNameIndex($i);
            }

            $zip->close();

            $file2 = file_get_contents($path . $extractedFile);

            fwrite($file1, $file2 . PHP_EOL);
            unlink($path . $extractedFile);
            echo('Merged ' . $extractedFile . PHP_EOL);
        }

        unlink($zipFile);
    }


    public function downloadFile(int $loopNumber, int $startingNumber,int $highestNumber): void
    {
        file_put_contents(
            'temp\tmp' . $loopNumber . '.zip',
            fopen('https://theweekinchess.com/zips/twic' . $loopNumber . 'g.zip', 'r')
        );

        echo 'Downloaded TWIC' . $loopNumber;
        echo ' [';
        echo ($loopNumber - $startingNumber + 1) . ' out of ' . ($highestNumber - $startingNumber + 1);
        echo ']';
        echo '  ';
        echo PHP_EOL;
    }


    public function createDirectories(): void
    {
        if (!file_exists(__DIR__ . '/../temp/')) {
            mkdir(__DIR__ . '/../temp/', 0777, true);
        }

        if (!file_exists(__DIR__ . '/../temp/files/')) {
            mkdir(__DIR__ . '/../temp/files/', 0777, true);
        }

    }
}
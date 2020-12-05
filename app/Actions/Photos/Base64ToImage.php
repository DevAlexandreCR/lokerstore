<?php

namespace App\Actions\Photos;

class Base64ToImage
{

    /**
     * @param string $base64String
     * @param $outputFile
     * @return mixed
     */
    public static function execute(string $base64String, $outputFile)
    {
        $file = fopen($outputFile, 'wb');

        $data = explode(',', $base64String);

        fwrite($file, base64_decode($data[1]));
        fclose($file);

        return $outputFile;
    }
}

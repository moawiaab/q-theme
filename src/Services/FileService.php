<?php

namespace Moawiaab\QTheme\Services;

use Illuminate\Support\Facades\File;
class FileService
{
    public static function allFiles($path, $continueText = "Controller")
    {
        $files = File::allFiles($path);

        $allFiles = [];

        foreach ($files as $file) {
            $file = explode(".", $file->getRelativePathname())[0];
            if ($file == $continueText) {
                continue;
            }
            $allFiles[] = $file;
        }
        return $allFiles;
    }

    public static function replaceInFile($search, $replace, $path)
    {
        file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
    }

    public static function editFile($path, $text)
    {
        $file = fopen($path, 'a');
        fwrite($file, $text);
        fclose($file);
    }


}

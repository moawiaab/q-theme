<?php

namespace Moawiaab\QTheme\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


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

    public static function fillable($after, $name,$group = "web")
    {
        $httpKernel = file_get_contents(app_path('Http/Kernel.php'));

        $middlewareGroups = Str::before(Str::after($httpKernel, 'protected $fillable = ['), '];');
        $middlewareGroup = Str::before(Str::after($middlewareGroups, "'$group' => ["), '],');

        if (!Str::contains($middlewareGroup, $name)) {
            $modifiedMiddlewareGroup = str_replace(
                $after . ',',
                $after . ',' . PHP_EOL . '            ' . $name . ',',
                $middlewareGroup,
            );

            file_put_contents(app_path('Http/Kernel.php'), str_replace(
                $middlewareGroups,
                str_replace($middlewareGroup, $modifiedMiddlewareGroup, $middlewareGroups),
                $httpKernel
            ));
        }
    }
}

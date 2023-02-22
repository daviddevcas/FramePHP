<?php

namespace Backend\Services;

use Exception;

class Storage
{
    public static function fileExist(String $disk, String $file): bool
    {
        return file_exists(Storage::getDisks()[$disk] . "{$file}");
    }

    public static function getFile(String $disk, String $file): string
    {
        return file_get_contents(Storage::getDisks()[$disk] . "{$file}");
    }

    public static function writeFile(String $disk, String $file, String $value): void
    {
        $file = fopen(Storage::getDisks()[$disk] . "{$file}", "w+b");
        if (is_resource($file)) {
            if (!fwrite($file, $value)) throw new Exception('File writer not working.');
            if (!fflush($file)) throw new Exception('The file pointer must be valid, and must point to a file successfully opened by fopen() or fsockopen() (and not yet closed by fclose()).');
            if (!fclose($file)) throw new Exception('Could not close the file.');
        } else {
            throw new Exception('File not exist.');
        }
    }

    public static function setFile(String $disk, String $file, String $value): bool
    {
        return move_uploaded_file($value, Storage::getDisks()[$disk] . "{$file}");
    }

    public static function deleteFile(String $disk, String $file): bool
    {
        return unlink(Storage::getDisks()[$disk] . "{$file}");
    }

    private static function getDisks(): array
    {
        return constant('DISKS');
    }
}

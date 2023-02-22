<?php

namespace Backend\Services;

class Cache
{
    public static function itemExist(String $item): bool
    {
        if (Cache::verifyFileCache()) {
            $info = json_decode(Storage::getFile('cache', Cache::getFile()), true);

            return isset($info[$item]);
        }

        return false;
    }

    public static function getItem(String $item): mixed
    {
        if (Cache::verifyFileCache()) {
            $info = json_decode(Storage::getFile('cache', Cache::getFile()), true);

            return $info[$item] ?? null;
        }

        return null;
    }

    public static function setItem(String $item, $value): void
    {
        $info = array();

        if (Cache::verifyFileCache()) {
            $info = json_decode(Storage::getFile('cache', Cache::getFile()), true);
        }

        $info[$item] = $value;
        Storage::writeFile('cache', Cache::getFile(), json_encode($info));
    }

    public static function clear(): void
    {
        Storage::deleteFile('cache', Cache::getFile());
    }

    private static function verifyFileCache(): bool
    {
        return Storage::fileExist('cache', Cache::getFile());
    }

    private static function getFile(): string
    {
        return hash('sha256', $_SERVER['REMOTE_ADDR']) . '.cache';
    }
}

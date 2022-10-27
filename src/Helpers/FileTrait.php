<?php 

namespace MagedAhmad\Insular\Helpers;

trait FileTrait
{
    public function createDirectory($path, $mode = 0755, $recursive = true, $force = true): bool
    {
        if ($force) {
            return @mkdir($path, $mode, $recursive);
        }

        return mkdir($path, $mode, $recursive);
    }

    public function createFile($path, $contents = '', $lock = false): bool
    {
        $this->createDirectory(dirname($path));

        return file_put_contents($path, $contents, $lock ? LOCK_EX : 0);
    }
}

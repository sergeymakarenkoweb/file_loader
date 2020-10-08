<?php


namespace App\Core\Repositories;


use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Storage;

class StorageRepository
{

    protected string $env;

    public function __construct()
    {
        $this->env = config('app.env');
    }

    /**
     * @param string $path
     * @param string $contents
     * @param mixed $options
     * @throws Exception
     */
    public function putOrIgnore(string $path, $contents, $options = []): void
    {
        if (Storage::cloud()->exists($path)) {
            return;
        }
        $result = Storage::cloud()->put($this->pathWithEnv($path), $contents, $options);
        if (!$result) {
            throw new Exception("Can's store file by path $path");
        }
    }

    /**
     * @param string $path
     * @return string
     * @throws FileNotFoundException
     */
    public function getFile(string $path): string
    {
        return Storage::cloud()->get($this->pathWithEnv($path));
    }

    /**
     * @param string $path
     * @return bool
     */
    public function remove(string $path): bool
    {
        return Storage::cloud()->delete($this->pathWithEnv($path));
    }

    protected function pathWithEnv(string $path): string
    {
        return "/{$this->env}/{$path}";
    }
}

<?php


namespace App\Core\Models;


use Illuminate\Support\Collection;

interface Model
{
    /**
     * @param mixed $data
     * @return static
     */
    public static function make($data);

    /**
     * @param Collection $data
     * @return mixed
     */
    public static function makeMany(Collection $data): Collection;

}

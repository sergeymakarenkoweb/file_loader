<?php


namespace App\Core\Data;


use App\Core\Models\Size;
use Illuminate\Support\Collection;

class SizeData
{
    public string $code;
    public int $width;
    public int $height;
    public bool $isBlur;

    /**
     * @param string $code
     * @param string $width
     * @param string $height
     * @param bool $isBlur
     * @return static
     */
    public static function make(string $code, string $width, string $height, bool $isBlur = false)
    {
        $instance = new static();
        $instance->code = $code;
        $instance->width = $width;
        $instance->height = $height;
        $instance->isBlur = $isBlur;

        return $instance;
    }

    /**
     * @param Size $size
     * @return SizeData
     */
    public static function makeFromModel(Size $size): SizeData
    {
        $instance = new SizeData();
        $instance->code = $size->code;
        $instance->width = $size->width;
        $instance->height = $size->height;
        $instance->isBlur = $size->isBlur;

        return $instance;
    }

    /**
     * @param Collection<Size> $sizes
     * @return Collection<SizeData>
     */
    public static function makeFromModels(Collection $sizes): Collection
    {
        return $sizes->map(function (Size $size) {
            return SizeData::makeFromModel($size);
        });
    }
}

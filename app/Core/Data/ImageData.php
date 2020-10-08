<?php


namespace App\Core\Data;


use App\Core\Models\Image;
use Illuminate\Support\Collection;

class ImageData
{
    public string $groupCode;
    public string $filePath;
    public string $contents;
    public string $sizeCode;

    /**
     * @param string $groupCode
     * @param string $filePath
     * @param string $contents
     * @param string $sizeCode
     * @return ImageData
     */
    public static function make(string $groupCode,
        string $filePath,
        string $contents,
        string $sizeCode = 'original'): ImageData
    {
        $instance = new ImageData();
        $instance->groupCode = $groupCode;
        $instance->filePath = $filePath;
        $instance->sizeCode = $sizeCode;
        $instance->contents = $contents;

        return $instance;
    }

    /**
     * @param Image $image
     * @return ImageData
     */
    public static function makeFromModel(Image $image): ImageData
    {
        $instance = new ImageData();
        $instance->groupCode = $image->groupCode;
        $instance->filePath = $image->path;
        $instance->sizeCode = $image->sizeCode;
        $instance->contents = '';

        return $instance;
    }

    /**
     * @param Collection $models
     * @return Collection<ImageData>
     */
    public static function makeFromModels(Collection $models): Collection
    {
        return $models->map(function (Image $image) {
            return static::makeFromModel($image);
        });
    }
}

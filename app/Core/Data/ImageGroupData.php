<?php


namespace App\Core\Data;


use App\Core\Imagick\ImageContainer;

class ImageGroupData
{
    public string $code;
    public string $name;
    public string $extension;
    public ImageContainer $imageContainer;

    /**
     * @param string $groupCode
     * @param string $name
     * @param string $extension
     * @param ImageContainer $imageContainer
     * @return static
     */
    public static function make(string $groupCode, string $name, string $extension, ImageContainer $imageContainer)
    {
        $instance = new static();
        $instance->code = $groupCode;
        $instance->name = $name;
        $instance->extension = $extension;
        $instance->imageContainer = $imageContainer;

        return $instance;
    }
}

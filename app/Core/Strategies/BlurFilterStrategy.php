<?php


namespace App\Core\Strategies;


use Imagick;

class BlurFilterStrategy implements FilterStrategy
{
    public function filter(Imagick $imagick): Imagick
    {
        $imagick->blurImage(15, 3);

        return $imagick;
    }
}

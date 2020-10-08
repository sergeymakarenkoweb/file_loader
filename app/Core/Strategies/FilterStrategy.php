<?php


namespace App\Core\Strategies;



use Imagick;

interface FilterStrategy
{
    /**
     * @param Imagick $mainImageData
     * @return Imagick
     */
    public function filter(Imagick $mainImageData): Imagick;
}

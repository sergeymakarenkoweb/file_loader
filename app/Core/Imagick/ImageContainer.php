<?php


namespace App\Core\Imagick;


use App\Core\Factories\FilterStrategyFactory;
use Exception;
use Illuminate\Support\Facades\Log;
use Imagick;

class ImageContainer
{
    protected Imagick $imagick;

    protected function __construct(){
        $this->imagick = new Imagick();
    }

    public static function make(string $path)
    {
        $contents = file_get_contents($path);
        $instance = new ImageContainer();
        $instance->imagick->readImageBlob($contents);

        return $instance;
    }

    public function makeResize(int $width, int $height): ImageContainer
    {
        $instance = new self();
        $instance->imagick = $this->imagick->getImage();
        try {
            $instance->imagick->cropThumbnailImage($width, $height);
        } catch (Exception $exception) {
            Log::channel('file_loading_errors')
                ->info("Error set size width: {$width}, height: {$height} original sizes: {$instance->imagick->getImageWidth()}X{$instance->imagick->getImageHeight()}");
        }

        return $instance;
    }

    public function makeFilter(string $filterCode): ImageContainer
    {
        $instance = new self();
        $instance->imagick = FilterStrategyFactory::make($filterCode)->filter($this->imagick->getImage());

        return $instance;
    }

    public function getContents(): string
    {
        return $this->imagick->getImageBlob();
    }

    public function getLength(): int
    {
        return $this->imagick->getImageLength();
    }

    public function getWidth(): int
    {
        return $this->imagick->getImageWidth();
    }

    public function getHeight(): int
    {
        return $this->imagick->getImageHeight();
    }

    public static function generateGroupCode(ImageContainer $imageContainer, string $fileName, string $fileExtension, string $permission)
    {
        return md5(
            $fileName
            . $fileExtension
            . $imageContainer->imagick->getImageLength()
            . $imageContainer->imagick->getImageWidth()
            . $imageContainer->imagick->getImageHeight()
            . $permission);
    }

    /**
     * @param string $groupCode
     * @param string $filename
     * @param string $extension
     * @param string $size
     * @param string[] $filterCodes
     * @return string
     */
    public static function generatePath(string $groupCode, string $filename, string $extension, string $size, array $filterCodes)
    {
        $path = "{$groupCode}/{$filename}";
        if ($size !== 'original') {
            $path .= "_{$size}";
        }
        foreach ($filterCodes as $filter) {
            $path .= "_{$filter}";
        }
        return "{$path}.{$extension}";
    }
}

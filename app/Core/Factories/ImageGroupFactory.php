<?php


namespace App\Core\Factories;


use App\Core\Data\ImageGroupData;
use App\Core\Imagick\ImageContainer;
use Illuminate\Support\Collection;

class ImageGroupFactory
{

    /**
     * @param string $path
     * @param string $permission
     * @return ImageGroupData
     */
    public function make(string $path, string $permission = 'public'): ImageGroupData
    {
        $imageContainer = ImageContainer::make($path);
        $imagePathInfo = pathinfo(strtok($path, '?'));
        $groupCode = generate_group_code($imageContainer, $imagePathInfo['filename'], $imagePathInfo['extension'], $permission);

        return ImageGroupData::make($groupCode, $imagePathInfo['filename'], $imagePathInfo['extension'], $imageContainer);
    }

    /**
     * @param Collection $paths
     * @param string $permission
     * @return Collection<ImageGroupData>
     */
    public function makeMany(Collection $paths, string $permission = 'public'): Collection
    {
        return $paths->map(function (string $path) use ($permission) {
            return $this->make($path, $permission);
        });
    }
}

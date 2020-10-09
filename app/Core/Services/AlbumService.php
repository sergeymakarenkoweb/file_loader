<?php


namespace App\Core\Services;


use App\Core\Data\ImageData;
use App\Core\Data\ImageGroupData;
use App\Core\Data\SizeData;
use App\Core\Repositories\AlbumRepository;
use Illuminate\Support\Collection;

class AlbumService
{

    protected AlbumRepository $albumRepository;

    public function __construct(AlbumRepository $albumRepository)
    {
        $this->albumRepository = $albumRepository;
    }

    /**
     * @param string $albumCode
     * @return Collection<SizeData>
     */
    public function getSizes(string $albumCode): Collection
    {
        return SizeData::makeFromModels($this->albumRepository->getSizes($albumCode));
    }

    /**
     * @param string $albumCode
     * @param Collection $groups
     */
    public function attachGroups(string $albumCode, Collection $groups)
    {
        $groups->each(function (ImageGroupData $groupData, $key) use ($albumCode, $groups) {
            $this->albumRepository->attachGroup($albumCode, $groupData->code, abs($key - $groups->count()));
        });
    }

    /**
     * @param Collection<string> $newGroupCodes
     * @return Collection<ImageData>
     */
    public function getDeprecatedImages(Collection $newGroupCodes): Collection
    {
        $existsImages = ImageData::makeFromModels($this->albumRepository->getImages('instagram'));
        $existsGroupCodes = $existsImages->map(function (ImageData $imageGroup) {
            return $imageGroup->groupCode;
        });
        $deprecatedGroupsCodes = $existsGroupCodes->diff($newGroupCodes);
        return $existsImages->filter(function (ImageData $imageData) use ($deprecatedGroupsCodes) {
            return $deprecatedGroupsCodes->contains($imageData->groupCode);
        });
    }

}

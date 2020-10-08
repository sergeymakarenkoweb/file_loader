<?php


namespace App\Core\Services;


use App\Core\Data\ImageGroupData;
use App\Core\Repository\ImageGroupRepository;
use App\Core\Repository\ImageRepository;
use App\Core\Repository\StorageRepository;
use Illuminate\Support\Collection;

class ImageGroupService
{

    protected ImageGroupRepository $imageGroupRepository;
    protected ImageRepository $imageRepository;
    protected StorageRepository $storageRepository;

    public function __construct(ImageGroupRepository $imageGroupRepository,
        ImageRepository $imageRepository,
        StorageRepository $storageRepository)
    {
        $this->imageGroupRepository = $imageGroupRepository;
        $this->imageRepository = $imageRepository;
        $this->storageRepository = $storageRepository;
    }

    /**
     * @param Collection<ImageGroupData> $items
     */
    public function saveMany(Collection $items): void
    {
        $items->each(function (ImageGroupData $groupData) {
           $this->save($groupData);
        });
    }

    /**
     * @param ImageGroupData $groupData
     */
    public function save(ImageGroupData $groupData): void
    {
        $this->imageGroupRepository->createOrIgnore($groupData->code, $groupData->name, $groupData->extension);
    }

    /**
     * @param string $groupCode
     */
    public function delete(string $groupCode): void
    {
        $this->imageGroupRepository->delete($groupCode);
    }

    /**
     * @param Collection<string> $groupCodes
     */
    public function deleteMany(Collection $groupCodes): void
    {
        $groupCodes->each(function (string $groupCode) {
            $this->delete($groupCode);
        });
    }
}

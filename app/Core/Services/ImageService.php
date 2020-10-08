<?php


namespace App\Core\Services;


use App\Core\Data\ImageData;
use App\Core\Repositories\ImageRepository;
use App\Core\Repositories\StorageRepository;
use Exception;
use Illuminate\Support\Collection;

class ImageService
{
    protected ImageRepository $imageRepository;
    protected StorageRepository $storageRepository;

    public function __construct(ImageRepository $imageRepository, StorageRepository $storageRepository)
    {
        $this->imageRepository = $imageRepository;
        $this->storageRepository = $storageRepository;
    }

    /**
     * @param ImageData $imageData
     * @param string $permission
     * @throws Exception
     */
    public function save(ImageData $imageData, string $permission = 'public'): void
    {
        $this->storageRepository->putOrIgnore($imageData->filePath, $imageData->contents, $permission);
        $this->imageRepository->createOrIgnore($imageData->groupCode, $imageData->sizeCode, $imageData->filePath);
    }

    /**
     * @param Collection $items
     * @param string $permission
     */
    public function saveMany(Collection $items, string $permission = 'public'): void
    {
        $items->each(function (ImageData $imageData) use ($permission) {
            $this->save($imageData, $permission);
        });
    }

    /**
     * @param ImageData $imageData
     */
    public function delete(ImageData $imageData): void
    {
        $this->storageRepository->remove($imageData->filePath);
    }

    /**
     * @param Collection $collection
     */
    public function deleteImages(Collection $collection): void
    {
        $collection->each(function (ImageData $imageData) {
            $this->delete($imageData);
        });
    }
}

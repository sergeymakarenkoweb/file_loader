<?php


namespace App\Core\Services;


use App\Core\Connectors\FacebookConnector;
use App\Core\Data\ImageData;
use App\Core\Data\InstagramMediaData;
use App\Core\Models\InstagramMedia;
use App\Core\Repositories\InstagramRepository;
use App\Core\Repositories\StorageRepository;
use Illuminate\Support\Collection;

class InstagramService
{

    protected FacebookConnector $facebookConnector;
    protected InstagramRepository $instagramRepository;
    protected StorageRepository $storageRepository;

    /**
     * InstagramService constructor.
     * @param FacebookConnector $facebookConnector
     * @param InstagramRepository $instagramRepository
     * @param StorageRepository $storageRepository
     */
    public function __construct(FacebookConnector $facebookConnector,
        InstagramRepository $instagramRepository,
        StorageRepository $storageRepository)
    {
        $this->facebookConnector = $facebookConnector;
        $this->instagramRepository = $instagramRepository;
        $this->storageRepository = $storageRepository;
    }

    /**
     * @return Collection<ImageData>
     */
    public function getAll(): Collection
    {
        $result = InstagramMediaData::makeFormModels($this->instagramRepository->getAll());
        $result->each(function (InstagramMediaData $imageMediaData) {
            $imageMediaData->images->each(function (ImageData $imageData) {
                $imageData->filePath = $this->storageRepository->getFullPath($imageData->filePath);
            });
        });

        return $result;
    }

    /**
     * @return Collection<InstagramMedia>
     */
    public function getMediaFromFacebook(): Collection
    {
        return InstagramMediaData::makeFormModels($this->facebookConnector->getInstagramMedia());
    }

    /**
     * @param InstagramMedia $instagramMediaData
     */
    public function save(InstagramMedia $instagramMediaData): void
    {
        $this->instagramRepository->saveInstagramOrIgnore($instagramMediaData);
    }

    /**
     * @param Collection $items
     */
    public function saveMany(Collection $items): void
    {
        $items->each(function (InstagramMediaData $instagramMediaData) {
            $this->save(InstagramMedia::makeFromData($instagramMediaData));
        });
    }

}

<?php


namespace App\Core\Facades;


use App\Core\Data\ImageData;
use App\Core\Data\ImageGroupData;
use App\Core\Data\InstagramMediaData;
use App\Core\Factories\ImageFactory;
use App\Core\Factories\ImageGroupFactory;
use App\Core\Services\AlbumService;
use App\Core\Services\ImageGroupService;
use App\Core\Services\ImageService;
use App\Core\Services\InstagramService;
use Illuminate\Support\Collection;

class UploadFacade
{
    protected AlbumService $albumService;
    protected ImageGroupService $imageGroupService;
    protected InstagramService $instagramService;
    protected ImageService $imageService;
    protected ImageGroupFactory $imageGroupFactory;
    protected ImageFactory $imageFactory;

    public function __construct(AlbumService $albumService,
        InstagramService $instagramService,
        ImageGroupService $imageGroupService,
        ImageService $imageService,
        ImageGroupFactory $imageGroupFactory,
        ImageFactory $imageFactory)
    {
        $this->albumService = $albumService;
        $this->instagramService = $instagramService;
        $this->imageGroupService = $imageGroupService;
        $this->imageService = $imageService;
        $this->imageGroupFactory = $imageGroupFactory;
        $this->imageFactory = $imageFactory;
    }

    /**
     * @param Collection<ImageGroupData> $paths
     * @param string $albumCode
     * @param string $permission
     * @return Collection<ImageGroupData>
     */
    public function upload(Collection $paths, string $albumCode, string $permission = 'public'): Collection
    {
        $sizes = $this->albumService->getSizes($albumCode);
        $imageGroupsData = $this->imageGroupFactory->makeMany($paths);
        $images = new Collection();
        foreach ($imageGroupsData as $imageGroupData) {
            $images = $images->merge($this->imageFactory->makeMany($imageGroupData, $sizes));
        }
        $this->imageGroupService->saveMany($imageGroupsData);
        $this->imageService->saveMany($images, $permission);
        $this->albumService->attachGroups($albumCode, $imageGroupsData);

        return $imageGroupsData;
    }

    /**
     * Add last 6 instagram images
     * Remove deprecated images
     */
    public function updateInstagram()
    {
        /** @var Collection $media */
        $media = $this->instagramService->getMediaFromFacebook()->chunk(6)->first();
        $paths = $media->map(function (InstagramMediaData $instagramMediaData) {
            return !empty($instagramMediaData->thumbnailUrl) ? $instagramMediaData->thumbnailUrl : $instagramMediaData->mediaUrl;
        });
        $imageGroupsData = $this->upload($paths, 'instagram');
        $media->each(function (InstagramMediaData $instagramMediaData, int $key) use ($imageGroupsData) {
            $instagramMediaData->imageGroupCode = $imageGroupsData->get($key)->code;
        });
        $this->instagramService->saveMany($media);;

        $imageGroupCodes = $imageGroupsData->map(function (ImageGroupData $imageGroupData) {
            return $imageGroupData->code;
        });

        $deprecatedImages = $this->albumService->getDeprecatedImages($imageGroupCodes);
        $this->imageService->deleteImages($deprecatedImages);
        $deprecatedGroupCodes = $deprecatedImages->map(function (ImageData $imageGroupData) {
            return $imageGroupData->groupCode;
        })->unique();
        $this->imageGroupService->deleteMany($deprecatedGroupCodes);

    }

}

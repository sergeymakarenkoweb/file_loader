<?php


namespace App\Core\Services;


use App\Core\Connectors\FacebookConnector;
use App\Core\Data\InstagramMediaData;
use App\Core\Models\InstagramMedia;
use App\Core\Repositories\InstagramRepository;
use Illuminate\Support\Collection;

class InstagramService
{

    protected FacebookConnector $facebookConnector;
    protected InstagramRepository $instagramRepository;

    /**
     * InstagramService constructor.
     * @param FacebookConnector $facebookConnector
     * @param InstagramRepository $instagramRepository
     */
    public function __construct(FacebookConnector $facebookConnector, InstagramRepository $instagramRepository)
    {
        $this->facebookConnector = $facebookConnector;
        $this->instagramRepository = $instagramRepository;
    }

    /**
     * @return Collection<InstagramMedia>
     */
    public function getMediaFromFacebook(): Collection
    {
        return InstagramMediaData::makeByModels($this->facebookConnector->getInstagramMedia());
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

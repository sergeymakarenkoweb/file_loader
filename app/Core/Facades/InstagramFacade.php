<?php


namespace App\Core\Facades;


use App\Core\Data\InstagramMediaData;
use App\Core\Services\InstagramService;

class InstagramFacade
{

    public InstagramService $instagramService;

    public function __construct(InstagramService $instagramService)
    {
        $this->instagramService = $instagramService;
    }

    public function getImages(): array
    {
        return $this->instagramService->getAll()
            ->map(function (InstagramMediaData $instagramMediaData) {
                return $instagramMediaData->toArray();
            })->all();
    }
}

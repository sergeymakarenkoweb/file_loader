<?php


namespace App\Core\Data;


use App\Core\Models\InstagramMedia;
use Illuminate\Support\Collection;

class InstagramMediaData
{

    public string $groupCode = '';
    public string $facebookId = '';
    public string $caption = '';
    public string $mediaType = '';
    public string $mediaUrl = '';
    public string $thumbnailUrl = '';
    public string $permalink = '';

    /**
     * @param InstagramMedia $instagramMedia
     * @return InstagramMediaData
     */
    public static function makeByModel(InstagramMedia $instagramMedia)
    {
        $instance = new static();
        $instance->groupCode = $instagramMedia->groupCode;
        $instance->facebookId = $instagramMedia->facebookId;
        $instance->caption = $instagramMedia->caption;
        $instance->mediaType = $instagramMedia->mediaType;
        $instance->mediaUrl = $instagramMedia->mediaUrl;
        $instance->thumbnailUrl = $instagramMedia->thumbnailUrl;
        $instance->permalink = $instagramMedia->permalink;

        return $instance;
    }

    /**
     * @param Collection $mediaFiles
     * @return Collection<InstagramMedia>
     */
    public static function makeByModels(Collection $mediaFiles): Collection
    {
        return $mediaFiles->map(function (InstagramMedia $instagramMedia) {
            return static::makeByModel($instagramMedia);
        });
    }
}

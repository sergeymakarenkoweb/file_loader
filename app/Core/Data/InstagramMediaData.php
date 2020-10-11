<?php


namespace App\Core\Data;


use App\Core\Models\InstagramMedia;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

class InstagramMediaData implements Arrayable
{

    public string $imageGroupCode = '';
    public string $facebookId = '';
    public string $caption = '';
    public string $mediaType = '';
    public string $mediaUrl = '';
    public string $thumbnailUrl = '';
    public string $permalink = '';
    public Collection $images;

    public function __construct()
    {
        $this->images = new Collection();
    }

    /**
     * @param InstagramMedia $instagramMedia
     * @return InstagramMediaData
     */
    public static function makeFromModel(InstagramMedia $instagramMedia)
    {
        $instance = new static();
        $instance->imageGroupCode = $instagramMedia->imageGroupCode;
        $instance->facebookId = $instagramMedia->facebookId;
        $instance->caption = $instagramMedia->caption;
        $instance->mediaType = $instagramMedia->mediaType;
        $instance->mediaUrl = $instagramMedia->mediaUrl;
        $instance->thumbnailUrl = $instagramMedia->thumbnailUrl;
        $instance->permalink = $instagramMedia->permalink;
        $instance->images = ImageData::makeFromModels($instagramMedia->images);

        return $instance;
    }

    /**
     * @param Collection $mediaFiles
     * @return Collection<InstagramMedia>
     */
    public static function makeFormModels(Collection $mediaFiles): Collection
    {
        return $mediaFiles->map(function (InstagramMedia $instagramMedia) {
            return static::makeFromModel($instagramMedia);
        });
    }

    public function toArray()
    {
        $images = [];
        /**
         * @var ImageData $image
         */
        foreach ($this->images as $image) {
            $images[$image->sizeCode] = $image->toArray();
        }
        return [
            'facebook_id' => $this->facebookId,
            'image_group_code' => $this->imageGroupCode,
            'caption' => $this->caption,
            'media_type' => $this->mediaType,
            'media_url' => $this->mediaUrl,
            'thumbnailUrl' => $this->thumbnailUrl,
            'permalink' => $this->permalink,
            'images' => $images
        ];
    }
}

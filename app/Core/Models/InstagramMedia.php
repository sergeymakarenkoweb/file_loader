<?php


namespace App\Core\Models;


use App\Core\Data\InstagramMediaData;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

class InstagramMedia implements Model, Arrayable
{

    public string $groupCode = '';
    public string $facebookId = '';
    public string $caption = '';
    public string $mediaType = '';
    public string $mediaUrl = '';
    public string $thumbnailUrl = '';
    public string $permalink = '';

    /**
     * @param mixed $data
     * @return InstagramMedia
     */
    public static function make($data)
    {
        $instance = new InstagramMedia();
        $data = get_array_from_object($data);

        $instance->groupCode = $data['image_group_code'] ?? '';
        $instance->facebookId = $data['id'] ?? $data['facebook_id'];
        $instance->caption = $data['caption'];
        $instance->mediaType = $data['media_type'];
        $instance->mediaUrl = $data['media_url'];
        $instance->thumbnailUrl = $data['thumbnail_url'] ?? '';
        $instance->permalink = $data['permalink'];

        return $instance;
    }

    /**
     * @param Collection $data
     * @return Collection<InstagramMedia>
     */
    public static function makeMany(Collection $data): Collection
    {
        return $data->map(function ($item) {
            return InstagramMedia::make($item);
        });
    }

    /**
     * @param InstagramMediaData $instagramMediaData
     * @return static
     */
    public static function makeFromData(InstagramMediaData $instagramMediaData)
    {
        $instance = new static();
        $instance->groupCode = $instagramMediaData->groupCode;
        $instance->facebookId = $instagramMediaData->facebookId;
        $instance->mediaType = $instagramMediaData->mediaType;
        $instance->mediaUrl = $instagramMediaData->mediaUrl;
        $instance->thumbnailUrl = $instagramMediaData->thumbnailUrl;
        $instance->permalink = $instagramMediaData->permalink;
        $instance->caption = $instagramMediaData->caption;

        return $instance;
    }

    public function toArray()
    {
        return [
            'image_group_code' => $this->groupCode,
            'facebook_id' => $this->facebookId,
            'media_type' => $this->mediaType,
            'media_url' => $this->mediaUrl,
            'thumbnail_url' => $this->thumbnailUrl,
            'permalink' => $this->permalink,
            'caption' => $this->caption
        ];
    }
}

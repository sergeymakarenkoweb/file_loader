<?php


namespace App\Core\Models;


use Illuminate\Support\Collection;

class ImageGroup implements Model
{

    public string $code;
    public string $name;
    public string $extension;
    public Collection $images;

    public function __construct()
    {
        $this->images = new Collection();
    }

    /**
     * @param mixed $data
     * @return ImageGroup
     */
    public static function make($data)
    {
        $instance = new static();
        $data = get_array_from_object($data);
        $instance->code = $data['code'];
        $instance->name = $data['name'];
        $instance->extension = $data['extension'];

        return $instance;
    }

    /**
     * @param Collection $data
     * @return Collection
     */
    public static function makeMany(Collection $data): Collection
    {
        return $data->map(function ($item) {
            return static::make($item);
        });
    }

    public function addImage(Image $image)
    {
        $this->images->add($image);
    }
}

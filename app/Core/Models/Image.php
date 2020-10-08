<?php


namespace App\Core\Models;


use Carbon\Carbon;
use Illuminate\Support\Collection;
use stdClass;

class Image implements Model
{
    public string $groupCode = '';
    public string $sizeCode = '';
    public string $path = '';
    public Carbon $createdAt;
    public Carbon $updatedAt;

    /**
     * @param stdClass $data
     * @return Image
     */
    public static function make($data)
    {
        $instance = new self();
        $arr = get_array_from_object($data);

        $instance->groupCode = $arr['group_code'] ?? '';
        $instance->sizeCode = $arr['size_code'] ?? '';
        $instance->path = $arr['path'] ?? '';
        $instance->createdAt = isset($arr['created_at']) ? Carbon::parse($arr['created_at']) : now();
        $instance->updatedAt = isset($arr['updated_at']) ? Carbon::parse($arr['updated_at']) : now();

        return $instance;
    }

    /**
     * @param Collection $data
     * @return Collection<Image>
     */
    public static function makeMany(Collection $data): Collection
    {
        return $data->map(function ($item) {
            return Image::make($item);
        });
    }

}

<?php


namespace App\Core\Models;


use Illuminate\Support\Collection;

class Size implements Model
{
    const ORIGINAL_SIZE_CODE = 'original';

    public int $id;
    public string $code;
    public int $width;
    public int $height;
    public Collection $filters;

    protected function __construct()
    {
        $this->filters = new Collection();
    }

    /**
     * @param $data
     * @return Size
     */
    public static function make($data)
    {
        $instance = new self();
        $arr = get_array_from_object($data);

        $instance->id = $arr['id'] ?? 0;
        $instance->code = $arr['code'] ?? '';
        $instance->width = $arr['width'];
        $instance->height = $arr['height'];

        return $instance;
    }

    /**
     * @param Collection $data
     * @return Collection<Size>
     */
    public static function makeMany(Collection $data): Collection
    {
        return $data->map(function ($item) {
            return Size::make($item);
        });
    }

    /**
     * @param string $filterCode
     */
    public function addFilter(string $filterCode)
    {
        $this->filters->add($filterCode);
    }
}

<?php


namespace App\Core\Repository;


use App\Core\Models\Image;
use App\Core\Models\ImageGroup;
use App\Core\Models\Size;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Collection;

class AlbumRepository
{

    protected DatabaseManager $db;

    public function __construct(DatabaseManager $databaseManager)
    {
        $this->db = $databaseManager;
    }

    /**
     * @param string $code
     * @param string $permission
     * @return int
     */
    public function createOrIgnore(string $code, string $permission = 'public'): int
    {
        return $this->db->table('albums')->insertOrIgnore(compact('code', 'permission'));
    }

    /**
     * @param string $albumCode
     * @param string $groupCode
     * @param int $priority
     * @return bool
     */
    public function attachGroup(string $albumCode, string $groupCode, int $priority = 0): bool
    {
        return $this->db->table('album_image_groups')
            ->updateOrInsert(
                [
                    'album_code' => $albumCode,
                    'image_group_code' => $groupCode
                ],
                [
                    'album_code' => $albumCode,
                    'image_group_code' => $groupCode,
                    'priority' => $priority
                ]) > 0;
    }

    /**
     * @param string $code
     * @return Collection<ImageGroup>
     */
    public function getImages(string $code): Collection
    {
        $result = $this->db->table('images as i')
            ->join('album_image_groups as aig', 'aig.image_group_code', '=','i.group_code')
            ->select('i.*')
            ->where('aig.album_code', $code)
            ->get();
        return Image::makeMany($result);
    }

    /**
     * @param string $code
     * @return Collection
     */
    public function getSizes(string $code): Collection
    {
        $result = [];
        $sizes = $this->db->table('album_sizes as asi')
            ->select('s.code', 's.width', 's.height', 'sf.filter_code')
            ->leftJoin('size_filters as sf', 'sf.size_code', '=', 'asi.size_code')
            ->join('sizes as s', 's.code', '=', 'asi.size_code')
            ->where('asi.album_code', $code)
            ->get();
        foreach ($sizes as $size) {
            if (!isset($result[$size->code])) {
                $result[$size->code] = Size::make($size);
            }
            if (!empty($size->filter_code)) {
                $result[$size->code]->addFilter($size->filter_code);
            }
        }

        return new Collection(array_values($result));
    }
}

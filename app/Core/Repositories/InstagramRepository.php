<?php


namespace App\Core\Repositories;


use App\Core\Models\Image;
use App\Core\Models\InstagramMedia;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Collection;

class InstagramRepository
{
    protected DatabaseManager $db;

    public function __construct(DatabaseManager $databaseManager)
    {
        $this->db = $databaseManager;
    }

    /**
     * @param InstagramMedia $instagramMedia
     */
    public function saveInstagramOrIgnore(InstagramMedia $instagramMedia)
    {
        $this->db->table('image_group_instagram')->insertOrIgnore($instagramMedia->toArray());
    }

    public function getAll()
    {
        $result = [];
        $data = $this->db->table('image_group_instagram as igi')
            ->join('album_image_groups as aig', 'aig.image_group_code', '=', 'igi.image_group_code')
            ->join('images as i', 'i.group_code', '=', 'igi.image_group_code')
            ->orderBy('aig.priority', 'desc')
            ->get();
        foreach ($data as $item) {
            if (!isset($result[$item->facebook_id])) {
                $result[$item->facebook_id] = InstagramMedia::make($item);
            }
            $result[$item->facebook_id]->addImage(Image::make($item));
        }
        return new Collection(array_values($result));
    }
}

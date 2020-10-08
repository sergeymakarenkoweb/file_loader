<?php


namespace App\Core\Repositories;


use App\Core\Models\InstagramMedia;
use Illuminate\Database\DatabaseManager;

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
}

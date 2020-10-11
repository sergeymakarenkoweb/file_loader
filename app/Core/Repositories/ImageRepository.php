<?php


namespace App\Core\Repositories;


use Illuminate\Database\DatabaseManager;

class ImageRepository
{

    protected $db;

    public function __construct(DatabaseManager $databaseManager)
    {
        $this->db = $databaseManager;
    }

    /**
     * @param string $groupCode
     * @param string $sizeCode
     * @param string $path
     */
    public function createOrIgnore(
        string $groupCode,
        string $sizeCode,
        string $path
    ): void
    {
        $this->db->table('images')
            ->insertOrIgnore(
                [
                    'image_group_code' => $groupCode,
                    'size_code' => $sizeCode,
                    'path' => $path,
                ]);
    }
}

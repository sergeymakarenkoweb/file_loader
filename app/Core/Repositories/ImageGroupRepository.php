<?php


namespace App\Core\Repositories;


use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Collection;

class ImageGroupRepository
{

    protected DatabaseManager $db;

    public function __construct(DatabaseManager $databaseManager)
    {
        $this->db = $databaseManager;
    }

    /**
     * @param string $code
     * @return bool
     */
    public function exists(string $code): bool
    {
        return $this->db->table("image_groups")
            ->where('code', $code)
            ->exists();
    }

    /**
     * @param string $code
     * @return Collection<string>
     */
    public function getSizes(string $code): Collection
    {
        return $this->db->table('images')
            ->select('size_code')
            ->where('image_group_code', $code)
            ->get()
            ->map(function ($item) {
                return $item->size_code;
            });
    }

    /**
     * @param string $code
     */
    public function delete(string $code): void
    {
        $this->db->table('image_groups')
            ->where('code', $code)
            ->delete();
    }

    /**
     * @param string $code
     * @param string $name
     * @param string $extension
     */
    public function createOrIgnore(string $code, string $name, string $extension): void
    {
        $this->db->table('image_groups')->insertOrIgnore(compact('code', 'name', 'extension'));
    }

}

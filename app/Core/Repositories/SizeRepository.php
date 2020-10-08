<?php


namespace App\Core\Repositories;


use App\Core\Models\Size;
use Illuminate\Database\DatabaseManager;
use RuntimeException;

class SizeRepository
{

    protected DatabaseManager $db;

    public function __construct(DatabaseManager $databaseManager)
    {
        $this->db = $databaseManager;
    }

    /**
     * @param string $sizeCode
     * @return Size
     * @throws RuntimeException
     */
    public function getSize(string $sizeCode)
    {
        $result = $this->db->table('sizes')
            ->where('code', $sizeCode)
            ->first();
        if (!$result) {
            throw new RuntimeException("Size by code $sizeCode was not found");
        }
        return Size::make($result);
    }

    /**
     * @return Size
     * @throws RuntimeException
     */
    public function getOriginalSize()
    {
        return $this->getSize('original');
    }
}

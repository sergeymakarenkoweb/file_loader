<?php


namespace App\Core\Factories;


interface StrategyFactory
{

    /**
     * @param string $strategyCode
     * @return mixed
     */
    public static function make(string $strategyCode);
}

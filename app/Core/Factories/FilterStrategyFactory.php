<?php


namespace App\Core\Factories;


use App\Core\Strategies\BlurFilterStrategy;
use App\Core\Strategies\FilterStrategy;
use RuntimeException;

class FilterStrategyFactory implements StrategyFactory
{

    /**
     * @param string $filterCode
     * @return FilterStrategy
     */
    public static function make(string $filterCode): FilterStrategy {
        if ($filterCode === 'blur') {
            return app(BlurFilterStrategy::class);
        }
        throw new RuntimeException("Can't make filter by code $filterCode");
    }

}

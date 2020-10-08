<?php


namespace App\Core\Factories;


use App\Core\Data\ImageData;
use App\Core\Data\ImageGroupData;
use App\Core\Data\SizeData;
use App\Core\Models\Size;
use App\Core\Repository\SizeRepository;
use Illuminate\Support\Collection;

class ImageFactory
{
    protected SizeRepository $sizeRepository;

    public function __construct(SizeRepository $sizeRepository)
    {
        $this->sizeRepository = $sizeRepository;
    }

    /**
     * @param ImageGroupData $imageGroupData
     * @param SizeData $size
     * @return ImageData
     */
    public function make(ImageGroupData $imageGroupData, SizeData $size): ImageData
    {
        $imageContainer = $imageGroupData->imageContainer;
        if ($size->code !== Size::ORIGINAL_SIZE_CODE) {
            $imageContainer = $imageGroupData->imageContainer->makeResize($size->width, $size->height);
            foreach ($size->filters as $filterCode) {
                $imageContainer = $imageContainer->makeFilter($filterCode);
            }
        }
        $sizePath = generate_path($imageGroupData->code, $imageGroupData->name, $imageGroupData->extension, $size->code, $size->filters->all());

        return ImageData::make($imageGroupData->code, $sizePath, $imageContainer->getContents(), $size->code);
    }

    /**
     * @param ImageGroupData $imageGroupData
     * @param Collection $sizes
     * @return Collection
     */
    public function makeMany(ImageGroupData $imageGroupData, Collection $sizes): Collection
    {
        $sizes = new Collection($sizes);

        $sizes->push(SizeData::makeFromModel($this->sizeRepository->getOriginalSize()));
        return $sizes->map(function (SizeData $size) use ($imageGroupData) {
            return $this->make($imageGroupData, $size);
        });
    }
}

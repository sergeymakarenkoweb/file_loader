<?php

use App\Core\Imagick\ImageContainer;
use Illuminate\Contracts\Support\Arrayable;

if (! function_exists('say_ok')) {
    /**
     * Short method for ok status
     *
     * @return \Illuminate\Http\JsonResponse
     */
    function say_ok()
    {
        return response()->json(['status' => 200]);
    }
}

if (! function_exists('say_something_went_wrong')) {
    /**
     * Short method for general server error
     *
     * @return \Illuminate\Http\JsonResponse
     */
    function say_something_went_wrong()
    {
        return response()->json([
                             'status' => 500,
                             'reason' => 'server_error',
                             'message' => 'Something went wrong'
                         ], 500);
    }
}

if (! function_exists('generate_code')) {
    /**
     * @param ImageContainer $imageContainer
     * @param string $fileName
     * @param string $fileExtension
     * @param string $permission
     * @return string
     */
    function generate_group_code(ImageContainer $imageContainer, string $fileName, string $fileExtension, string $permission): string
    {
        return md5(
            $fileName
            . $fileExtension
            . $imageContainer->getLength()
            . $imageContainer->getWidth()
            . $imageContainer->getHeight()
            . $permission);
    }
}

if (! function_exists('generate_path')) {
    /**
     * @param string $groupCode
     * @param string $filename
     * @param string $extension
     * @param string $size
     * @param array $filterCodes
     * @return string
     */
    function generate_path(string $groupCode, string $filename, string $extension, string $size = 'original', array $filterCodes = [])
    {
        $path = "{$groupCode}/{$filename}";
        if ($size !== 'original') {
            $path .= "_{$size}";
        }
        foreach ($filterCodes as $filter) {
            $path .= "_{$filter}";
        }
        return "{$path}.{$extension}";
    }
}

if (! function_exists('get_array_from_object')) {
    function get_array_from_object($data)
    {
        if (is_array($data)) {
            $result = $data;
        } else if ($data instanceof Arrayable) {
            $result = $data->toArray();
        } else if (!isset($data)) {
            $result = [];
        } else {
            $result = (array) $data;
        }
        return $result;
    }
}

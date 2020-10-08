<?php

namespace App\Http\Controllers\Api;

use App\Core\Facades\UploadFacade;
use App\Core\Services\InstagramService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class InstagramController extends Controller
{

    /**
     * @var InstagramService
     */
    protected $uploadFacade;

    /**
     * InstagramController constructor.
     * @param UploadFacade $uploadFacade
     */
    public function __construct(UploadFacade $uploadFacade)
    {
        $this->uploadFacade = $uploadFacade;
    }

    /**
     * Return 6 records from instagram
     *
     * @return JsonResponse
     */
    public function getMedia()
    {
        return response()->json($this->uploadFacade->getMediaFromFacebook()->all());
    }

    /**
     * @return JsonResponse
     */
    public function refreshMedia()
    {
        $this->uploadFacade->updateInstagram();

        return say_ok();
    }
}

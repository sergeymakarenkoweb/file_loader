<?php

namespace App\Http\Controllers\Api;

use App\Core\Facades\InstagramFacade;
use App\Core\Facades\UploadFacade;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class InstagramController extends Controller
{

    protected UploadFacade $uploadFacade;
    protected InstagramFacade $instagramFacade;

    /**
     * InstagramController constructor.
     * @param UploadFacade $uploadFacade
     * @param InstagramFacade $instagramFacade
     */
    public function __construct(UploadFacade $uploadFacade, InstagramFacade $instagramFacade)
    {
        $this->uploadFacade = $uploadFacade;
        $this->instagramFacade = $instagramFacade;
    }

    /**
     * Return 6 records from instagram
     *
     * @return JsonResponse
     */
    public function getMedia()
    {
        return response()->json($this->instagramFacade->getImages());
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

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{

    /**
     * Process request from contact from
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function add(Request $request)
    {
        $data = $request->validate(
            [
                'name' => ['required', 'min:5'],
                'contact' => ['required', 'min:5'],
                'info' => ['nullable']
            ]
        );

        if ($data['info'] === null) {
            $data['info'] = '';
        }

        $result = (new Contact($data))->save();

        if (!$result) {
            Log::error("Can't save a contact: " . json_encode($data));
            return say_something_went_wrong();
        }

        return say_ok();
    }
}

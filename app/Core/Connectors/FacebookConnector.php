<?php


namespace App\Core\Connectors;


use App\Core\Models\InstagramMedia;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

/**
 * Connector work with base instagram API
 *
 * Class FacebookConnector
 * @package App\Core\Connectors
 */
class FacebookConnector
{
    protected string $facebookBaseURL = 'https://graph.instagram.com/';
    protected string $accessToken = '';

    protected PendingRequest $httpClient;

    /**
     * FacebookConnector constructor.
     * @param PendingRequest $httpClient
     */
    public function __construct(PendingRequest $httpClient)
    {
        $this->httpClient = $httpClient;
        $this->accessToken = config('facebook.instagram_token');

        $this->httpClient->baseUrl($this->facebookBaseURL);
        $this->httpClient->withHeaders(
            [
                'Authorization' => "Bearer {$this->accessToken}"
            ]
        );
    }

    /**
     * Return 25 records by user access token
     *
     * @return Collection<InstagramMedia>
     */
    public function getInstagramMedia(): Collection
    {
        $fields = ['id', 'caption', 'media_type', 'media_url', 'thumbnail_url', 'permalink'];
        $data = [
            'fields' => implode(',', $fields)
        ];
        $result = $this->httpClient->get('me/media', $data);
        if ($result->serverError() || $result->clientError()) {
            Log::error($result->body());
            return Collection::empty();
        }
        $result = $result->json()['data'];

        return InstagramMedia::makeMany(new Collection($result));
    }

}

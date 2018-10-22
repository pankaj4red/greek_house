<?php

namespace App\Services;

use App\Exceptions\HubSpotException;
use App\Helpers\GuzzleClientWrapper;
use GuzzleHttp\Exception\RequestException;

class HubSpot
{
    /**
     * Base Uri for HubSpot
     *
     * @var string
     */
    private static $baseUri = 'https://api.hubapi.com';

    /**
     * Base Uri for HubSpot
     *
     * @var string
     */
    private static $baseUriForm = 'https://forms.hubspot.com';

    /**
     * Required Scopes
     *
     * @var string[]
     */
    private static $scopes = ['forms', 'contacts'];

    /**
     * Gets the required scopes
     *
     * @return string[]
     */
    public static function getScopes()
    {
        return self::$scopes;
    }

    /**
     * Returns the OAuth Authentication Uri
     *
     * @return string
     */
    public static function getOAuthURi()
    {
        return 'https://app.hubspot.com/oauth/authorize';
    }

    /**
     * Builds the full uri for the endpoint.
     *
     * @param string $endpoint
     * @return string
     */
    private static function getUri($endpoint)
    {
        return self::$baseUri.$endpoint;
    }

    /**
     * Builds the full uri for the form related endpoint.
     *
     * @param string $endpoint
     * @return string
     */
    private static function getFormUri($endpoint)
    {
        return self::$baseUriForm.$endpoint;
    }

    /**
     * The OAuth Access Token
     *
     * @var string
     */
    private $accessToken;

    /**
     * Gets the refresh token from an authorization code
     *
     * @param string $code
     * @return string|null
     */
    public function getRefreshToken($code)
    {
        if (! config('services.hubspot.api.enabled')) {
            return null;
        }

        try {
            $client = new GuzzleClientWrapper();
            $response = $client->request('POST', self::getUri('/oauth/v1/token'), [
                'form_params' => [
                    'grant_type'    => 'authorization_code',
                    'client_id'     => config('services.hubspot.api.client_id'),
                    'client_secret' => config('services.hubspot.api.client_secret'),
                    'code'          => $code,
                    'redirect_uri'  => route('oauth::hubspot'),
                ],
            ]);

            $this->accessToken = json_decode($response->getBody())->access_token;

            return json_decode($response->getBody())->refresh_token;
        } catch (RequestException $ex) {
            throw HubSpotException::fromGuzzleException($ex);
        }
    }

    /**
     * Gets the access token
     *
     * @return null|string
     */
    public function getAccessToken()
    {
        if (! config('services.hubspot.api.enabled')) {
            return null;
        }

        if (! $this->accessToken) {
            try {
                $client = new GuzzleClientWrapper();
                $response = $client->request('POST', self::getUri('/oauth/v1/token'), [
                    'form_params' => [
                        'grant_type'    => 'refresh_token',
                        'client_id'     => config('services.hubspot.api.client_id'),
                        'client_secret' => config('services.hubspot.api.client_secret'),
                        'refresh_token' => config('services.hubspot.api.refresh_token'),
                        'redirect_uri'  => route('oauth::hubspot'),
                    ],
                ]);

                $this->accessToken = json_decode($response->getBody())->access_token;
            } catch (RequestException $ex) {
                throw HubSpotException::fromGuzzleException($ex);
            }
        }

        return $this->accessToken;
    }

    /**
     * The Authorization HTTP Header to be added to each request
     *
     * @return array
     */
    protected function getAuthorizationHeader()
    {
        return ['Authorization' => 'Bearer '.$this->getAccessToken()];
    }

    /**
     * Returns the currently active forms
     *
     * @return array
     */
    public function getForms()
    {
        if (! config('services.hubspot.api.enabled')) {
            return null;
        }

        try {
            $client = new GuzzleClientWrapper();
            $response = $client->request('GET', self::getUri('/forms/v2/forms'), [
                'headers' => $this->getAuthorizationHeader(),
            ]);

            return json_decode($response->getBody());
        } catch (RequestException $ex) {
            throw HubSpotException::fromGuzzleException($ex);
        }
    }

    /**
     * Submits a Form to the API
     *
     * @param string $formId
     * @param array  $data
     * @return null
     */
    public function submitForm($formId, $data)
    {
        if (! config('services.hubspot.api.enabled')) {
            return null;
        }

        try {
            $client = new GuzzleClientWrapper();
            $response = $client->request('POST', self::getFormUri('/uploads/form/v2/'.config('services.hubspot.api.portal_id').'/'.$formId), [
                'headers'     => $this->getAuthorizationHeader(),
                'form_params' => $data,
            ]);
        } catch (RequestException $ex) {
            throw HubSpotException::fromGuzzleException($ex);
        }
    }
}
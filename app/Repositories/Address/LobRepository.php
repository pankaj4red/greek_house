<?php

namespace App\Repositories\Address;

use App\Exceptions\AddressValidationException;
use App\Logging\Logger;
use Lob\Exception\ResourceNotFoundException;
use Lob\Lob;

class LobRepository
{
    const SUCCESS = 200;

    const UNAUTHORIZED = 401;

    const FORBIDDEN = 403;

    const NOT_FOUND = 404;

    const BAD_REQUEST = 422;

    const TOO_MANY_REQUESTS = 429;

    const SERVER_ERROR = 500;

    protected $enabled = true;

    protected $client = null;

    public function __construct()
    {
        $this->enabled = config('services.lob.enabled') == '1' ? true : false;
        $this->client = new Lob(config('services.lob.key') ? config('services.lob.key') : 'N/A');
    }

    public function verifyAddress($data)
    {
        if ($this->enabled == false) {
            return true;
        }
        try {
            if ($data['country'] == 'usa') {
                $parameters = [
                    'address_line1' => $data['line1'],
                    'address_line2' => $data['line2'],
                    'address_city'  => $data['city'],
                    'address_state' => $data['state'],
                    'address_zip'   => $data['zip_code'],
                    'address_us'    => 'us',
                ];

                $logId = Logger::logApi('Lob', $parameters);
                $response = $this->client->addresses()->verify($parameters);
                if (isset($response['message'])) {
                    throw new AddressValidationException($response['message']);
                } else {
                    Logger::logApiResponse($logId, json_encode($response));
                }
            }

            return true;
        } catch (ResourceNotFoundException $ex) {
            Logger::logError($ex);
            throw new AddressValidationException($ex->getMessage());
        }
    }
}

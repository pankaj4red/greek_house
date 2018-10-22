<?php

namespace App\Http\Controllers\Customer\Blocks;

use App;
use App\Helpers\AccessToken\AccessTokenManager;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CustomerDetailsController extends Controller
{
    /** @var AccessTokenManager $accessTokenManager */
    protected $accessTokenManager;

    /**
     * BlockController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
        $this->accessTokenManager = App::make(AccessTokenManager::class);
    }

    public function handlePopup($id)
    {
        if (! $this->accessTokenManager->hasToken('customer_information.show_information')) {
            throw new HttpException(403, 'Access Denied');
        }

        return $this->getPopup($id);
    }

    public function getPopup($id)
    {
        return view('blocks.popup.customer_details', [
            'user' => user_repository()->find($id),
        ]);
    }
}

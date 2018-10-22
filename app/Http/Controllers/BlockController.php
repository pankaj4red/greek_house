<?php

namespace App\Http\Controllers;

use App;
use App\Helpers\AccessToken\AccessTokenManager;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

abstract class BlockController extends Controller
{
    /** @var AccessTokenManager $accessTokenManager */
    protected $accessTokenManager;

    /** @var string[] $parameters */
    protected $parameters = [];

    /** @var integer $campaignId */
    protected $campaignId;

    /** @var Campaign $campaignInstance */
    protected $campaignInstance;

    /**
     * BlockController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
        $this->accessTokenManager = App::make(AccessTokenManager::class);
    }

    /**
     * Returns the snake case name of the controller
     *
     * @return string
     */
    protected function getBlockName()
    {
        $blockNameParts = explode('_', snake_case(class_basename($this)));
        array_splice($blockNameParts, count($blockNameParts) - 1, 1);

        return implode('_', $blockNameParts);
    }

    /**
     * @return bool
     */
    public function isVisible()
    {
        return (bool) $this->accessTokenManager->getToken($this->getBlockName(), 'view');
    }

    /**
     * @return bool
     */
    public function canBeAccessed()
    {
        return (bool) $this->accessTokenManager->getToken($this->getBlockName());
    }

    /**
     * @throws HttpException
     */
    public function forceVisible()
    {
        if (! $this->isVisible()) {
            throw new HttpException(403, 'Access Denied');
        }
    }

    /**
     * @param string|null $token
     * @throws HttpException
     */
    protected function forceCanBeAccessed($token = null)
    {
        if (! $this->canBeAccessed()) {
            throw new HttpException(403, 'Access Denied');
        }

        if ($token && ! $this->accessTokenManager->hasToken($this->getBlockName(), $token)) {
            throw new HttpException(403, 'Access Denied');
        }
    }

    protected function hasToken($token)
    {
        return $this->accessTokenManager->hasToken($this->getBlockName(), $token);
    }

    /**
     * @param integer  $campaignId
     * @param string[] $parameters
     * @param string[] $subTokens
     * @return $this
     */
    public function configure($campaignId, $parameters, $subTokens = [])
    {
        $this->campaignId = $campaignId;
        $this->parameters = array_merge($parameters, $subTokens, [
            'blockName' => $this->getBlockName(),
            'blockUrl'  => route('customer_block', [$this->getBlockName(), $this->campaignId]),
            'popupUrl'  => route('customer_block_popup', [$this->getBlockName(), $this->campaignId]),
        ]);

        $this->accessTokenManager->addToken($this->getBlockName());
        foreach ($subTokens as $subToken => $value) {
            $this->accessTokenManager->addToken($this->getBlockName(), $subToken, $value);
        }
        $this->accessTokenManager->addToken($this->getBlockName(), 'edit', $this->parameters['edit']);
        $this->accessTokenManager->addToken($this->getBlockName(), 'view', $this->parameters['view']);

        return $this;
    }

    protected function configureCallback()
    {
        foreach ($this->accessTokenManager->getSubTokens($this->getBlockName()) as $subToken => $value) {
            $this->parameters[$subToken] = $value;
        }
    }

    /**
     * @return Campaign
     */
    public function getCampaign()
    {
        if (! $this->campaignInstance) {
            $this->campaignInstance = campaign_repository()->find($this->campaignId);
        }

        return $this->campaignInstance;
    }

    /**
     * @param string $key
     * @return string
     */
    public function getParameter($key)
    {
        return $this->parameters[$key];
    }

    /**
     * Block GET handle
     *
     * @return string
     */
    public function handleBlock()
    {
        return $this->isVisible() ? $this->block() : '';
    }

    /**
     * @return string
     */
    abstract public function block();

    /**
     * @param integer $id
     * @param Request $request
     * @return string
     */
    public function handlePostBlock($id, Request $request)
    {
        $this->forceCanBeAccessed();
        $this->forceVisible();

        $this->campaignId = $id;
        $campaign = $this->getCampaign();
        if (! $campaign) {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException('Unknown Campaign: '.$id);
        }
        $this->configureCallback();

        return $this->postBlock($id, $request);
    }

    /**
     * Block POST handle
     *
     * @param integer $id
     * @param Request $request
     * @return string
     */
    public function postBlock($id, Request $request)
    {
        return '';
    }

    /**
     * @param integer $id
     * @return string
     */
    public function handlePopup($id)
    {
        $this->forceCanBeAccessed();
        $this->forceVisible();

        $this->campaignId = $id;
        $campaign = $this->getCampaign();
        if (! $campaign) {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException('Unknown Campaign: '.$id);
        }
        $this->configureCallback();

        return $this->getPopup($id);
    }

    /**
     * Popup GET handle
     *
     * @param integer $id
     * @return string
     */
    public function getPopup($id)
    {
        return '';
    }

    /**
     * @param integer $id
     * @param Request $request
     * @return string
     */
    public function handlePostPopup($id, Request $request)
    {
        $this->forceCanBeAccessed();
        $this->forceVisible();

        $this->campaignId = $id;
        $campaign = $this->getCampaign();
        if (! $campaign) {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException('Unknown Campaign: '.$id);
        }
        $this->configureCallback();

        return $this->postPopup($id, $request);
    }

    /**
     * Popup POST handle
     *
     * @param integer $id
     * @param Request $request
     * @return string
     */
    public function postPopup($id, Request $request)
    {
        return '';
    }

    /**
     * @param string  $method
     * @param integer $id
     * @param Request $request
     * @return string
     */
    public function handlePostMethod($method, $id, Request $request)
    {
        $this->forceCanBeAccessed();
        $this->forceVisible();

        $this->campaignId = $id;
        $campaign = $this->getCampaign();
        if (! $campaign) {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException('Unknown Campaign: '.$id);
        }
        $this->configureCallback();

        return $this->{'post'.$method}($id, $request);
    }

    /**
     * @param string  $method
     * @param integer $id
     * @return string
     */
    public function handleGetMethod($method, $id, Request $request)
    {
        $this->forceCanBeAccessed();
        $this->forceVisible();

        $this->campaignId = $id;
        $campaign = $this->getCampaign();
        if (! $campaign) {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException('Unknown Campaign: '.$id);
        }
        $this->configureCallback();

        return $this->{'get'.$method}($id, $request);
    }

    /**
     * @param string     $view
     * @param array|null $parameters
     * @return string
     * @throws \Throwable
     */
    public function view($view, $parameters = [])
    {
        return view($view, array_merge($this->parameters, $parameters, ['campaign' => $this->getCampaign(), 'back' => without_query_string(redirect()->back()->getTargetUrl())]))->render();
    }

    protected function getSizeTable(Campaign $campaign)
    {
        // Size Table Object
        $sizeTable = (object) [
            'suppliers'           => supplier_repository()->all(),
            'sizes'               => [], // All the sizes
            'product_color_sizes' => [], // Sizes filtered by Product Color
            'lines'               => [],
            'total'               => 0,
            'quantity'            => 0,
            'products'            => [],
        ];

        /**
         * Sizes
         */
        // Initiates
        $campaignSizes = $this->getCampaignProductSizes($campaign);
        foreach ($campaignSizes as $short) {
            $sizeTable->sizes[$short] = 0;
        }

        // Sets quantity
        foreach ($campaign->success_orders as $order) {
            foreach ($order->entries as $orderEntry) {
                $sizeTable->sizes[$orderEntry->size->short] += $orderEntry->quantity;
            }
        }

        // Removes unused
        foreach ($sizeTable->sizes as $garmentSizeShort => $quantity) {
            if ($quantity == 0) {
                unset($sizeTable->sizes[$garmentSizeShort]);
            }
        }

        /**
         * Product Colors
         */
        // Initiates
        $campaignColors = $this->getCampaignProductColors($campaign);
        foreach ($campaignColors as $productColorId) {
            $productColor = product_color_repository()->find($productColorId);

            // Initiates sizes for each product color
            $sizeTable->product_color_sizes[$productColor->id] = $sizeTable->sizes;
            foreach ($sizeTable->product_color_sizes[$productColor->id] as $key => $value) {
                $sizeTable->product_color_sizes[$productColor->id][$key] = 0;
            }

            // Initiates information on the products
            if (! isset($sizeTable->products[$productColor->product_id])) {
                $sizeTable->products[$productColor->product_id] = (object) [
                    'id'     => $productColor->product_id,
                    'name'   => $productColor->product->style_number,
                    'colors' => [],
                ];
            }

            // Adds the product color to the product
            $sizeTable->products[$productColor->product_id]->colors[$productColor->id] = (object) [
                'id'   => $productColor->id,
                'name' => $productColor->name,
            ];
        }

        // Sets
        foreach ($campaign->success_orders as $order) {
            foreach ($order->entries as $orderEntry) {
                $sizeTable->product_color_sizes[$orderEntry->product_color_id][$orderEntry->size->short] += $orderEntry->quantity;
                $sizeTable->quantity += $orderEntry->quantity;
            }
            $sizeTable->total += $order->subtotal;
        }

        /**
         * Supplies
         */
        // Add Lines
        if ($campaign->supplies->count() > 0) {
            // Existing Lines

            foreach ($campaign->supplies as $supply) {
                $line = (object) [
                    'id'        => $supply->id,
                    'product'   => $supply->product_color->product_id,
                    'color'     => $supply->product_color_id,
                    'sizes'     => [],
                    'eta'       => $supply->eta,
                    'ship_from' => $supply->ship_from,
                    'supplier'  => $supply->supplier_id,
                    'quantity'  => $supply->quantity,
                    'total'     => $supply->total,
                    'state'     => $supply->state,
                    'error'     => $supply->nok_reason,
                ];

                foreach ($supply->entries as $supplyEntry) {
                    if (! isset($line->sizes[$supplyEntry->size->short])) {
                        $line->sizes[$supplyEntry->size->short] = 0;
                    }
                    $line->sizes[$supplyEntry->size->short] += $supplyEntry->quantity;
                }

                $sizeTable->lines[] = $line;
            }
        } else {
            // Default Lines

            foreach ($campaign->success_orders as $order) {
                foreach ($order->entries as $orderEntry) {
                    if (! isset($sizeTable->lines[$orderEntry->product_color_id])) {
                        $sizeTable->lines[$orderEntry->product_color_id] = (object) [
                            'id'            => null,
                            'product'       => $orderEntry->product_color->product_id,
                            'product_color' => $orderEntry->product_color_id,
                            'sizes'         => [],
                            'eta'           => '',
                            'ship_from'     => '',
                            'supplier'      => null,
                            'quantity'      => 0,
                            'total'         => 0,
                            'state'         => 'new',
                            'error'         => '',
                        ];

                        $sizeTable->lines[$orderEntry->product_color_id]->sizes = $sizeTable->product_color_sizes[$orderEntry->product_color_id];
                        $sizeTable->lines[$orderEntry->product_color_id]->quantity = array_sum($sizeTable->product_color_sizes[$orderEntry->product_color_id]);
                        $sizeTable->lines[$orderEntry->product_color_id]->total = $sizeTable->lines[$orderEntry->product_color_id]->quantity * $orderEntry->price;
                    }
                }
            }
        }

        return $sizeTable;
    }

    /**
     * @param \App\Models\Campaign $campaign
     * @return int|array
     */
    private function getCampaignProductColors(Campaign $campaign)
    {
        $campaignColors = [];
        foreach ($campaign->product_colors as $productColor) {
            $campaignColors[] = $productColor->id;
        }

        foreach ($campaign->orders as $order) {
            foreach ($order->entries as $entry) {
                $campaignColors[] = $entry->product_color_id;
            }
        }

        foreach ($campaign->supplies as $supply) {
            $campaignColors[] = $supply->product_color_id;
        }

        return array_unique($campaignColors);
    }

    /**
     * @param \App\Models\Campaign $campaign
     * @return int|array
     */
    private function getCampaignProductSizes(Campaign $campaign)
    {
        $campaignSizes = [];
        foreach ($campaign->product_colors as $productColor) {
            foreach ($productColor->product->sizes as $productSize) {
                $campaignSizes[] = $productSize->size->short;
            }
        }

        foreach ($campaign->orders as $order) {
            foreach ($order->entries as $entry) {
                $campaignSizes[] = $entry->size->short;
            }
        }

        foreach ($campaign->supplies as $supply) {
            foreach ($supply->entries as $entry) {
                $campaignSizes[] = $entry->size->short;
            }
        }

        return array_unique($campaignSizes);
    }
}

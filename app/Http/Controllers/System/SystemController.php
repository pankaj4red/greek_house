<?php

namespace App\Http\Controllers\System;

use App\Exceptions\QuoteException;
use App\Http\Controllers\Controller;
use App\Logging\Logger;
use App\Models\Design;
use App\Models\DesignTag;
use App\Quotes\EmbroideryQuote;
use App\Quotes\QuoteGenerator;
use App\Quotes\ScreenPrinterQuote;
use App\Repositories\Salesforce\SalesforceRepositoryFactory;
use Crunch\Salesforce\AccessTokenGenerator;
use Illuminate\Http\Request;

class SystemController extends Controller
{
    private function getCacheOptions()
    {
        $options = [
            'max_age'       => 259200,
            'public'        => true,
            'last_modified' => new \DateTime('2016-01-01'),
        ];

        return $options;
    }

    public function getImage(Request $request, $id = null)
    {
        if ($id == null) {
            return response()->make(file_get_contents(getcwd().'/images/not_available.png'))->header('Content-Type', 'image/png')->header('Content-Transfer-Encoding', 'binary')->setCache($this->getCacheOptions());
        }
        if ($request->headers->has('If-Modified-Since')) {
            return response('', 304)->setCache($this->getCacheOptions());
        }

        $watermark = false;

        if ($id < 531274) {
            $image = file_repository()->find($id);
        } elseif ($id < 630820) {
            $id = $id - 531274;
            $image = file_repository()->find($id);
            $watermark = true;
        } else {
            $id = $id - 630820;
            $image = file_repository()->find($id);
            $watermark = true;
        }

        if ($image) {
            $content = $image->getContent($watermark)->content;

            if (! $content) {
                return response()->make(file_get_contents(getcwd().'/images/not_available.png'))->header('Content-Type', 'image/png')->header('Content-Transfer-Encoding', 'binary')->setCache($this->getCacheOptions());
            }

            return response()->make($content)->header('Content-Type', 'image/png')->header('Content-Transfer-Encoding', 'binary')->setCache($this->getCacheOptions());
        } else {
            return response()->make(file_get_contents(getcwd().'/images/not_available.png'))->header('Content-Type', 'image/png')->header('Content-Transfer-Encoding', 'binary')->setCache($this->getCacheOptions());
        }
    }

    public function getImageDownload(Request $request, $id = null)
    {
        if ($id == null) {
            return response()->make(file_get_contents(getcwd().'/images/not_available.png'), 404, [
                'Content-Type'              => 'image/png',
                'Content-Transfer-Encoding' => 'binary',
                'Content-Disposition'       => 'inline; filename="'.'not_available.ong'.'"',
            ])->setCache($this->getCacheOptions());
        }
        if ($request->headers->has('If-Modified-Since')) {
            return response('', 304)->setCache($this->getCacheOptions());
        }

        $watermark = false;

        if ($id < 531274) {
            $image = file_repository()->find($id);
        } else {
            $id = $id - 531274;
            $image = file_repository()->find($id);
            $watermark = true;
        }

        if ($image) {
            $content = $image->getContent($watermark)->content;

            return response()->make($content, 200, [
                'Content-Type'              => 'image/png',
                'Content-Transfer-Encoding' => 'binary',
                'Content-Description: File Transfer',
                'Content-Disposition'       => 'download; filename="'.addslashes($image->name).'"',
            ])->setCache($this->getCacheOptions());
        } else {
            return response()->make(file_get_contents(getcwd().'/images/not_available.png'), 404, [
                'Content-Type'              => 'image/png',
                'Content-Transfer-Encoding' => 'binary',
                'Content-Disposition'       => 'inline; filename="'.'not_available.ong'.'"',
            ])->setCache($this->getCacheOptions());
        }
    }

    public function getProductColors($id)
    {
        $product = product_repository()->find($id);
        if ($product == null) {
            return response()->json([
                'success' => false,
                'errors'  => ['Unknown Product'],
            ]);
        } else {
            $product = product_repository()->find($id);

            return response()->json([
                'success' => true,
                'colors'  => $product->colors->toArray(),
            ]);
        }
    }

    public function getFile($id)
    {
        $file = file_repository()->find($id);
        if ($file == null) {
            abort(404);
        }
        $content = $file->getContent()->content;

        header('Content-Disposition: attachment; filename="'.$file->name.'"');
        header("Cache-control: private");
        header("Content-type: application/pdf");
        header("Content-transfer-encoding: binary\n");

        return $content;
    }

    public function getGarmentCategory($genderId)
    {
        return response()->json([
            'success'    => true,
            'categories' => garment_category_repository()->getByGenderId($genderId),
        ]);
    }

    public function getGarmentBrand($genderId, $categoryId)
    {
        return response()->json([
            'success'  => true,
            'products' => product_repository()->getByGenderIdAndCategoryId($genderId, $categoryId),
        ]);
    }

    public function quote($type, $data)
    {
        switch ($type) {
            case 'screen':
                if (isset($data['pid']) && $data['pid']) {
                    $productId = $data['pid'];
                    $product = product_repository()->find($productId);
                    if ($product == null) {
                        return [
                            'success' => false,
                            'errors'  => [
                                'Product must be valid',
                            ],
                        ];
                    }
                    $productName = $product->name;
                    $productPrice = $product->price;
                } elseif (isset($data['pn']) && isset($data['pp'])) {
                    $productName = $data['pn'];
                    $productPrice = $data['pp'];
                } else {
                    return [
                        'success' => false,
                        'errors'  => [
                            'Request must contain either product id or product price information',
                        ],
                    ];
                }

                $quote = new ScreenPrinterQuote();
                $quote->quote([
                    'product_name'            => $productName,
                    'product_cost'            => $productPrice,
                    'color_front'             => isset($data['cf']) ? $data['cf'] : 0,
                    'color_back'              => isset($data['cb']) ? $data['cb'] : 0,
                    'color_left'              => isset($data['cl']) ? $data['cl'] : 0,
                    'color_right'             => isset($data['cr']) ? $data['cr'] : 0,
                    'black_shirt'             => isset($data['bs']) ? $data['bs'] : 0,
                    'estimated_quantity_from' => $data['eqf'],
                    'estimated_quantity_to'   => $data['eqt'],
                    'design_hours'            => isset($data['dh']) ? $data['dh'] : null,
                    'markup'                  => isset($data['mu']) ? $data['mu'] : null,
                    'product_count'           => isset($data['pc']) ? $data['pc'] : null,
                ]);
                if ($quote->isSuccess()) {
                    return [
                        'success' => true,
                        'quote'   => $quote->toArray(),
                    ];
                } else {
                    return [
                        'success' => false,
                        'errors'  => $quote->getErrors(),
                    ];
                }
                break;
            case 'embroidery':
                if (isset($data['pid']) && $data['pid']) {
                    $productId = $data['pid'];
                    $product = product_repository()->find($productId);
                    if ($product == null) {
                        return [
                            'success' => false,
                            'errors'  => [
                                'Product must be valid',
                            ],
                        ];
                    }
                    $productName = $product->name;
                    $productPrice = $product->price;
                } elseif (isset($data['pn']) && isset($data['pp'])) {
                    $productName = $data['pn'];
                    $productPrice = $data['pp'];
                } else {
                    return [
                        'success' => false,
                        'errors'  => [
                            'Request must contain either product id or product price information',
                        ],
                    ];
                }

                $quote = new EmbroideryQuote();
                $quote->quote([
                    'product_name'            => $productName,
                    'product_cost'            => $productPrice,
                    'estimated_quantity_from' => $data['eqf'],
                    'estimated_quantity_to'   => $data['eqt'],
                    'design_hours'            => isset($data['dh']) ? $data['dh'] : null,
                    'markup'                  => isset($data['mu']) ? $data['mu'] : null,
                    'product_count'           => isset($data['pc']) ? $data['pc'] : null,
                ]);

                if ($quote->isSuccess()) {
                    return [
                        'success' => true,
                        'quote'   => $quote->toArray(),
                    ];
                } else {
                    return [
                        'success' => false,
                        'errors'  => $quote->getErrors(),
                    ];
                }
        }

        return [
            'success' => false,
        ];
    }

    public function getManagerQuickQuote($type, Request $request)
    {
        if (! \Auth::user() || ! \Auth::user()->isType(['admin', 'support'])) {
            Logger::logNotice('#QuickQuote #AccessDenied #System');

            return response()->json([
                'success' => false,
                'errors'  => ['access denied'],
            ]);
        }
        $quote = $this->quote($type, $request->all());

        return response()->json($quote);
    }

    public function getQuickQuote($type, Request $request)
    {
        try {
            $quote = QuoteGenerator::quickSimpleQuote($type, $request->get('pid'), $request->get('cf'), $request->get('cb'), 0, 0, $request->get('eqf'));

            return response()->json([
                'success' => true,
                'quote'   => [
                    'price_unit'  => [$quote->getPricePerUnitFrom(), $quote->getPricePerUnitTo()],
                    'price_total' => [$quote->getPriceTotalFrom(), $quote->getPriceTotalTo()],
                ],
            ]);
        } catch (QuoteException $ex) {
            return response()->json([
                'success' => false,
                'message' => 'Unknown Product',
            ]);
        }
    }

    public function getDesignGalleryRecent(Request $request)
    {
        $tags = array_values(array_filter(explode(',', $request->get('tags'))));

        if (count($tags) > 0) {
            $recent = design_repository()->getSearch($tags);
        } else {
            $recent = design_repository()->getRecent($request->get('page') ?? 0, $request->get('pageSize') ?? 16);
        }

        $recentArray = [];
        /** @var Design $design */
        foreach ($recent as $design) {
            $recentArray[] = [
                'id'        => $design->id,
                'name'      => $design->name,
                'thumbnail' => route('system::image', [get_image_id($design->getThumbnail(), true)]),
                'link'      => route('home::design_gallery').'/'.$design->id,
                'info'      => $design->getInfo(),
            ];
        }

        return response()->json([
            'data' => $recentArray,
        ]);
    }

    public function getDesignGalleryRelated($id)
    {
        $design = design_repository()->find($id);

        $related = $design->getRelated();

        $relatedArray = [];
        /** @var Design $design */
        foreach ($related as $design) {
            $relatedArray[] = [
                'id'        => $design->id,
                'name'      => $design->name,
                'thumbnail' => route('system::image', [get_image_id($design->getThumbnail(), true)]),
                'link'      => route('home::design_gallery').'/'.$design->id,
            ];
        }

        return response()->json([
            'data' => $relatedArray,
        ]);
    }

    public function getDesignGalleryTrending(Request $request)
    {
        $trending = design_repository()->getTrending($request->get('period'));

        $trendingArray = [];
        /** @var Design $design */
        foreach ($trending as $design) {
            $trendingArray[] = [
                'id'           => $design->id,
                'name'         => $design->name,
                'thumbnail_id' => $design->thumbnail_id,
                'info'         => $design->getInfo(),
            ];
        }

        return response()->json([
            'data' => $trendingArray,
        ]);
    }

    public function getDesignGalleryTagSearch(Request $request)
    {
        $tags = design_tag_repository()->search($request->get('group'), $request->get('text'), $request->get('page'));

        $tagsArray = [];
        /** @var DesignTag $tag */
        foreach ($tags as $tag) {
            $tagsArray[] = [
                'id'    => $tag->name,
                'text'  => $tag->name,
                'group' => $tag->group,
            ];
        }

        return response()->json([
            'data' => $tagsArray,
        ]);
    }

    public function getAutocompleteSchool(Request $request)
    {
        $schools = school_repository()->getListing(['filter_school' => $request->get('term')], ['name', 'asc'], 0, 10);
        $results = [];
        foreach ($schools as $school) {
            $results[] = [
                'value' => $school->name,
                'data'  => $school->id,
            ];
        }

        return response()->json($results);
    }

    public function getAutocompleteChapter(Request $request, $school = '')
    {
        $chapters = chapter_repository()->getListing([
            'filter_school'  => $school,
            'filter_chapter' => $request->get('term'),
        ], ['name', 'asc'], 0, 10);
        $results = [];
        foreach ($chapters as $chapter) {
            $results[] = [
                'value' => $chapter->name,
                'data'  => $chapter->id,
            ];
        }

        return response()->json($results);
    }

    public function getAutocompleteUser(Request $request)
    {
        $users = user_repository()->getListing(['filter_name' => $request->get('term')], [['first_name', 'asc'], ['last_name', 'asc']], 0, 10);
        $results = [];
        foreach ($users as $user) {
            $results[] = [
                'value' => '['.$user->id.'] '.$user->getFullName(),
                'id'    => $user->id,
                'name'  => $user->getFullName(),
            ];
        }

        return response()->json($results);
    }

    public function getHash($id)
    {
        $order = order_repository()->find($id);
        if ($order == null) {
            return response()->json([
                'success' => false,
            ]);
        }
        $timestamp = time();

        return response()->json([
            'success'      => true,
            'fp_timestamp' => $timestamp,
            'fp_sequence'  => $id,
            'fp_hash'      => hash_hmac('md5', config('greekhouse.billing.providers.authorize.login').'^'.$order->id.'^'.$timestamp.'^'.number_format($order->total, 2, '.', '').'^USD', config('greekhouse.billing.providers.authorize.key')),
        ]);
    }

    public function getEstimatedQuantities($type)
    {
        return response()->json(['estimated_quantity_options' => estimated_quantity_options($type)]);
    }

    public function getSalesforceOauth(Request $request)
    {
        $sfClient = SalesforceRepositoryFactory::get()->getClient();
        if (! $request->get('code')) {
            $url = $sfClient->getLoginUrl(config('services.salesforce.'.config('services.salesforce.mode').'.oauth_url'));
            header('Location: '.$url);
            exit();
        } else {
            $token = $sfClient->authorizeConfirm($request->get('code'), config('services.salesforce.'.config('services.salesforce.mode').'.oauth_url'));
            $tokenGenerator = new AccessTokenGenerator();
            $accessToken = $tokenGenerator->createFromSalesforceResponse($token);
        }
    }
}

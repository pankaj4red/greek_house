<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function getIndex(Request $request)
    {
        //print_r(slider_image_repository()->getListing()); exit;
        return view('v2.home.home.index', [
            'designs' => design_repository()->getListing([], ['id', 'desc'], null, 8),
            'images'  => slider_image_repository()->getListing(null, 'priority'),
        ]);
    }

    public function getRefunds()
    {
        return view('home.refunds');
    }

    public function getDesignGallery($id = null, Request $request)
    {
        $tags = array_values(array_filter(explode(',', $request->get('tags') ?? '')));

        $period = $request->get('period') ?? 'all';
        $trending = design_repository()->getTrending($period);
        $recent = design_repository()->getRecent(0, 16);
        $results = count($tags) > 0 ? design_repository()->getSearch($tags) : collect();

        return view('v3.home.design_gallery.design_gallery', [
            'tags'          => collect($tags),
            'trending'      => $trending,
            'results'       => $results,
            'recent'        => $recent,
            'designDisplay' => $id ? design_repository()->find($id) : null,
            'period'        => $period,
        ]);
    }

    public function getAjaxDesignRelated($id)
    {
        $design = design_repository()->find($id);
        if (! $design) {
            return [];
        }
        $related = $design->getInfoRelated();

        return response()->json($related);
    }

    public function getTos()
    {
        return view('home.tos');
    }

    public function getPrivacy()
    {
        return view('home.privacy');
    }

    public function getAboutUs()
    {
        return view('v2.home.home.about_us');
    }

    public function facebookExistingUserTrack()
    {

        $campaigns = campaign_repository()->newQuery()->get();

        $orders = order_repository()->newQuery()->get();

        return view('v2.home.home.facebook_tracker', [
            'campaigns' => $campaigns,
            'orders'    => $orders,

        ]);
    }
}

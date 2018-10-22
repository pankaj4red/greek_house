<?php

namespace App\Http\Controllers\Home;

use App\Events\Campaign\CampusApprovalRequired;
use App\Events\Campaign\FullyCreated;
use App\Exceptions\HubSpotException;
use App\Forms\AllUploadHandler;
use App\Forms\FileUploadHandler;
use App\Helpers\OnHold\OnHoldEngine;
use App\Http\Controllers\Controller;
use App\Logging\Logger;
use App\Services\HubSpot;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Session;

class WizardController extends Controller
{
    private function hasCampaignLead()
    {
        return Session::has('campaign_lead_id') && campaign_lead_repository()->find(Session::has('campaign_lead_id'));
    }

    private function createCampaignLead($designId = null)
    {
        $campaignLead = campaign_lead_repository()->make();
        $campaignLead->user_id = Auth::user() ? Auth::user()->id : null;
        if ($designId) {
            $campaignLead->category_id = garment_category_repository()->firstActive()->id;
            $campaignLead->source_design_id = $designId;
            $campaignLead->image1_id = design_repository()->find($designId)->images->first()->file_id;
        }
        if (Auth::user()) {
            $campaignLead->contact_first_name = Auth::user()->first_name;
            $campaignLead->contact_last_name = Auth::user()->last_name;
            if (Auth::user()->address) {
                $campaignLead->address_option = Auth::user()->address->id;
                $campaignLead->address_line1 = Auth::user()->address->line1;
                $campaignLead->address_line2 = Auth::user()->address->line2;
                $campaignLead->address_city = Auth::user()->address->city;
                $campaignLead->address_state = Auth::user()->address->state;
                $campaignLead->address_zip_code = Auth::user()->address->zip_code;
            }
        }
        $campaignLead->save();
        Session::put('campaign_lead_id', $campaignLead->id);
    }

    private function getCampaignLead()
    {
        return campaign_lead_repository()->find(Session::get('campaign_lead_id'));
    }

    public function getStart(Request $request, $designId = null)
    {
        store_wizard_start_url($request);
        $this->createCampaignLead($designId);
        Session::keep('errors');

        return form()->route('wizard::product');
    }

    public function getProduct(Request $request, $id = null, $mode = 'category')
    {
        if (! $this->hasCampaignLead()) {
            $this->createCampaignLead();
        }

        if (! $this->hasNecessaryInformation('product', 'get')) {
            return $this->redirectDueToNotHavingNecessaryInformation('product', 'get');
        }

        $productId = null;
        $product = null;
        $categoryId = null;
        $category = null;
        $topProducts = [];
        $search = $request->get('q');

        if ($mode == 'product') {
            // User is selecting a product
            $productId = $id ? get_product_id_from_description($id) : null;

            // Select Product
            $product = product_repository()->find($productId);
            $categoryId = $product->garment_category_id;
        } else {
            // User is listing products in a category
            $categoryId = $id ? get_category_id_from_description($id) : null;

            if (! $categoryId) {
                // If no category is selected, select the first one available
                $categoryId = $this->getCampaignLead()->category_id ?? (garment_category_repository()->firstWizardDefault() ? garment_category_repository()->firstWizardDefault()->id : garment_category_repository()->firstActive()->id);
            }
        }

        // Filter by Gender
        $gender = $request->get('g') ?? 'a';
        $genderModel = null;
        if ($gender != 'a') {
            $genderModel = garment_gender_repository()->findByCode($gender);
        }

        $products = product_repository()->getByGenderIdAndCategoryIdAndAll($genderModel ? $genderModel->id : null, $categoryId);
        if (empty($search)) {
            $topProducts = product_repository()->getTopProductsByCategory($categoryId, 4);
        }

        $filteredProducts = [];
        if (! empty($search)) {
            $count = 0;
            foreach ($products as $val) {

                if (! $search || is_search_match($val->name, $search) || is_search_match($val->style_number, $search)) {
                    $strength = search_strength($val->name, $search);
                    if ($val->garment_category_id == $categoryId && ! empty($search) && $strength > 0) {
                        $strength += 10;
                    }
                    if ((! empty($search) && $strength > 0) || ($val->garment_category_id == $categoryId)) {
                        $filteredProducts[$count]['product'] = $val;
                        $filteredProducts[$count]['strength'] = $strength;
                        $count++;
                    }
                }
            }
        } else {
            $count = 0;
            foreach ($products as $val) {
                $filteredProducts[$count]['product'] = $val;
                $filteredProducts[$count]['strength'] = 0;
                $count++;
            }
        }
        $filteredProducts = collect($filteredProducts)->sortByDesc(function ($product, $key) {
            return $product['strength'];
        })->toArray();

        $products = [];
        foreach ($topProducts as $val) {
            $topProduct = product_repository()->find($val->product_id);
            $products[$val->product_id] = $topProduct;
        }
        foreach ($filteredProducts as $val) {
            if (! array_key_exists($val['product']->id, $products)) {
                $products[$val['product']->id] = $val['product'];
            }
        }
        $category = garment_category_repository()->find($categoryId);

        $productColorId = null;
        $productColor = null;
        if (! $productColorId && $this->getCampaignLead()->product_colors->first() && $this->getCampaignLead()->product_colors->first()->product_id == $productId && $this->getCampaignLead()->product_colors->count() > 0) {
            $productColorId = $this->getCampaignLead()->product_colors->first()->id;
            $productColor = $this->getCampaignLead()->product_colors->first();
        }

        if ($request->get('c')) {
            $productColorId = $request->get('c');
            $productColor = product_color_repository()->find($productColorId);
            $productId = $productColor->product_id;
            $product = $productColor->product;
        }

        return view('v3.home.wizard.product', [
            'campaignLead'           => $this->getCampaignLead(),
            'selectedCategory'       => $category,
            'selectedCategoryId'     => $categoryId,
            'selectedProduct'        => $product,
            'selectedProductId'      => $productId,
            'selectedProductColorId' => $productColorId,
            'selectedProductColor'   => $productColor,
            'products'               => $products,
            'search'                 => $search,
            'gender'                 => $gender,
            'mode'                   => $mode,
        ]);
    }

    public function postProduct($id = null, Request $request)
    {
        if (! $this->hasCampaignLead()) {
            $this->createCampaignLead();
        }

        if (! $this->hasNecessaryInformation('product', 'post')) {
            return $this->redirectDueToNotHavingNecessaryInformation('product', 'post');
        }

        form($request)->validate([
            'color_id' => 'required|integer',
        ]);

        $productColor = product_color_repository()->find($request->get('color_id'));
        if (! $productColor) {
            return form()->error('Unknown Product Color')->back();
        }

        if ($this->getCampaignLead()->product_colors->where('id', $productColor->id)->count() == 0) {
            $products = $this->getCampaignLead()->product_colors->groupBy('product_id');
            if (isset($products[$productColor->product_id])) {
                if ($products[$productColor->product_id]->count() >= 4) {
                    return form()->error('This product has reached the 4 color limit!')->back();
                }
            } else {
                if ($products->count() >= 4) {
                    return form()->error('You cannot add more products!')->back();
                }
            }

            $this->getCampaignLead()->product_colors()->attach($productColor->id);
        }

        return form()->route('wizard::design');
    }

    public function getDesign()
    {
        if (! $this->hasCampaignLead()) {
            $this->createCampaignLead();
        }

        if (! $this->hasNecessaryInformation('design', 'get')) {
            return $this->redirectDueToNotHavingNecessaryInformation('design', 'get');
        }

        $designs = [];
        for ($i = 1; $i <= 12; $i++) {
            $design = new FileUploadHandler('campaign_wizard', 'design'.$i);
            $design->setFileId($this->getCampaignLead()->{'image'.$i.'_id'});
            $designs[] = $design->getFile();
        }

        return view('wizard.design', [
            'campaignLead' => $this->getCampaignLead(),
            'designs'      => $designs,

        ]);
    }

    public function postDesign(Request $request)
    {
        if (! $this->hasCampaignLead()) {
            $this->createCampaignLead();
        }

        if (! $this->hasNecessaryInformation('design', 'post')) {
            return $this->redirectDueToNotHavingNecessaryInformation('design', 'post');
        }

        $form = form($request)->withRules([
            'name' => 'required|max:250',
        ]);

        if (! $request->get('print_front') && ! $request->get('print_pocket') && ! $request->get('print_back') && ! $request->get('print_sleeve')) {
            $form->error('Please select at least one design area.');
        }
        if ($request->get('print_front') == 'on') {
            $form->withRules([
                'print_front_description' => 'required',
                'print_front_colors'      => 'required|integer|min:1',
            ]);
        }
        if ($request->get('print_pocket') == 'on') {
            $form->withRules([
                'print_pocket_description' => 'required',
                'print_pocket_colors'      => 'required|integer|min:1',
            ]);
        }
        if ($request->get('print_back') == 'on') {
            $form->withRules([
                'print_back_description' => 'required',
                'print_back_colors'      => 'required|integer|min:1',
            ]);
        }
        if ($request->get('print_sleeve') == 'on') {
            $form->withRules([
                'print_sleeve_description' => 'required',
                'print_sleeve_preferred'   => 'required|in:left,right,both',
                'print_sleeve_colors'      => 'required|integer|min:1',
            ]);
        }

        if ($form->fails()) {
            $form->validate();
        }

        $data = [
            'name'                     => $request->get('name'),
            'print_front'              => $request->get('print_front') == 'on',
            'print_front_description'  => $request->get('print_front') == 'on' ? $request->get('print_front_description') : null,
            'print_front_colors'       => $request->get('print_front') == 'on' ? $request->get('print_front_colors') : 0,
            'print_pocket'             => $request->get('print_pocket') == 'on',
            'print_pocket_description' => $request->get('print_pocket') == 'on' ? $request->get('print_pocket_description') : null,
            'print_pocket_colors'      => $request->get('print_pocket') == 'on' ? $request->get('print_pocket_colors') : 0,
            'print_back'               => $request->get('print_back') == 'on',
            'print_back_description'   => $request->get('print_back') == 'on' ? $request->get('print_back_description') : null,
            'print_back_colors'        => $request->get('print_back') == 'on' ? $request->get('print_back_colors') : 0,
            'print_sleeve'             => $request->get('print_sleeve') == 'on',
            'print_sleeve_description' => $request->get('print_sleeve') == 'on' ? $request->get('print_sleeve_description') : null,
            'print_sleeve_preferred'   => $request->get('print_sleeve_preferred'),
            'print_sleeve_colors'      => $request->get('print_sleeve') == 'on' ? $request->get('print_sleeve_colors') : 0,
        ];

        for ($i = 1; $i <= 12; $i++) {
            $design = new FileUploadHandler('campaign_wizard', 'design'.$i);
            $data['image'.$i.'_id'] = $design->post()['image'] ?? $design->post()['file'];
        }

        $this->getCampaignLead()->update($data);

        return form()->route('wizard::order');
    }

    public function getOrder()
    {
        if (! $this->hasCampaignLead()) {
            $this->createCampaignLead();
        }

        if (! $this->hasNecessaryInformation('order', 'get')) {
            return $this->redirectDueToNotHavingNecessaryInformation('order', 'get');
        }

        return view('wizard.order', [
            'campaignLead' => $this->getCampaignLead(),
        ]);
    }

    public function postOrder(Request $request)
    {
        if (! $this->hasCampaignLead()) {
            $this->createCampaignLead();
        }

        $form = form($request)->withRules([
            'product_color_tree' => 'required',
            'design_type'        => 'required|in:screen,embroidery',
            'polybag_and_label'  => 'required|yes,no',
            'estimated_quantity' => 'required',
        ]);

        if (! $this->hasNecessaryInformation('order', 'post')) {
            return $this->redirectDueToNotHavingNecessaryInformation('order', 'post');
        }

        $tree = json_decode($request->get('product_color_tree'), true);
        $productColorIds = [];
        foreach ($tree as $key => $product) {
            foreach ($product as $productColor) {
                $productColorIds[] = (int) $productColor;
            }
        }

        $this->getCampaignLead()->product_colors()->sync($productColorIds);

        $this->getCampaignLead()->update([
            'polybag_and_label'  => $request->get('polybag_and_label') == 'yes',
            'design_type'        => $request->get('design_type'),
            'estimated_quantity' => $request->get('estimated_quantity'),
        ]);

        return form()->route('wizard::delivery');
    }

    public function getDelivery()
    {
        if (! $this->hasCampaignLead()) {
            $this->createCampaignLead();
        }

        if (! $this->hasNecessaryInformation('delivery', 'get')) {
            return $this->redirectDueToNotHavingNecessaryInformation('delivery', 'get');
        }

        return view('wizard.delivery', [
            'campaignLead' => $this->getCampaignLead(),
        ]);
    }

    public function postDelivery(Request $request)
    {
        if (! $this->hasCampaignLead()) {
            $this->createCampaignLead();
        }

        if (! $this->hasNecessaryInformation('delivery', 'post')) {
            return $this->redirectDueToNotHavingNecessaryInformation('delivery', 'post');
        }

        $form = form($request)->withRules([
            'address_option'     => 'required',
            'address_first_name' => 'required|max:250',
            'address_last_name'  => 'required|max:250',
            'address_line1'      => 'required|max:250',
            'address_line2'      => 'nullable|max:250',
            'address_city'       => 'required|max:250',
            'address_state'      => 'required|max:250',
            'address_zip_code'   => 'required|digits:5',
            'flexible'           => 'required|in:yes,no',
        ]);

        if ($request->get('flexible') == 'no') {
            $form->withRules([
                'date' => 'date',
            ]);
        }

        if (! in_array($request->get('address_option'), ['save', 'dontsave'])) {
            $form->withRules([
                'address_option' => 'integer',
            ]);
        }

        if (in_array($request->get('address_option'), ['save'])) {
            $form->withRules([
                'address_name' => 'required',
            ]);
        }

        if ($form->fails()) {
            return $form->back();
        }

        if ($request->get('flexible') == 'no' && Carbon::parse($request->get('date'))->format('Y-m-d') < Carbon::parse('+12 weekdays')->format('Y-m-d')) {
            return $form->error('Selected date must be at least 12 days from now.')->back();
        } elseif ($request->get('flexible') == 'no' && Carbon::parse($request->get('date'))->format('Y-m-d') < Carbon::parse('+15 weekdays')->format('Y-m-d')) {

            if ($request->get('rush') != 'yes') {
                return $form->error('Orders within less than 15 days must be rushed.')->back();
            }
        }
        $this->getCampaignLead()->update([
            'address_option'     => $request->get('address_option'),
            'address_name'       => $request->get('address_name'),
            'contact_first_name' => $request->get('address_first_name'),
            'contact_last_name'  => $request->get('address_last_name'),
            'address_line1'      => $request->get('address_line1'),
            'address_line2'      => $request->get('address_line2'),
            'address_city'       => $request->get('address_city'),
            'address_state'      => $request->get('address_state'),
            'address_zip_code'   => $request->get('address_zip_code'),
            'address_country'    => 'usa',
            'flexible'           => $request->get('flexible'),
            'date'               => $request->get('flexible') == 'no' ? Carbon::parse($request->get('date'))->format('Y-m-d') : null,
            'rush'               => $request->get('flexible') == 'no' && $request->get('rush') == 'yes',
        ]);

        return form()->route('wizard::review');
    }

    public function getReview()
    {
        if (! $this->hasCampaignLead()) {
            $this->createCampaignLead();
        }

        if (! $this->hasNecessaryInformation('review', 'get')) {
            return $this->redirectDueToNotHavingNecessaryInformation('review', 'get');
        }

        return view('wizard.review', [
            'campaignLead' => $this->getCampaignLead(),
        ]);
    }

    public function postReview(Request $request)
    {
        if (! $this->hasCampaignLead()) {
            $this->createCampaignLead();
        }

        if (! $this->hasNecessaryInformation('review', 'post')) {
            return $this->redirectDueToNotHavingNecessaryInformation('review', 'post');
        }

        $campaign = campaign_repository()->make();
        $campaign->name = $this->getCampaignLead()->name;
        $campaign->date = $this->getCampaignLead()->date;
        $campaign->flexible = $this->getCampaignLead()->flexible;
        $campaign->rush = $this->getCampaignLead()->rush;

        $campaign->contact_first_name = $this->getCampaignLead()->contact_first_name;
        $campaign->contact_last_name = $this->getCampaignLead()->contact_last_name;
        $campaign->contact_email = Auth::user()->email;
        $campaign->contact_phone = Auth::user()->phone;
        $campaign->contact_school = Auth::user()->school;
        $campaign->contact_chapter = Auth::user()->chapter;
        $campaign->school_id = school_chapter_match(Auth::user()->school, Auth::user()->chapter, 'school');
        $campaign->chapter_id = school_chapter_match(Auth::user()->school, Auth::user()->chapter, 'chapter');
        $campaign->promo_code = $request->input('promo_code');
        $campaign->polybag_and_label = $this->getCampaignLead()->polybag_and_label;

        $campaign->address_name = $this->getCampaignLead()->address_name ?? '';
        $campaign->address_line1 = $this->getCampaignLead()->address_line1 ?? '';
        $campaign->address_line2 = $this->getCampaignLead()->address_line2 ?? '';
        $campaign->address_city = $this->getCampaignLead()->address_city ?? '';
        $campaign->address_state = $this->getCampaignLead()->address_state ?? '';
        $campaign->address_zip_code = $this->getCampaignLead()->address_zip_code ?? '';
        $campaign->address_country = $this->getCampaignLead()->address_country ?? 'usa';

        $campaign->estimated_quantity = $this->getCampaignLead()->estimated_quantity;
        $campaign->user_id = \Auth::user() ? \Auth::user()->id : null;

        if ($campaign->address_option == 'save') {
            $address = address_repository()->create([
                'name'     => $this->getCampaignLead()->address_name,
                'line1'    => $this->getCampaignLead()->address_line1,
                'line2'    => $this->getCampaignLead()->address_line2,
                'city'     => $this->getCampaignLead()->address_city,
                'state'    => $this->getCampaignLead()->address_state,
                'zip_code' => $this->getCampaignLead()->address_zip_code,
                'country'  => 'usa',
                'user_id'  => Auth::user()->id,
            ]);
            if (! Auth::user()->address_id) {
                Auth::user()->update([
                    'address_id' => $address->id,
                ]);
            }
        }

        $artworkRequest = artwork_request_repository()->create([
            'print_front'              => $this->getCampaignLead()->print_front ?? false,
            'print_pocket'             => $this->getCampaignLead()->print_pocket ?? false,
            'print_back'               => $this->getCampaignLead()->print_back ?? false,
            'print_sleeve'             => $this->getCampaignLead()->print_sleeve ?? false,
            'print_front_colors'       => $this->getCampaignLead()->print_front_colors ?? 0,
            'print_pocket_colors'      => $this->getCampaignLead()->print_pocket_colors ?? 0,
            'print_back_colors'        => $this->getCampaignLead()->print_back_colors ?? 0,
            'print_sleeve_colors'      => $this->getCampaignLead()->print_sleeve_colors ?? 0,
            'print_front_description'  => $this->getCampaignLead()->print_front_description,
            'print_pocket_description' => $this->getCampaignLead()->print_pocket_description,
            'print_back_description'   => $this->getCampaignLead()->print_back_description,
            'print_sleeve_description' => $this->getCampaignLead()->print_sleeve_description,
            'design_style_preference'  => $this->getCampaignLead()->design_style_preference,
            'print_sleeve_preferred'   => $this->getCampaignLead()->print_sleeve_preferred,
            'design_type'              => $this->getCampaignLead()->design_type,
        ]);

        $campaign->artwork_request_id = $artworkRequest->id;
        $campaign->source_design_id = $this->getCampaignLead()->source_design_id;
        $campaign->save();

        $productColors = [];
        foreach ($this->getCampaignLead()->product_colors as $productColor) {
            $productColors[] = $productColor->id;
        }
        $campaign->product_colors()->sync($productColors);

        $index = 0;
        for ($i = 1; $i <= 12; $i++) {
            if ($this->getCampaignLead()->{'image'.$i.'_id'}) {
                artwork_request_file_repository()->create([
                    'artwork_request_id' => $artworkRequest->id,
                    'file_id'            => $this->getCampaignLead()->{'image'.$i.'_id'},
                    'type'               => 'image',
                    'sort'               => $index++,
                ]);
            }
        }
        $this->getCampaignLead()->update([
            'campaign_id' => $campaign->id,
            'state'       => 'converted',
        ]);
        design_repository()->createFromCampaign($campaign);

        $user = user_repository()->find($campaign->user_id);
        if ($this->getCampaignLead()->address_option == 'save') {
            $address = address_repository()->create([
                'name'     => $this->getCampaignLead()->address_name,
                'line1'    => $this->getCampaignLead()->address_line1,
                'line2'    => $this->getCampaignLead()->address_line2,
                'city'     => $this->getCampaignLead()->address_city,
                'state'    => $this->getCampaignLead()->address_state,
                'zip_code' => $this->getCampaignLead()->address_zip_code,
                'country'  => $this->getCampaignLead()->address_country,
                'user_id'  => $user->id,
            ]);
            $address->save();
            if ($user->address_id == null) {
                $user->address_id = $address->id;
                $user->save();
            }
        }

        $campaign = $campaign->fresh();
        if ($user->account_manager_id && $user->isType('customer')) {
            if ($campaign->state == 'campus_approval') {
                event(new CampusApprovalRequired($campaign->id));
            }
        }

        $isOnHold = OnHoldEngine::process($campaign, $campaign->user);

        if (! $isOnHold) {
            $text = "Hey ".Auth::user()->first_name.",".PHP_EOL.PHP_EOL."Thanks for placing a design request with Greek House.";
            if ($campaign->flexible != 'yes') {
                $text .= " As a reminder, to get your Order in by ".Carbon::parse($campaign->date)->format('m/d/Y').", here are some dates to keep us on track:".PHP_EOL."- Approve Design by ".Carbon::parse($campaign->date)->subWeekday(12)->format('m/d/Y').PHP_EOL."- Submit Sizes by ".Carbon::parse($campaign->date)->subWeekday(10)->format('m/d/Y');
            }
            $text .= PHP_EOL.PHP_EOL.'Please let us know if you have any questions or concerns!';

            add_comment($campaign->id, $text);
        }

        event(new FullyCreated($campaign->id));

        if (config('services.hubspot.api.enabled')) {
            try {
                $hubspot = new HubSpot();
                $response = $hubspot->submitForm(config('services.hubspot.api.forms.wizard'), [
                    'firstname'                 => Auth::user()->first_name,
                    'lastname'                  => Auth::user()->last_name,
                    'college_university_c_1__c' => Auth::user()->school,
                    'chapter__c'                => Auth::user()->chapter,
                    'email'                     => Auth::user()->email,
                    'phone'                     => Auth::user()->phone,
                    'hs_context'                => json_encode([
                        'hutk'      => Session::get('gclid'),
                        'ipAddress' => $request->ip(),
                        'pageUrl'   => $request->fullUrl(),
                        'pageName'  => 'Wizard',
                    ]),
                ]);
            } catch (HubSpotException $ex) {
                Logger::logError('#Wizard HUBSPOT: '.$ex->getMessage(), ['exception' => $ex]);
            }
        }

        // Forces campaign lead to reset so users can't resubmit the same campaign over and over again.
        $this->createCampaignLead();

        return form()->route('wizard::success', [$campaign->id]);
    }

    public function getSuccess($id = null)
    {
        if (! \Auth::user() || $id == null) {
            return form()->route('wizard::product');
        }

        $userCampaignsCount = campaign_repository()->newQuery()->with('user')->where('user_id', Auth::user()->id)->get()->count();

        return view('wizard.success', [
            'campaign'  => campaign_repository()->find($id),
            'userCount' => $userCampaignsCount,
        ]);
    }

    public function getAjaxProducts(Request $request)
    {
        $query = '';
        if ($request->has('query')) {
            $query = preg_replace('/[^(\x20-\x7F)]*/', '', $request->get('query'));
        }
        $category = null;
        if ($request->has('category')) {
            $category = $request->get('category');
        }
        if (! $category) {
            $category = garment_category_repository()->firstActive()->id;
        }

        if (! $query) {
            $products = product_repository()->getByGenderIdAndCategoryId(null, $category);
        } else {
            $products = product_repository()->all();
        }
        $data = [];
        $words = array_filter(explode(' ', mb_strtolower($query)));
        foreach ($products as $product) {
            $wordCount = 0;
            $name = preg_replace('/[^(\x20-\x7F)]*/', '', mb_strtolower($product->name));
            foreach ($words as $word) {
                if (mb_strpos($name, $word) !== false) {
                    $wordCount++;
                }
            }

            if (! $query || $words > 0) {
                $data[] = [
                    'id'          => $product->id,
                    'name'        => $product->name,
                    'img'         => route('system::image', [$product->image_id]),
                    'style'       => $product->style_number,
                    'size'        => size_list($product->sizes),
                    'colors'      => json_encode(color_list($product->active_colors)),
                    'description' => $product->description,
                    'gender'      => $product->gender->code,
                    'strength'    => $wordCount,
                ];
            }
        }

        usort($data, function ($a, $b) {
            return $a['strength'] < $b['strength'];
        });

        return [
            'data' => array_slice($data, 0, 999999),
        ];
    }

    public function getAjaxProductDetail($id)
    {
        $product = product_repository()->find($id);
        $colors = [];
        foreach ($product->colors as $color) {
            $colors[] = [
                'id'    => $color->id,
                'name'  => $color->name,
                'image' => route('system::image', [$color->thumbnail_id]),
            ];
        }

        return [
            'id'     => $product->id,
            'name'   => $product->name,
            'image'  => route('system::image', [$product->image_id]),
            'colors' => $colors,
        ];
    }

    public function hasNecessaryInformation($step, $method)
    {
        if (in_array($step, ['review', 'delivery', 'order', 'design'])) {
            if ($this->getCampaignLead()->product_colors->count() == 0) {
                return false;
            }
        }

        if (in_array($step, ['review', 'delivery', 'order'])) {
            if (! $this->getCampaignLead()->name) {
                return false;
            }
        }

        if (in_array($step, ['review'])) {
            if (! $this->getCampaignLead()->address_line1) {
                return false;
            }
        }

        if ($step == 'review' && $method == 'post') {
            if (! Auth::user()) {
                return false;
            }
        }

        return true;
    }

    public function redirectDueToNotHavingNecessaryInformation($step, $method)
    {
        if (in_array($step, ['review', 'delivery', 'order', 'design'])) {
            if ($this->getCampaignLead()->product_colors->count() == 0) {
                return form()->error('Product not set. Session expired?')->url(route('wizard::product'));
            }
        }

        if (in_array($step, ['review', 'delivery', 'order'])) {
            if (! $this->getCampaignLead()->name) {
                return form()->error('Name is not set. Session expired?')->url(route('wizard::design'));
            }
        }

        if (in_array($step, ['review'])) {
            if (! $this->getCampaignLead()->address_line1) {
                return form()->error('Shipping information is not set. Session expired?')->url(route('wizard::delivery'));
            }
        }

        if ($step == 'review' && $method == 'post') {
            if (! Auth::user()) {
                return form()->error('User not found. Session expired?')->url(route('wizard::review'));
            }
        }

        return null;
    }

    public function getAjaxCategory($categoryId, Request $request)
    {
        $data = [];
        $categoryId = get_category_id_from_description($categoryId);
        // Filter by Gender
        $gender = $request->get('g') ?? 'a';
        $genderModel = null;
        if ($gender != 'a') {
            $genderModel = garment_gender_repository()->findByCode($gender);
        }

        // Filter by Gender
        $search = $request->get('q');
        if (! empty($search)) {
            $products = product_repository()->getByGenderIdAndCategoryIdAndAll($genderModel ? $genderModel->id : null, $categoryId);
        } else {
            $topProducts = product_repository()->getTopProductsByCategory($categoryId, 4);
            if (count($topProducts)) {
                foreach ($topProducts as $val) {
                    $product = product_repository()->find($val->product_id);
                    $data[$product->id] = [
                        'id'          => $product->id,
                        'link'        => route('wizard::product', [$product->id]),
                        'name'        => $product->name,
                        'img'         => route('system::image', [$product->image_id]),
                        'style'       => $product->style_number,
                        'size'        => size_list($product->sizes),
                        'description' => $product->description,
                        'colors'      => json_encode(color_list($product->active_colors)),
                        'strength'    => $val->product_count + 100,
                    ];
                }
            }
            $products = product_repository()->getByGenderIdAndCategoryId($genderModel ? $genderModel->id : null, $categoryId);
        }

        foreach ($products as $product) {
            if (! $search || is_search_match($product->name, $search) || is_search_match($product->style_number, $search)) {
                if (! array_key_exists($product->id, $data)) {
                    $strength = search_strength($product->name, $search);
                    if ($product->garment_category_id == $categoryId && ! empty($search) && $strength > 0) {
                        $strength += 10;
                    }
                    if ((! empty($search) && $strength > 0) || ($product->garment_category_id == $categoryId)) {
                        $data[$product->id] = [
                            'id'          => $product->id,
                            'link'        => route('wizard::product', [$product->id]),
                            'name'        => $product->name,
                            'img'         => route('system::image', [$product->image_id]),
                            'style'       => $product->style_number,
                            'size'        => size_list($product->sizes),
                            'description' => $product->description,
                            'colors'      => json_encode(color_list($product->active_colors)),
                            'strength'    => $strength,
                        ];
                    }
                }
            }
        }
        if ($search) {
            $data = collect($data)->sortByDesc(function ($product, $key) {
                return $product['strength'];
            })->toArray();
        }

        $data = array_values($data);

        return response()->json(['data' => $data]);
    }

    public function getAjaxSearch(Request $request)
    {
        $data = [];

        // Filter by Gender
        $gender = $request->get('g') ?? 'a';
        $genderModel = null;
        if ($gender != 'a') {
            $genderModel = garment_gender_repository()->findByCode($gender);
        }

        // Filter by Gender
        $search = $request->get('q');

        $products = product_repository()->getByGenderIdAndCategoryId($genderModel ? $genderModel->id : null, null);
        foreach ($products as $product) {

            if (! $search || is_search_match($product->name, $search) || is_search_match($product->style_number, $search)) {
                $data[] = [
                    'id'          => $product->id,
                    'link'        => route('wizard::product', [$product->id]),
                    'name'        => $product->name,
                    'img'         => route('system::image', [$product->image_id]),
                    'style'       => $product->style_number,
                    'size'        => size_list($product->sizes),
                    'description' => $product->description,
                    'colors'      => json_encode(color_list($product->active_colors)),
                    'strength'    => search_strength($product->name, $search),
                ];
            }
        }
        if ($search) {
            $data = collect($data)->sortByDesc(function ($product, $key) {
                return $product['strength'];
            })->toArray();
            $data = array_values($data);
        }

        return response()->json(['data' => $data]);
    }
}

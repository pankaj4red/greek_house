<?php

namespace App\Http\Controllers\Admin;

use App\Forms\ImageUploadHandler;
use App\Http\Controllers\AdminBaseController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DesignController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('user_type:is_support');
    }

    public function getList(Request $request)
    {
        return view('admin_old.design.list', [
            'list' => design_repository()->getListingAll($request->all(), [['designs.updated_at', 'desc'], ['designs.id', 'desc']]),
        ]);
    }

    public function getTrending(Request $request)
    {
        return view('admin_old.design.trending', [
            'list' => design_repository()->getListingAll(['trending' => true], [['sort', 'asc'], ['designs.updated_at', 'desc']], 0, 99999),
        ]);
    }

    public function postTrending(Request $request)
    {
        $designs = [];
        foreach ($request->all() as $key => $value) {
            if (starts_with($key, 'sort_')) {
                $id = preg_replace('/[^0-9]/', '', $key);
                $designs[] = ['id' => $id, 'sort' => $value];
            }
        }

        foreach ($designs as $key => $designEntry) {
            $design = design_repository()->find($designEntry['id']);
            $designs[$key]['previous_sort'] = $design->sort;
        }

        $designs = collect($designs)->sort(function ($a, $b) {
            if ($a['sort'] > $b['sort']) {
                return 1;
            } elseif ($a['sort'] < $b['sort']) {
                return -1;
            }

            $changeWeightA = abs($a['previous_sort'] - $a['sort']);
            $changeWeightB = abs($b['previous_sort'] - $b['sort']);

            if ($changeWeightA > $changeWeightB) {
                return 1;
            } elseif ($changeWeightA < $changeWeightB) {
                return 1;
            }

            return 0;
        })->toArray();

        foreach (array_values($designs) as $key => $designEntry) {
            design_repository()->find($designEntry['id'])->update([
                'sort' => $key + 1,
            ]);
        }

        success('Trending Sorting Saved');

        return form()->route('admin::design::trending');
    }

    public function getRead($id)
    {
        return view('admin_old.design.read', [
            'model' => design_repository()->find($id),
        ]);
    }

    public function getCreate()
    {
        return view('admin_old.design.create', [
            'model' => [],
            'image' => (new ImageUploadHandler('design.create', 'image', true))->getImage(),
        ]);
    }

    public function postCreate(Request $request)
    {
        $imageHandler = new ImageUploadHandler('design.create', 'image', true, 1024, 960, 260, 260);
        $result = $imageHandler->post();
        if ($result instanceof RedirectResponse) {
            return $result;
        }
        if ($result['image'] == null) {
            return form()->error('Image is required')->back();
        }
        $validator = design_repository()->validate($request);
        if ($validator->fails()) {
            return form()->error($validator->errors())->back();
        }
        $design = design_repository()->make();
        $design->name = $request->get('name');
        $design->thumbnail_id = $result['thumbnail'];
        $design->status = 'new';
        $design->save();

        $imageHandler->clear();
        success('Design Information Saved');

        return form()->route('admin::design::read', [$design->id]);
    }

    public function getUpdateGeneral($id)
    {
        $design = design_repository()->find($id);

        $imageHandler = new ImageUploadHandler('design.update-', 'thumbnail', false, 250, 250);
        $imageHandler->setImageId($design->thumbnail_id);

        return view('admin_old.design.update__general', [
            'design'    => $design,
            'thumbnail' => $imageHandler->getImage(),
        ]);
    }

    public function postUpdateGeneral($id, Request $request)
    {
        $design = design_repository()->find($id);

        $imageHandler = new ImageUploadHandler('design.update-'.$id, 'thumbnail', true, 250, 250);
        $result = $imageHandler->post();
        if ($result instanceof RedirectResponse) {
            return $result;
        }

        $this->validate($request, [
            'name'        => 'required',
            'code'        => 'required',
            'campaign_id' => 'nullable|integer',
            'status'      => 'required',
            'trending'    => 'required|in:yes,no',
        ]);

        $campaign = null;
        if ($request->get('campaign_id')) {
            $campaign = campaign_repository()->find($request->get('campaign_id'));
            if (! $campaign) {
                return back()->withErrors('Unknown Campaign');
            }

            if ($campaign->id != $design->campaign_id) {
                $designAssociatedWithCampaign = design_repository()->findByCampaignId($campaign->id);
                if ($designAssociatedWithCampaign) {
                    return back()->withErrors('Campaign already associated with another design: '.$designAssociatedWithCampaign->id);
                }
            }
        }

        $sort = $design->sort;
        if ($design->trending != ($request->get('trending') == 'yes') && $request->get('trending') == 'yes') {
            $sort = design_repository()->maxSort($design->id);
        }

        $design->update([
            'name'         => $request->get('name'),
            'code'         => $request->get('code'),
            'status'       => $request->get('status'),
            'trending'     => $request->get('trending') == 'yes',
            'campaign_id'  => $request->get('campaign_id'),
            'thumbnail_id' => $result['image'] ?? $design->thumbnail_id,
            'sort'         => $sort,
        ]);

        return form()->success('Design Information Saved')->route('admin::design::read', [$id]);
    }

    public function getUpdateTags($id)
    {
        return view('admin_old.design.update__tags', [
            'design' => design_repository()->find($id),
        ]);
    }

    public function postUpdateTags($id, Request $request)
    {
        $design = design_repository()->find($id);

        $rules = [];
        $groups = design_tag_group_repository()->all();
        foreach ($groups as $group) {
            $rules['tag_'.$group->code] = 'nullable';
        }
        $this->validate($request, $rules);

        foreach ($groups as $group) {
            $requestTagList = decommify($request->get('tag_'.$group->code));

            $tagsToCreate = [];
            $tagsToRemove = [];
            foreach ($requestTagList as $requestTag) {
                $found = false;
                foreach ($design->getTags($group->code) as $tags) {
                    if ($tags->name == $requestTag) {
                        $found = true;
                        break;
                    }
                }
                if ($found == false) {
                    $tagsToCreate[] = $requestTag;
                }
            }

            foreach ($design->getTags($group->code) as $tag) {
                $found = false;
                foreach ($requestTagList as $requestTag) {
                    if ($tag->name == $requestTag) {
                        $found = true;
                        break;
                    }
                }
                if ($found == false) {
                    $tagsToRemove[] = $tag->name;
                }
            }

            foreach ($design->getTags($group->code) as $tag) {
                if (in_array($tag->name, $tagsToRemove)) {
                    $tag->delete();
                }
            }
            foreach ($tagsToCreate as $tag) {
                design_tag_repository()->createTagOnGroup($design->id, $group->code, $tag);
            }
        }

        return form()->success('Design Information Saved')->route('admin::design::read', [$id]);
    }

    public function getUpdateImages($id)
    {
        $design = design_repository()->find($id);

        $images = [];
        $files = $design->files;
        for ($i = 0; $i < 10; $i++) {
            $images[$i] = new ImageUploadHandler('design.image', 'image'.$i);
            if ($i < count($files)) {
                $images[$i]->setImageId($files[$i]->file_id);
            }
        }

        return view('admin_old.design.update__images', [
            'design' => $design,
            'image0' => $images[0]->getImage(),
            'image1' => $images[1]->getImage(),
            'image2' => $images[2]->getImage(),
            'image3' => $images[3]->getImage(),
            'image4' => $images[4]->getImage(),
            'image5' => $images[5]->getImage(),
            'image6' => $images[6]->getImage(),
            'image7' => $images[7]->getImage(),
            'image8' => $images[8]->getImage(),
            'image9' => $images[9]->getImage(),
        ]);
    }

    public function postUpdateImages($id, Request $request)
    {
        $design = design_repository()->find($id);

        $handlers = [];
        $results = [];
        for ($i = 0; $i < 10; $i++) {
            $imageHandler = new ImageUploadHandler('design.image', 'image'.$i);
            $handlers[] = $imageHandler;
            $result = $imageHandler->post();
            if ($result instanceof RedirectResponse) {
                return $result;
            }
            $results[] = $result;
        }

        $files = $design->files;
        for ($i = 0; $i < 10; $i++) {
            if ($results[$i]['image'] == null && isset($files[$i])) {
                // Remove
                $files[$i]->delete();
            } elseif ($results[$i]['image'] != null && ! isset($files[$i])) {
                // Add
                design_file_repository()->create([
                    'design_id' => $design->id,
                    'file_id'   => $results[$i]['image'],
                    'type'      => 'image',
                ]);
            } elseif ($results[$i]['image'] != null && isset($files[$i]) && $results[$i]['image'] != $files[$i]->file_id) {
                // Update
                $files[$i]->update([
                    'file_id' => $results[$i]['image'],
                ]);
            }
        }

        foreach ($handlers as $handler) {
            $handler->clear();
        }

        return form()->success('Design Information Saved')->route('admin::design::read', [$id]);
    }

    public function getDelete($id)
    {
        $design = design_repository()->find($id);
        if (! $design) {
            return form('Unknown Design')->error('admin::design::list')->back();
        }

        return view('admin_old.design.delete', [
            'design' => $design,
        ]);
    }

    public function postDelete($id)
    {
        $design = design_repository()->find($id);
        if (! $design) {
            return form()->error('Unknown Design')->route('admin::design::list');
        }
        $design->delete();
        success('Design Deleted');

        return form()->route('admin::design::list');
    }
}

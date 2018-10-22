<?php

namespace App\Http\Controllers\Customer\Blocks;

use App\Forms\ImageUploadHandler;
use App\Helpers\ImageHandler;
use App\Http\Controllers\BlockController;
use App\Models\DesignFile;
use App\Models\DesignTag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DesignGalleryController extends BlockController
{
    public function block()
    {
        $imageHandler = new ImageUploadHandler('design', 'thumbnail', false, 250, 250);
        $imageHandler->setImageId($this->getCampaign()->designs->first()->thumbnail_id);

        return $this->view('blocks.block.design_gallery', [
            'thumbnail' => $imageHandler->getImage(),
        ]);
    }

    public function postBlock($id, Request $request)
    {
        $this->forceCanBeAccessed('edit');
        $this->force(['admin', 'support', 'art_director', 'junior_designer']);

        $imageHandler = new ImageUploadHandler('design', 'thumbnail', false, 250, 250);
        $result = $imageHandler->post();
        if ($result instanceof RedirectResponse) {
            return $result;
        }

        form($request)->validate([
            'name'   => 'required',
            'code'   => 'required',
            'status' => 'required|in:new,disabled,enabled,search',
            'images' => 'required',
        ]);

        $design = $this->getCampaign()->designs->first();
        $images = json_decode($request->get('images'), false);

        /** @var DesignFile $designImage */
        foreach ($design->images as $designImage) {
            $found = false;
            foreach ($images->designs as $image) {
                if (starts_with($image->id, 'image_')) {
                    $id = str_replace('image_', '', $image->id);
                    if ($id == $designImage->id) {
                        $found = true;
                        break;
                    }
                }
            }
            if ($found == false) {
                $designImage->delete();
            }
        }

        $index = 0;
        foreach ($images->designs as $image) {
            if (starts_with($image->id, 'proof_')) {
                $designFile = design_file_repository()->create([
                    'design_id' => $design->id,
                    'type'      => 'image',
                    'file_id'   => artwork_request_file_repository()->find(str_replace('proof_', '', $image->id))->file_id,
                    'enabled'   => $image->enabled,
                    'sort'      => $index++,
                ]);
            }
            if (starts_with($image->id, 'upload_')) {
                // New File
                $content = \App::make(ImageHandler::class)->getContent($image->url, 600, 600);
                $file = file_repository()->create([

                    'name'              => $image->filename,
                    'internal_filename' => save_file($content),
                ]);
                $designFile = design_file_repository()->create([
                    'design_id' => $design->id,
                    'type'      => 'image',
                    'file_id'   => $file->id,
                    'enabled'   => $image->enabled,
                    'sort'      => $index++,
                ]);
            }
            if (starts_with($image->id, 'image_')) {
                $designFile = design_file_repository()->find(str_replace('image_', '', $image->id));
                $designFile->update([
                    'enabled' => $image->enabled,
                    'sort'    => $index++,
                ]);
            }
        }

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
                /** @var DesignTag $tag */
                if (in_array($tag->name, $tagsToRemove)) {
                    $tag->delete();
                }
            }
            foreach ($tagsToCreate as $tag) {
                design_tag_repository()->createTagOnGroup($design->id, $group->code, $tag);
            }
        }

        $design->update([
            'name'         => $request->get('name'),
            'code'         => $request->get('code'),
            'status'       => $request->get('status'),
            'trending'     => $request->has('trending'),
            'thumbnail_id' => $result['image'] ? $result['image'] : null,
        ]);

        return form()->success('Design Saved')->back();
    }
}

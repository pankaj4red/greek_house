<?php

namespace App\Http\Controllers\Customer\Blocks;

use App\Forms\ImageUploadHandler;
use App\Http\Controllers\BlockController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UploadProofsController extends BlockController
{
    /**
     * @return string
     * @throws \Throwable
     */
    public function block()
    {
        return $this->view('blocks.block.upload_proofs');
    }

    /**
     * @param int $id
     * @return string
     * @throws \Throwable
     */
    public function getPopup($id)
    {
        $this->forceCanBeAccessed('edit');

        $proofsGeneric = [];
        for ($i = 0; $i < 10; $i++) {
            $proofsGeneric[$i] = new ImageUploadHandler('campaign.update-'.$id, 'proof'.$i);
            $proofsGeneric[$i]->setImageId($this->getCampaign()->getProof('generic', $i) ? $this->getCampaign()->getProof('generic', $i)->file_id : null);
        }
        $proofs['generic'] = [
            'proof0' => $proofsGeneric[0]->getImage(),
            'proof1' => $proofsGeneric[1]->getImage(),
            'proof2' => $proofsGeneric[2]->getImage(),
            'proof3' => $proofsGeneric[3]->getImage(),
            'proof4' => $proofsGeneric[4]->getImage(),
            'proof5' => $proofsGeneric[5]->getImage(),
            'proof6' => $proofsGeneric[6]->getImage(),
            'proof7' => $proofsGeneric[7]->getImage(),
            'proof8' => $proofsGeneric[8]->getImage(),
            'proof9' => $proofsGeneric[9]->getImage(),
        ];

        $proofsProduct = [];
        foreach ($this->getCampaign()->product_colors as $productColor) {
            $proofsProduct[$productColor->id] = (object) [
                'front'    => new ImageUploadHandler('campaign.update-'.$id, 'proof'.$productColor->id.'_front'),
                'back'     => new ImageUploadHandler('campaign.update-'.$id, 'proof'.$productColor->id.'_back'),
                'close_up' => new ImageUploadHandler('campaign.update-'.$id, 'proof'.$productColor->id.'_close_up'),
                'other'    => new ImageUploadHandler('campaign.update-'.$id, 'proof'.$productColor->id.'_other'),
            ];

            $proofsProduct[$productColor->id]->front->setImageId($this->getCampaign()->getProductColorProof($productColor->id, 'front') ? $this->getCampaign()->getProductColorProof($productColor->id, 'front')->file_id : null);
            $proofsProduct[$productColor->id]->front = $proofsProduct[$productColor->id]->front->getImage();

            $proofsProduct[$productColor->id]->back->setImageId($this->getCampaign()->getProductColorProof($productColor->id, 'back') ? $this->getCampaign()->getProductColorProof($productColor->id, 'back')->file_id : null);
            $proofsProduct[$productColor->id]->back = $proofsProduct[$productColor->id]->back->getImage();

            $proofsProduct[$productColor->id]->close_up->setImageId($this->getCampaign()->getProductColorProof($productColor->id, 'close_up') ? $this->getCampaign()->getProductColorProof($productColor->id, 'close_up')->file_id : null);
            $proofsProduct[$productColor->id]->close_up = $proofsProduct[$productColor->id]->close_up->getImage();

            $proofsProduct[$productColor->id]->other->setImageId($this->getCampaign()->getProductColorProof($productColor->id, 'other') ? $this->getCampaign()->getProductColorProof($productColor->id, 'other')->file_id : null);
            $proofsProduct[$productColor->id]->other = $proofsProduct[$productColor->id]->other->getImage();
        }

        $proofs['products'] = $proofsProduct;

        return $this->view('blocks.popup.upload_proofs', [
            'proofs' => (object) $proofs,
        ]);
    }

    /**
     * @param int     $id
     * @param Request $request
     * @return $this|\Illuminate\Http\JsonResponse|string
     * @throws \Illuminate\Validation\ValidationException
     */
    public function postPopup($id, Request $request)
    {
        $this->forceCanBeAccessed('edit');

        $proofs = [];
        for ($i = 0; $i < 10; $i++) {
            $imageHandler = new ImageUploadHandler('campaign.update-'.$id, 'proof'.$i, false, 600, 600);
            $result = $imageHandler->post();
            if ($result instanceof RedirectResponse) {
                return $result;
            }
            $proofs[] = (object) [
                'type'             => 'proof_generic',
                'file_id'          => $result['image'],
                'product_color_id' => null,
                'sort'             => $i,
            ];
        }

        $proofsProduct = [];
        foreach ($this->getCampaign()->product_colors as $productColor) {
            foreach (['front', 'back', 'close_up', 'other'] as $position) {
                $imageHandler = new ImageUploadHandler('campaign.update-'.$id, 'proof'.$productColor->id.'_'.$position, false, 600, 600);
                $result = $imageHandler->post();
                if ($result instanceof RedirectResponse) {
                    return $result;
                }
                $proofs[] = (object) [
                    'type'             => 'proof_'.$position,
                    'file_id'          => $result['image'],
                    'product_color_id' => $productColor->id,
                    'sort'             => 0,
                ];
            }
        }

        $form = form($request);
        $minutes = 0;
        if (is_numeric($request->get('design_hours'))) {
            $minutes = $request->get('design_hours') * 60;
        } elseif (preg_match('/^([0-9]+):([0-9]{1,2})$/', $request->get('design_hours'), $matches)) {
            $minutes = ($matches[1] * 60) + $matches[2];
        } else {
            $form->error('Invalid design hours format');
        }
        if ($request->get('design_type') == 'embroidery' && ($request->get('speciality_inks') == 'yes' || $request->get('embellishment_names') == 'yes' || $request->get('embellishment_numbers') == 'yes')) {
            $form->error('Campaigns with Speciality Inks or Embellishment Names/Numbers cannot have a print type of Embroidery');
        }

        $form->validate();

        $artworkRequest = $this->getCampaign()->artwork_request;
        $artworkRequest->update([
            'design_minutes'                    => $minutes,
            'designer_colors_front'             => intval($request->get('designer_colors_front')),
            'designer_colors_back'              => intval($request->get('designer_colors_back')),
            'designer_colors_sleeve_left'       => intval($request->get('designer_colors_sleeve_left')),
            'designer_colors_sleeve_right'      => intval($request->get('designer_colors_sleeve_right')),
            'designer_colors_front_list'        => $request->get('designer_colors_front_list'),
            'designer_colors_back_list'         => $request->get('designer_colors_back_list'),
            'designer_colors_sleeve_left_list'  => $request->get('designer_colors_sleeve_left_list'),
            'designer_colors_sleeve_right_list' => $request->get('designer_colors_sleeve_right_list'),
            'designer_dimensions_front'         => $request->get('designer_dimensions_front'),
            'designer_dimensions_back'          => $request->get('designer_dimensions_back'),
            'designer_dimensions_sleeve_left'   => $request->get('designer_dimensions_sleeve_left'),
            'designer_dimensions_sleeve_right'  => $request->get('designer_dimensions_sleeve_right'),
            'designer_black_shirt'              => $request->get('designer_black_shirt') == 'yes' ? 1 : 0,
            'design_type'                       => $request->get('design_type'),
            'speciality_inks'                   => $request->get('speciality_inks'),
            'embellishment_names'               => $request->get('embellishment_names'),
            'embellishment_numbers'             => $request->get('embellishment_numbers'),
        ]);

        if ($artworkRequest->design_type == 'screen' && $this->getCampaign()->estimated_quantity == '12-23') {
            $this->getCampaign()->update([
                'estimated_quantity' => '24-47',
            ]);
            comment_repository()->create([
                'channel'     => 'customer',
                'campaign_id' => $this->getCampaign()->id,
                'user_id'     => null,
                'body'        => 'Hey '.$this->getCampaign()->user->first_name."\n".'The minimum quantity of this order increased to 24 pieces because the embellishment changed '.'from embroidery to screenprint. Let us know if you have any questions!'."\n".'-Greek  House',
                'ip'          => \Request::ip(),
            ]);
        }

        $proofIdList = [];
        $changed = false;
        foreach ($proofs as $proof) {
            $currentProof = artwork_request_file_repository()->findByArtworkRequestAndType($this->getCampaign()->artwork_request_id, $proof->type, $proof->product_color_id, $proof->sort);
            if ($currentProof && ! $proof->file_id) {
                $changed = true;
                $currentProof->delete();
                continue;
            }
            if ($currentProof && $proof->file_id && $currentProof->file_id != $proof->file_id) {
                $changed = true;
                $currentProof->update([
                    'file_id' => $proof->file_id,
                ]);
                continue;
            }
            if (! $currentProof && $proof->file_id) {
                $changed = true;
                artwork_request_file_repository()->create([
                    'artwork_request_id' => $this->getCampaign()->artwork_request_id,
                    'file_id'            => $proof->file_id,
                    'product_color_id'   => $proof->product_color_id,
                    'sort'               => $proof->sort,
                    'type'               => $proof->type,
                ]);
                continue;
            }
        }

        if ($changed) {
            comment_repository()->create([
                'channel'     => 'customer',
                'campaign_id' => $this->getCampaign()->id,
                'user_id'     => null,
                'body'        => ($artworkRequest->designer_id ? ('Designer '.$artworkRequest->designer->first_name) : 'Greek House').' has uploaded a proof!',
                'ip'          => \Request::ip(),
            ]);
        }

        return form()->success('Proof Information Saved')->back();
    }
}

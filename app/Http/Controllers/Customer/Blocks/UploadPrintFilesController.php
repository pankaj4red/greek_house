<?php

namespace App\Http\Controllers\Customer\Blocks;

use App\Events\Campaign\ArtworkFixed;
use App\Events\Campaign\FulfillmentIssueSolved;
use App\Http\Controllers\BlockController;
use Illuminate\Http\Request;

class UploadPrintFilesController extends BlockController
{
    public function block()
    {
        return $this->view('blocks.block.upload_print_files');
    }

    public function postBlock($id, Request $request)
    {
        $this->forceCanBeAccessed('edit');

        form($request)->validate([
            'print_file' => 'required',
        ]);

        $emptySlot = 0;
        for ($i = 1; $i <= 10; $i++) {
            if (! $this->getCampaign()->getPrintFileEntry($i)) {
                $emptySlot = $i;
                break;
            }
        }
        if ($emptySlot == 0) {
            return form()->error('All print files slots are taken.')->back();
        }

        $file = $request->file('print_file');
        $content = file_get_contents($file->getRealPath());
        $extension = $file->getClientOriginalExtension();
        \Storage::disk('local')->put($file->getFilename().'.'.$extension, \File::get($file));

        $entry = file_repository()->create([
            'name'              => $file->getClientOriginalName(),
            'internal_filename' => save_file($content),
            'size'              => $file->getSize(),
        ]);

        if (! $this->getCampaign()->fulfillment_valid && $this->getCampaign()->fulfillment_invalid_reason == 'Artwork') {
            $this->getCampaign()->update([
                'fulfillment_valid'          => true,
                'fulfillment_invalid_reason' => null,
                'fulfillment_invalid_text'   => null,
            ]);

            success('Fulfillment Artwork Issue marked as Solved');
            add_comment_fulfillment($id, 'Artwork Issue marked as solved: Print Files Updated'."\r\n"."Please update the print date if it has changed", \Auth::user()->id);
            event(new FulfillmentIssueSolved($this->getCampaign()->id));
        }

        artwork_request_file_repository()->create([
            'artwork_request_id' => $this->getCampaign()->artwork_request_id,
            'file_id'            => $entry->id,
            'type'               => 'print_file',
            'sort'               => $emptySlot,
        ]);

        if ($this->getCampaign()->artwork) {
            artwork_file_repository()->create([
                'artwork_id' => $this->getCampaign()->artwork_id,
                'file_id'    => $entry->id,
                'type'       => 'print_file',
                'sort'       => $emptySlot,
            ]);
        }

        if ($this->getCampaign()->decorator_id) {
            event(new ArtworkFixed($id));
        }

        return form()->success('Print File associated with campaign')->back();
    }

    public function postDelete($id, Request $request)
    {
        $this->forceCanBeAccessed('edit');

        for ($i = 1; $i <= 10; $i++) {
            $campaignFile = $this->getCampaign()->getPrintFileEntry($i);
            if ($campaignFile != null && $campaignFile->file_id == $request->get('file_id')) {
                $campaignFile->delete();

                return form()->success('Print File removed from campaign')->route('dashboard::details', [$id]);
            }
        }

        return form()->error('Print file was not found.')->back();
    }
}

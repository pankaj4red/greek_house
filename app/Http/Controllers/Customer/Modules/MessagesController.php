<?php

namespace App\Http\Controllers\Customer\Modules;

use App\Events\Campaign\MessageCreated;
use App\Forms\FileUploadHandler;
use App\Http\Controllers\ModuleController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MessagesController extends ModuleController
{
    /**
     * @return string
     * @throws \Throwable
     */
    public function block()
    {
        $fileHandler = new FileUploadHandler('message', 'file');
        $fileHandler->setFileId(null);

        return $this->view('v3.customer.dashboard.modules.messages.messages_block', [
            'list' => comments_by_campaign_channel($this->getCampaign()->id, $this->getParameter('channel')),
        ]);
    }

    /**
     * @param int     $id
     * @param Request $request
     * @return $this|\Illuminate\Http\JsonResponse|mixed|string
     * @throws \Illuminate\Validation\ValidationException
     */
    public function postBlock($id, Request $request)
    {
        $this->forceCanBeAccessed('edit');

        if (\Auth::user()->needsToWaitToComment()) {
            form()->error('You need to wait 10 seconds between comments.')->back();
        }

        form($request)->validate([
            'channel' => 'required|in:customer,fulfillment',
        ]);

        $fileHandler = new FileUploadHandler('message', 'file');
        $result = $fileHandler->post();
        if ($result instanceof RedirectResponse) {
            return $result;
        }

        if (! $request->has('body') && $result['file'] == null) {
            return form()->error('Either a message or a file is required.')->back();
        }

        $comment = comment_repository()->create([
            'campaign_id' => $id,
            'user_id'     => \Auth::user()->id,
            'body'        => $request->get('body'),
            'channel'     => $request->get('channel'),
            'file_id'     => $result['file'],
        ]);

        if (comment_repository()->removeIfDuplicate($comment)) {
            return form()->back();
        }

        $fileHandler->clear();
        event(new MessageCreated($this->getCampaign()->id, $comment->id));

        return form()->success('Message Posted')->back();
    }
}

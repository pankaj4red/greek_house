<?php

namespace App\Repositories\Models;

use App\Models\Comment;
use Carbon\Carbon;
use Illuminate\Support\Collection;

/**
 * @method Comment make()
 * @method Collection|Comment[] all($columns = ['*'], $with = null, $orderBy = null)
 * @method Comment|null find($id)
 * @method Comment create(array $parameters = [])
 */
class CommentRepository extends ModelRepository
{
    protected $modelClassName = Comment::class;

    /**
     * @param integer $campaignId
     * @param string  $channel
     * @return Collection|Comment[]
     */
    public function getByCampaignIdAndChannel($campaignId, $channel)
    {
        return $this->model->newQuery()->with('user', 'file')->where('campaign_id', $campaignId)->where('channel', $channel)->orderBy('id')->get();
    }

    /**
     * @param integer $userId
     * @return boolean
     */
    public function isUserNeedingToWait($userId)
    {
        return $this->model->where('user_id', $userId)->where('created_at', '>', date('Y-m-d H:i:s', time() - 10))->count() > 0;
    }

    /**
     * @param Comment $comment
     * @return bool
     */
    public function removeIfDuplicate($comment)
    {
        $query = $this->model->newQuery()->where('created_at', '>', Carbon::parse('-10 seconds')->format('Y-m-d H:i:s'))->where('id', '<', $comment->id);

        foreach ($comment->getAttributes() as $key => $value) {
            if (in_array($key, ['campaign_id', 'user_id', 'body', 'channel', 'file_id'])) {
                $query->where($key, $value);
            }
        }

        $existingList = $query->get();

        if ($existingList->count() > 0) {
            $comment->delete();

            return true;
        }

        return false;
    }
}

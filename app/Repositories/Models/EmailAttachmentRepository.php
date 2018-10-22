<?php

namespace App\Repositories\Models;

use App\Models\EmailAttachment;
use Illuminate\Support\Collection;

/**
 * @method EmailAttachment make()
 * @method Collection|EmailAttachment[] all($columns = ['*'], $with = null, $orderBy = null)
 * @method EmailAttachment|null find($id)
 * @method EmailAttachment create(array $parameters = [])
 */
class EmailAttachmentRepository extends ModelRepository
{
    protected $modelClassName = EmailAttachment::class;
}

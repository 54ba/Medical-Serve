<?php

namespace App\Api\V1\Social\Traits\Relations;

use App\Api\V1\Social\SocialAccount;
use App\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait SocialAccountRelations
{
    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

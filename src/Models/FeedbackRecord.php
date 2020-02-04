<?php

namespace Modules\Opx\FeedBack\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class FeedbackRecord
 * @package Modules\Opx\FeedBack\Models
 * @method static Builder withTrashed()
 * @method static Builder onlyTrashed()
 */
class FeedbackRecord extends Model
{
    use SoftDeletes;

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    protected $casts = [
        'payload' => 'array',
    ];
}
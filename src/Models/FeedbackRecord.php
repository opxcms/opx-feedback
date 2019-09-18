<?php

namespace Modules\Opx\FeedBack\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
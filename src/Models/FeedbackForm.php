<?php

namespace Modules\Opx\FeedBack\Models;

use Core\Traits\Model\DataAttribute;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class FeedbackForm
 * @package Modules\Opx\FeedBack\Models
 * @method static Builder onlyTrashed()
 * @method static Builder withTrashed()
 */
class FeedbackForm extends Model
{
    use SoftDeletes,
        DataAttribute;

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at',
    ];
}
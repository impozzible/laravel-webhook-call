<?php

namespace Weblab\WebhookCall\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class WebhookEvent
 */
class WebhookEvent extends Model
{
    use HasFactory;

    /**
     * Make all attributes fillable
     *
     * @var array
     */
    protected $guarded = [];
}

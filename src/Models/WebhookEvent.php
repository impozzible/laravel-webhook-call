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
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'webhook_events';

    /**
     * Make all attributes fillable
     *
     * @var array<string>|bool>
     */
    protected $guarded = [];
}

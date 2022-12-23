<?php

namespace Weblab\WebhookCall\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Class WebhookLog
 */
class WebhookLog extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'webhook_logs';

    /**
     * Make all attributes fillable
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Casts
     */
    protected $casts = [
        'attempt' => 'integer',
        'payload' => AsArrayObject::class,
        'response_body' => AsArrayObject::class,
    ];

    /**
     * Get the webhook for this webhook log (1 to 1 relationship with the Webhook model)
     *
     * @return BelongsTo               The webhook statement
     */
    public function webhook(): BelongsTo
    {
        return $this->belongsTo(config('webhook-call.models.webhook'));
    }

    /**
     * Get the webhook event for this webhook log (1 to 1 relationship with the WebhookEvent model)
     *
     * @return BelongsTo               The webhook event statement
     */
    public function webhookEvent(): BelongsTo
    {
        return $this->belongsTo(config('webhook-call.models.webhook_event'));
    }

    /**
     * Get a entity linked to the webhook log
     *
     * @return MorphTo                 The entity statement
     */
    public function entity(): MorphTo
    {
        return $this->morphTo();
    }
}

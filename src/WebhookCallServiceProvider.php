<?php

namespace Weblab\WebhookCall;

use Illuminate\Support\Facades\Event;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\WebhookServer\Events\FinalWebhookCallFailedEvent;
use Spatie\WebhookServer\Events\WebhookCallFailedEvent;
use Spatie\WebhookServer\Events\WebhookCallSucceededEvent;
use Weblab\WebhookCall\Listeners\WebhookCallListener;

/**
 * Class WebhookCallServiceProvider
 */
class WebhookCallServiceProvider extends PackageServiceProvider
{
    /**
     * Configure the package.
     *
     * @param  Package  $package  The package to configure
     */
    public function configurePackage(Package $package): void
    {
        // configure the package
        $package->name('webhook-call')
            ->hasConfigFile()
            ->hasMigrations([
                '2022_12_08_101759_create_webhooks_table',
                '2022_12_08_102759_create_webhook_events_table',
                '2022_12_08_103259_create_webhook_webhook_events_table',
                '2022_12_08_103759_create_webhook_logs_table',
            ]);

        // register the event listeners
        Event::listen(
            [FinalWebhookCallFailedEvent::class, WebhookCallFailedEvent::class, WebhookCallSucceededEvent::class],
            WebhookCallListener::class
        );
    }
}

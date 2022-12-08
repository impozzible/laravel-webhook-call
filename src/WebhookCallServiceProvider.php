<?php

namespace Weblab\WebhookCall;

use Illuminate\Support\Facades\Event;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\WebhookServer\Events\FinalWebhookCallFailedEvent;
use Spatie\WebhookServer\Events\WebhookCallFailedEvent;
use Spatie\WebhookServer\Events\WebhookCallSucceededEvent;
use Weblab\WebhookCall\Commands\SkeletonCommand;
use Weblab\WebhookCall\Listeners\WebhookCallListener;

/**
 * Class WebhookCallServiceProvider
 */
class WebhookCallServiceProvider extends PackageServiceProvider
{
    /**
     * Configure the package.
     *
     * @param   Package             $package The package to configure
     * @return  void
     */
    public function configurePackage(Package $package): void
    {
        // configure the package
        $package->name('webhook-call')
            ->hasMigration('create_skeleton_table')
            ->runsMigrations();

        // register the event listeners
        Event::listen(
            [FinalWebhookCallFailedEvent::class, WebhookCallFailedEvent::class, WebhookCallSucceededEvent::class],
            WebhookCallListener::class
        );
    }
}

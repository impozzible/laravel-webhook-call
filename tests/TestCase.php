<?php

namespace Weblab\WebhookCall\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase as Orchestra;
use Weblab\WebhookCall\WebhookCallServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Weblab\\WebhookCall\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );

        // setup the test database
        $this->setupDatabase();
    }

    protected function getPackageProviders($app)
    {
        return [
            WebhookCallServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        config()->set('database.default', 'sqlite');
        config()->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
        ]);

        config()->set('webhook-server', require(__DIR__.'/../vendor/spatie/laravel-webhook-server/config/webhook-server.php'));
    }

    /**
     * Setup the test database
     */
    protected function setupDatabase(): void
    {
        // create the migrations from the ../database/migrations folder, by iterating over the files in the folder
        $migrationFiles = glob(__DIR__.'/../database/migrations/*.php.stub');
        foreach ($migrationFiles as $migrationFile) {
            // require the migration file
            $migration = require $migrationFile;

            // run the migration
            $migration->up();
        }

        // create the additional migrations
        $this->createTables('orders');
    }

    /**
     * Create additional tables
     *
     * @param ...$tableNames
     * @return void
     */
    protected function createTables(...$tableNames)
    {
        collect($tableNames)->each(function (string $tableName) {
            Schema::create($tableName, function (Blueprint $table) {
                $table->increments('id');
                $table->string('name')->nullable();
                $table->string('email')->nullable();
                $table->string('product')->nullable();
                $table->timestamps();
            });
        });
    }
}

<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Weblab\WebhookCall\Tests\TestCase;

uses(TestCase::class)->in(__DIR__);

uses(RefreshDatabase::class)->in('Unit');

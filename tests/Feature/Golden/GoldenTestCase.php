<?php

namespace Tests\Feature\Golden;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\AssertsGolden;
use Tests\Concerns\SeedsGoldenFixtures;
use Tests\TestCase;

abstract class GoldenTestCase extends TestCase
{
    use RefreshDatabase, AssertsGolden, SeedsGoldenFixtures;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seedGoldenFixtures();
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();

        parent::tearDown();
    }
}

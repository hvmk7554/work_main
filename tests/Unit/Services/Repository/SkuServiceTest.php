<?php

namespace Tests\Unit\Services\Repository;

use App\Models\Course;
use App\Models\Sku;
use App\Services\Repository\SkuService;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class SkuServiceTest extends TestCase
{
    public function testCalculateNumberOfUnits()
    {
        $today = Carbon::create(2022, 7, 16);

        $course = new Course();
        $course->start_date = Carbon::create(2022, 01, 4);
        $course->end_date = Carbon::create(2022, 12, 31);

        $sku = new Sku();
        $sku->start_date = Carbon::create(2022, 7, 16);
        $sku->end_date = Carbon::create(2022, 10, 25);
        $sku->course = $course;

        list($numberOfUnits, $firstCycleUnits, $midCycleUnits, $lastCycleUnits)
            = resolve(SkuService::class)->calculateTimeBasedNumberOfUnits($sku, $today);

        $this->assertEquals(3.3, $numberOfUnits);
        $this->assertEquals(0.6, $firstCycleUnits);
        $this->assertEquals(2, $midCycleUnits);
        $this->assertEquals(0.7, $lastCycleUnits);

        $today = Carbon::create(2022, 7, 25);

        $course = new Course();
        $course->start_date = Carbon::create(2022, 01, 4);
        $course->end_date = Carbon::create(2022, 12, 31);

        $sku = new Sku();
        $sku->start_date = Carbon::create(2022, 7, 16);
        $sku->end_date = Carbon::create(2022, 10, 25);
        $sku->course = $course;

        list($numberOfUnits, $firstCycleUnits, $midCycleUnits, $lastCycleUnits)
            = resolve(SkuService::class)->calculateTimeBasedNumberOfUnits($sku, $today);

        $this->assertEquals(3, $numberOfUnits);
        $this->assertEquals(0.3, $firstCycleUnits);
        $this->assertEquals(2, $midCycleUnits);
        $this->assertEquals(0.7, $lastCycleUnits);

        $today = Carbon::create(2022, 7, 25);

        $course = new Course();
        $course->start_date = Carbon::create(2022, 01, 4);
        $course->end_date = Carbon::create(2022, 12, 31);

        $sku = new Sku();
        $sku->start_date = Carbon::create(2022, 7, 16);
        $sku->end_date = Carbon::create(2022, 8, 4);
        $sku->course = $course;

        list($numberOfUnits, $firstCycleUnits, $midCycleUnits, $lastCycleUnits)
            = resolve(SkuService::class)->calculateTimeBasedNumberOfUnits($sku, $today);

        $this->assertEquals(0.3, $numberOfUnits);
        $this->assertEquals(0.3, $firstCycleUnits);
        $this->assertEquals(0, $midCycleUnits);
        $this->assertEquals(0, $lastCycleUnits);
    }
}

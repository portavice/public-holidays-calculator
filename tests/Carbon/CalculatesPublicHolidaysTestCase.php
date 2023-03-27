<?php

namespace Tests\Carbon;

use Carbon\Carbon;
use PHPUnit\Framework\Attributes\CoversClass;
use Portavice\PublicHolidays\Carbon\Traits\CalculatesPublicHolidays;

#[CoversClass(CalculatesPublicHolidays::class)]
class CalculatesPublicHolidaysTestCase extends AbstractCarbonTestCase
{
    final public function testIsPublicHoliday(): void
    {
        self::setGermanPublicHolidays();
        $this->assertTrue(Carbon::create(2022, 4, 18)->isPublicHoliday()); // Easter Monday
        $this->assertTrue(Carbon::create(2022, 10, 3)->isPublicHoliday());

        $this->assertFalse(Carbon::create(2022, 9, 5)->isPublicHoliday());
        $this->assertFalse(Carbon::create(2022, 10, 4)->isPublicHoliday());
    }

    final public function testPublicHolidaysInYear(): void
    {
        self::setGermanPublicHolidays();
        $this->assertCount(13, Carbon::publicHolidays(2022));
        $this->assertCount(13, $this->date(2022, 4, 18)->publicHolidaysInYear());
    }

    final public function testPublicHolidaysUntil(): void
    {
        self::setGermanPublicHolidays();
        $startOf2022 = Carbon::create(2022);
        $endOf2022 = $startOf2022->clone()->endOfYear();
        $this->assertCount(13, Carbon::publicHolidaysBetween($startOf2022, $endOf2022));
        $this->assertCount(13, $startOf2022->publicHolidaysUntil($endOf2022));

        $easter2022 = Carbon::create(2022, 4, 18);
        $this->assertCount(11, Carbon::publicHolidaysBetween($easter2022, $endOf2022));
        $this->assertCount(11, $easter2022->publicHolidaysUntil($endOf2022));
    }

    final public function testAllMethodsWithoutCalculator(): void
    {
        self::setNoPublicHolidays();

        // No calculator is set, so Easter Monday is just a normal Monday.
        $this->assertTrue(Carbon::create(2022, 4, 18)->isWorkingDay());

        // Easter Sunday is still no working day.
        $this->assertFalse(Carbon::create(2022, 4, 17)->isWorkingDay());

        $this->assertCount(0, Carbon::create(2022)->publicHolidaysUntil(Carbon::create(2022, 12, 31)));
    }
}

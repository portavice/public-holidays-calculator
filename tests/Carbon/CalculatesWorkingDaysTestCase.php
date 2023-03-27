<?php

namespace Tests\Carbon;

use Carbon\Carbon;
use PHPUnit\Framework\Attributes\CoversClass;
use Portavice\PublicHolidays\Carbon\Traits\CalculatesWorkingDays;

#[CoversClass(CalculatesWorkingDays::class)]
class CalculatesWorkingDaysTestCase extends AbstractCarbonTestCase
{
    final public function testIsWorkingDay(): void
    {
        self::setGermanPublicHolidays();

        // Normal working days.
        $this->assertTrue(Carbon::create(2022, 10, 28)->isWorkingDay());

        // Public holidays.
        $this->assertFalse(Carbon::create(2022, 10, 3)->isWorkingDay());

        // Weekend days.
        $this->assertFalse(Carbon::create(2022, 10, 29)->isWorkingDay()); // Saturday
        $this->assertFalse(Carbon::create(2022, 10, 30)->isWorkingDay()); // Sunday
    }

    final public function testAddWorkingDayWithOctober2022(): void
    {
        self::setGermanPublicHolidays();
        $this->assertEquals($this->date(2022, 10, 4), $this->date(2022, 9, 30)->addWorkingDay());
        $this->assertEquals($this->date(2022, 10, 4), $this->date(2022, 10, 1)->addWorkingDay());
        $this->assertEquals($this->date(2022, 10, 4), $this->date(2022, 10, 2)->addWorkingDay());
        $this->assertEquals($this->date(2022, 10, 4), $this->date(2022, 10, 3)->addWorkingDay());

        $this->assertEquals($this->date(2022, 10, 5), $this->date(2022, 10, 4)->addWorkingDay());
        $this->assertEquals($this->date(2022, 10, 6), $this->date(2022, 10, 5)->addWorkingDay());
        $this->assertEquals($this->date(2022, 10, 7), $this->date(2022, 10, 6)->addWorkingDay());

        $this->assertEquals($this->date(2022, 10, 10), $this->date(2022, 10, 7)->addWorkingDay());
        $this->assertEquals($this->date(2022, 10, 10), $this->date(2022, 10, 8)->addWorkingDay());
        $this->assertEquals($this->date(2022, 10, 10), $this->date(2022, 10, 9)->addWorkingDay());

        $this->assertEquals($this->date(2022, 10, 11), $this->date(2022, 10, 10)->addWorkingDay());
    }

    final public function testAddWorkingDayWithDecember2022(): void
    {
        self::setGermanPublicHolidays();
        $this->assertEquals($this->date(2022, 12, 23), $this->date(2022, 12, 22)->addWorkingDay());

        $this->assertEquals($this->date(2022, 12, 27), $this->date(2022, 12, 23)->addWorkingDay());
        $this->assertEquals($this->date(2022, 12, 27), $this->date(2022, 12, 24)->addWorkingDay());
        $this->assertEquals($this->date(2022, 12, 27), $this->date(2022, 12, 25)->addWorkingDay());
        $this->assertEquals($this->date(2022, 12, 27), $this->date(2022, 12, 26)->addWorkingDay());

        $this->assertEquals($this->date(2022, 12, 28), $this->date(2022, 12, 27)->addWorkingDay());
        $this->assertEquals($this->date(2022, 12, 29), $this->date(2022, 12, 28)->addWorkingDay());
        $this->assertEquals($this->date(2022, 12, 30), $this->date(2022, 12, 29)->addWorkingDay());

        $this->assertEquals($this->date(2023, 1, 2), $this->date(2022, 12, 30)->addWorkingDay());
        $this->assertEquals($this->date(2023, 1, 2), $this->date(2022, 12, 31)->addWorkingDay());
        $this->assertEquals($this->date(2023, 1, 2), $this->date(2023, 1, 1)->addWorkingDay());
        $this->assertEquals($this->date(2023, 1, 3), $this->date(2023, 1, 2)->addWorkingDay());
    }

    final public function testAddZeroWorkingDays(): void
    {
        self::setGermanPublicHolidays();
        $this->assertEquals($this->date(2022, 10, 4), $this->date(2022, 10, 4)->addWorkingDays(0));
    }

    final public function testAddTwoWorkingDays(): void
    {
        self::setGermanPublicHolidays();
        $this->assertEquals($this->date(2022, 12, 23), $this->date(2022, 12, 21)->addWorkingDays(2));

        $this->assertEquals($this->date(2022, 12, 27), $this->date(2022, 12, 22)->addWorkingDays(2));

        $this->assertEquals($this->date(2022, 12, 28), $this->date(2022, 12, 23)->addWorkingDays(2));
        $this->assertEquals($this->date(2022, 12, 28), $this->date(2022, 12, 24)->addWorkingDays(2));
        $this->assertEquals($this->date(2022, 12, 28), $this->date(2022, 12, 25)->addWorkingDays(2));
        $this->assertEquals($this->date(2022, 12, 28), $this->date(2022, 12, 26)->addWorkingDays(2));

        $this->assertEquals($this->date(2022, 12, 29), $this->date(2022, 12, 27)->addWorkingDays(2));
    }

    final public function testAddTenWorkingDays(): void
    {
        self::setGermanPublicHolidays();
        $this->assertEquals($this->date(2023, 1, 6), $this->date(2022, 12, 22)->addWorkingDays(10));

        $this->assertEquals($this->date(2023, 1, 9), $this->date(2022, 12, 23)->addWorkingDays(10));
        $this->assertEquals($this->date(2023, 1, 9), $this->date(2022, 12, 24)->addWorkingDays(10));
        $this->assertEquals($this->date(2023, 1, 9), $this->date(2022, 12, 25)->addWorkingDays(10));
        $this->assertEquals($this->date(2023, 1, 9), $this->date(2022, 12, 26)->addWorkingDays(10));

        $this->assertEquals($this->date(2023, 1, 10), $this->date(2022, 12, 27)->addWorkingDays(10));
        $this->assertEquals($this->date(2023, 1, 11), $this->date(2022, 12, 28)->addWorkingDays(10));
        $this->assertEquals($this->date(2023, 1, 12), $this->date(2022, 12, 29)->addWorkingDays(10));
    }

    final public function testSubWorkingDay(): void
    {
        self::setGermanPublicHolidays();
        $this->assertEquals($this->date(2022, 12, 21), $this->date(2022, 12, 22)->subWorkingDay());
        $this->assertEquals($this->date(2022, 12, 22), $this->date(2022, 12, 23)->subWorkingDay());

        $this->assertEquals($this->date(2022, 12, 23), $this->date(2022, 12, 24)->subWorkingDay());
        $this->assertEquals($this->date(2022, 12, 23), $this->date(2022, 12, 25)->subWorkingDay());
        $this->assertEquals($this->date(2022, 12, 23), $this->date(2022, 12, 26)->subWorkingDay());
        $this->assertEquals($this->date(2022, 12, 23), $this->date(2022, 12, 27)->subWorkingDay());

        $this->assertEquals($this->date(2022, 12, 27), $this->date(2022, 12, 28)->subWorkingDay());
        $this->assertEquals($this->date(2022, 12, 28), $this->date(2022, 12, 29)->subWorkingDay());
        $this->assertEquals($this->date(2022, 12, 29), $this->date(2022, 12, 30)->subWorkingDay());

        $this->assertEquals($this->date(2022, 12, 30), $this->date(2022, 12, 31)->subWorkingDay());
        $this->assertEquals($this->date(2022, 12, 30), $this->date(2023, 1, 1)->subWorkingDay());
        $this->assertEquals($this->date(2022, 12, 30), $this->date(2023, 1, 2)->subWorkingDay());

        $this->assertEquals($this->date(2023, 1, 2), $this->date(2023, 1, 3)->subWorkingDay());
        $this->assertEquals($this->date(2023, 1, 3), $this->date(2023, 1, 4)->subWorkingDay());
    }
}

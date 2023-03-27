<?php

namespace Tests\Holidays;

use Carbon\Carbon;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Portavice\PublicHolidays\Holidays\FixedHoliday;

#[CoversClass(FixedHoliday::class)]
class FixedHolidayTest extends TestCase
{
    final public function testFixedHoliday(): void
    {
        $this->assertHoliday(2022, 1, 1);
        $this->assertHoliday(2022, 10, 3);
    }

    final public function assertHoliday(int $year, int $month, int $day): void
    {
        $this->assertEquals(
            Carbon::create($year, $month, $day),
            (new FixedHoliday($month, $day))->getDateForYear($year)
        );
    }

    final public function testCannotCreateWithInvalidMonth(): void
    {
        $this->expectExceptionMessage('Invalid month');
        new FixedHoliday(13, 1);
    }

    final public function testCannotCreateWithInvalidDay(): void
    {
        $this->expectExceptionMessage('Invalid day');
        new FixedHoliday(2, 30);
    }
}

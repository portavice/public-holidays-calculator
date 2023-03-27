<?php

namespace Tests\Holidays;

use Carbon\Carbon;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Portavice\PublicHolidays\Holidays\FlexibleHoliday;

#[CoversClass(FlexibleHoliday::class)]
class FlexibleHolidayTest extends TestCase
{
    final public function testCalculatesMaundryThursday(): void
    {
        $h = FlexibleHoliday::MaundyThursday;
        $this->assertHoliday($h, 2022, 4, 14);
        $this->assertHoliday($h, 2023, 4, 6);
    }

    final public function testCalculatesGoodFriday(): void
    {
        $h = FlexibleHoliday::GoodFriday;
        $this->assertHoliday($h, 2022, 4, 15);
        $this->assertHoliday($h, 2023, 4, 7);
    }

    final public function testCalculatesEasterSunday(): void
    {
        $h = FlexibleHoliday::EasterSunday;
        $this->assertHoliday($h, 2022, 4, 17);
        $this->assertHoliday($h, 2023, 4, 9);
    }

    final public function testCalculatesEasterMonday(): void
    {
        $h = FlexibleHoliday::EasterMonday;
        $this->assertHoliday($h, 2022, 4, 18);
        $this->assertHoliday($h, 2023, 4, 10);
    }

    final public function testCalculatesAscension(): void
    {
        $h = FlexibleHoliday::Ascension;
        $this->assertHoliday($h, 2022, 5, 26);
        $this->assertHoliday($h, 2023, 5, 18);
    }

    final public function testCalculatesWhitSunday(): void
    {
        $h = FlexibleHoliday::WhitSunday;
        $this->assertHoliday($h, 2022, 6, 5);
        $this->assertHoliday($h, 2023, 5, 28);
    }

    final public function testCalculatesWhitMonday(): void
    {
        $h = FlexibleHoliday::WhitMonday;
        $this->assertHoliday($h, 2022, 6, 6);
        $this->assertHoliday($h, 2023, 5, 29);
    }

    final public function testCalculatesCorpusChristi(): void
    {
        $h = FlexibleHoliday::CorpusChristi;
        $this->assertHoliday($h, 2022, 6, 16);
        $this->assertHoliday($h, 2023, 6, 8);
    }

    final public function assertHoliday(FlexibleHoliday $h, int $year, int $month, int $day): void
    {
        $this->assertEquals(Carbon::create($year, $month, $day), $h->getDateForYear($year));
    }
}

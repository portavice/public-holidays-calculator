<?php

namespace Tests\Carbon;

use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use Portavice\PublicHolidays\Carbon\Calculator;
use Portavice\PublicHolidays\Holidays\FixedHoliday;
use Portavice\PublicHolidays\Holidays\FlexibleHoliday;

abstract class AbstractCarbonTestCase extends TestCase
{
    public static function setNoPublicHolidays(): void
    {
        Calculator::register();
        Carbon::setPublicHolidays(null);
    }

    public static function setGermanPublicHolidays(): void
    {
        Calculator::register();
        Carbon::setPublicHolidays([
            new FixedHoliday(1, 1), // New Year's Day
            new FixedHoliday(5, 1), // Labor Day
            new FixedHoliday(10, 3), // German Unity Day
            new FixedHoliday(11, 1), // All Saints' Day
            new FixedHoliday(12, 24), // Christmas Eve
            new FixedHoliday(12, 25), // Christmas Day
            new FixedHoliday(12, 26), // Boxing Day
            new FixedHoliday(12, 31), // New Year's Eve
            FlexibleHoliday::GoodFriday,
            FlexibleHoliday::EasterMonday,
            FlexibleHoliday::Ascension,
            FlexibleHoliday::WhitMonday,
            FlexibleHoliday::CorpusChristi,
        ]);
    }

    final public function date(int $year, int $month, int $day): Carbon
    {
        return Carbon::create($year, $month, $day)->setTime(12, 0);
    }
}

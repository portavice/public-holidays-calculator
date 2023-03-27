<?php

namespace Tests;

use Carbon\Carbon;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Portavice\PublicHolidays\Carbon\Calculator;
use Portavice\PublicHolidays\Holidays\FixedHoliday;
use Portavice\PublicHolidays\Holidays\FlexibleHoliday;

#[CoversClass(Calculator::class)]
class CalculatorTest extends TestCase
{
    private const FIXED_HOLIDAYS = [
        [1, 1],
        [5, 1],
        [10, 3],
        [11, 1],
        [12, 25],
        [12, 26],
    ];

    final public function testGetHolidaysInYearWithFixedHolidays(): void
    {
        $expectedResult = [];
        foreach (self::FIXED_HOLIDAYS as [$month, $day]) {
            $expectedResult[] = Carbon::create(2022, $month, $day);
        }

        $holidaysIn2022 = $this->getCalculatorWithFixedHolidays()->getHolidaysInYear(2022);
        $this->assertCount(6, $holidaysIn2022);
        $this->assertEquals($expectedResult, $holidaysIn2022);
    }

    final public function testCacheIsClearedWhenNewHolidayIsAdded(): void
    {
        $calculator = $this->getCalculatorWithFixedHolidays();
        $this->assertCount(6, $calculator->getHolidaysInYear(2022));

        $calculator->addFixedHoliday(1, 6);
        $this->assertCount(7, $calculator->getHolidaysInYear(2022));
    }

    private function getCalculatorWithFixedHolidays(): Calculator
    {
        $calculator = new Calculator();
        foreach (self::FIXED_HOLIDAYS as $fixedHoliday) {
            [$month, $day] = $fixedHoliday;
            $calculator->addFixedHoliday($month, $day);
        }

        return $calculator;
    }

    final public function testGetHolidaysInYearWithEaster(): void
    {
        $calculator = $this->getCalculatorWithEaster();
        $holidaysIn2022 = $calculator->getHolidaysInYear(2022);
        $this->assertCount(3, $holidaysIn2022);

        $expectedResult = [
            Carbon::create(2022),
            Carbon::create(2022, 4, 17),
            Carbon::create(2022, 4, 18),
        ];
        $this->assertEquals($expectedResult, $holidaysIn2022);
    }

    final public function testGetHolidaysInRangeWithEaster(): void
    {
        $calculator = $this->getCalculatorWithEaster();

        $newYear22 = Carbon::create(2022);
        $easterSun22 = Carbon::create(2022, 4, 17);
        $easterMon22 = Carbon::create(2022, 4, 18);
        $newYear23 = Carbon::create(2023);
        $easterSun23 = Carbon::create(2023, 4, 9);
        $easterMon23 = Carbon::create(2023, 4, 10);
        $endOf23 = Carbon::create(2023, 12, 31);

        $this->assertEquals(
            [$newYear22, $easterSun22, $easterMon22, $newYear23, $easterSun23, $easterMon23],
            $calculator->getHolidaysInRange(Carbon::create(2022), $endOf23)
        );

        $this->assertEquals(
            [$easterMon22, $newYear23, $easterSun23, $easterMon23],
            $calculator->getHolidaysInRange($easterMon22, $endOf23)
        );

        $this->assertEquals(
            [$easterMon22, $newYear23, $easterSun23],
            $calculator->getHolidaysInRange($easterMon22, $easterSun23)
        );
    }

    private function getCalculatorWithEaster(): Calculator
    {
        $calculator = new Calculator([
            new FixedHoliday(1, 1),
        ]);
        $calculator->addHoliday(FlexibleHoliday::EasterSunday);
        $calculator->addHoliday(FlexibleHoliday::EasterMonday);

        return $calculator;
    }
}

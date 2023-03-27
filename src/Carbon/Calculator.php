<?php

namespace Portavice\PublicHolidays\Carbon;

use Carbon\Carbon;
use Portavice\PublicHolidays\Carbon\Traits\CalculatesPublicHolidays;
use Portavice\PublicHolidays\Carbon\Traits\CalculatesWorkingDays;
use Portavice\PublicHolidays\Holidays\FixedHoliday;
use Portavice\PublicHolidays\Holidays\HolidayDefinition;
use ReflectionException;

class Calculator
{
    private array $holidayCache = [];

    public function __construct(
        private array $holidayDefinitions = []
    ) {
        foreach ($this->holidayDefinitions as $holidayDefinition) {
            assert($holidayDefinition instanceof HolidayDefinition);
        }
    }

    final public function addHoliday(HolidayDefinition $holidayDefinition): void
    {
        $this->holidayDefinitions[] = $holidayDefinition;
        $this->clearCache();
    }

    final public function addFixedHoliday(int $month, int $day): void
    {
        $this->addHoliday(new FixedHoliday($month, $day));
    }

    private function calculateHolidaysInYear(int $year): array
    {
        return array_map(
            static fn (HolidayDefinition $holidayDefinition) => $holidayDefinition->getDateForYear($year),
            $this->holidayDefinitions
        );
    }

    final public function clearCache(): void
    {
        $this->holidayCache = [];
    }

    final public function getHolidaysInYear(int $year): array
    {
        if (!isset($this->holidayCache[$year])) {
            $this->holidayCache[$year] = $this->calculateHolidaysInYear($year);
        }

        return $this->holidayCache[$year];
    }

    final public function getHolidaysInRange(Carbon $start, Carbon $end): array
    {
        $holidays = [];
        foreach (range($start->year, $end->year) as $year) {
            foreach ($this->getHolidaysInYear($year) as $holiday) {
                $holidays[] = $holiday;
            }
        }

        return array_values(
            array_filter(
                $holidays,
                static fn (Carbon $holiday) => $holiday->greaterThanOrEqualTo($start)
                    && $holiday->lessThanOrEqualTo($end)
            )
        );
    }

    /**
     * @throws ReflectionException
     */
    public static function register(): void
    {
        Carbon::mixin(CalculatesPublicHolidays::class);
        Carbon::mixin(CalculatesWorkingDays::class);
    }
}

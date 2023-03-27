<?php

namespace Portavice\PublicHolidays\Holidays;

use Carbon\Carbon;
use InvalidArgumentException;

class FixedHoliday implements HolidayDefinition
{
    public function __construct(
        private readonly int $month,
        private readonly int $day
    ) {
        if (
            $this->month < 1
            || $this->month > 12
        ) {
            throw new InvalidArgumentException('Invalid month');
        }

        if (
            $this->day < 1
            || ($this->month === 2 && $day > 29)
            || (in_array($this->month, [1, 3, 5, 7, 8, 10, 12], true) && $day > 31)
            || (in_array($this->month, [4, 6, 9, 11], true) && $day > 30)
        ) {
            throw new InvalidArgumentException('Invalid day');
        }
    }

    final public function getDateForYear(int $year): Carbon
    {
        return Carbon::create($year, $this->month, $this->day);
    }
}

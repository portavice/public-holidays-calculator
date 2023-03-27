<?php

namespace Portavice\PublicHolidays\Carbon\Traits;

use Carbon\Carbon;
use Portavice\PublicHolidays\Carbon\Calculator;

/**
 * @mixin Carbon
 */
trait CalculatesPublicHolidays
{
    private static ?Calculator $calculator = null;

    public static function setPublicHolidays(Calculator|array|null $publicHolidays = null): void
    {
        self::$calculator = is_array($publicHolidays)
            ? new Calculator($publicHolidays)
            : $publicHolidays;
    }

    final public function isPublicHoliday(): bool
    {
        return in_array(
            $this->format('m-d'),
            array_map(
                static fn(Carbon $holiday) => $holiday->format('m-d'),
                $this->publicHolidaysInYear()
            ),
            true
        );
    }

    final public static function publicHolidays(int $year): array
    {
        if (self::$calculator === null) {
            return [];
        }

        return self::$calculator->getHolidaysInYear($year);
    }

    final public static function publicHolidaysBetween(Carbon $from, Carbon $until): array
    {
        if (self::$calculator === null) {
            return [];
        }

        return self::$calculator->getHolidaysInRange($from->startOfDay(), $until->endOfDay());
    }

    final public function publicHolidaysInYear(): array
    {
        return self::publicHolidays($this->year);
    }

    final public function publicHolidaysUntil(Carbon $until): array
    {
        return self::publicHolidaysBetween($this, $until);
    }
}

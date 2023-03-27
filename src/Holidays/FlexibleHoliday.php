<?php

namespace Portavice\PublicHolidays\Holidays;

use Carbon\Carbon;

// phpcs:disable PHPCompatibility.Variables.ForbiddenThisUseContexts.OutsideObjectContext
enum FlexibleHoliday implements HolidayDefinition
{
    case MaundyThursday;
    case GoodFriday;
    case EasterSunday;
    case EasterMonday;
    case Ascension;
    case WhitSunday;
    case WhitMonday;
    case CorpusChristi;

    private function getEasterSundayOffset(): int
    {
        return match ($this) {
            self::MaundyThursday => - 3,
            self::GoodFriday => - 2,
            self::EasterSunday => 0,
            self::EasterMonday => 1,
            self::Ascension => 39,
            self::WhitSunday => 49,
            self::WhitMonday => 50,
            self::CorpusChristi => 60,
        };
    }

    public function getDateForYear(int $year): Carbon
    {
        return Carbon::create($year, 3, 21)
            ->addDays(easter_days($year))
            ->addDays($this->getEasterSundayOffset());
    }
}

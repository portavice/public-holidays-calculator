<?php

namespace Portavice\PublicHolidays\Holidays;

use Carbon\Carbon;

interface HolidayDefinition
{
    public function getDateForYear(int $year): Carbon;
}

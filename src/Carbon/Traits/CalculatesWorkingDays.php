<?php

namespace Portavice\PublicHolidays\Carbon\Traits;

use Carbon\Carbon;

/**
 * @mixin CalculatesPublicHolidays|Carbon
 */
trait CalculatesWorkingDays
{
    final public function addWorkingDay(): static
    {
        return $this->addWorkingDays(1);
    }

    final public function addWorkingDays(int $days): static
    {
        if ($days === 0) {
            return $this;
        }

        $forward = $days > 0;
        $date = $this;
        foreach (range(1, abs($days)) as $ignored) {
            $date = $date->nextOrPreviousWorkingDay($forward);
        }

        return $date;
    }

    final public function isWorkingDay(): bool
    {
        return $this->isWeekday()
            && !$this->isPublicHoliday();
    }

    private function nextOrPreviousWorkingDay(bool $forward): static
    {
        $step = $forward ? 1 : -1;
        $date = $this;

        do {
            $date = $date->addDays($step);
        } while (!$date->isWorkingDay());

        return $date;
    }

    final public function subWorkingDay(): static
    {
        return $this->subWorkingDays(1);
    }

    final public function subWorkingDays(int $days): static
    {
        return $this->addWorkingDays(-$days);
    }
}

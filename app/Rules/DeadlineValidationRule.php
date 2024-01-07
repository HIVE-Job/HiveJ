<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;

class DeadlineValidationRule implements Rule
{
    public function passes($attribute, $value)
    {
        $currentDate = now()->startOfDay();
        $deadlineDate = \Carbon\Carbon::parse($value)->startOfDay();

        return $deadlineDate->isAfter($currentDate);
    }

    public function message()
    {
        return 'The deadline must be at least one day after today.';
    }
}

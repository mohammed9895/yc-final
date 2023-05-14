<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class TripleName implements ValidationRule
{
    public function passes($attribute, $value)
    {
        $names = explode(' ', $value);
        return count($names) === 3;
    }

    public function message()
    {
        return 'The :attribute field must contain three names separated by spaces.';
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->passes($attribute, $value)) {
            $validator->addError($attribute, $this->message());
        }
    }
}

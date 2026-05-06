<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PhoneNumberRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string, ?string=): void  $fail
     */


    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Bangladesh mobile number: 11 digit, starts with 01, second digit 3-9
        if (!preg_match('/^01[3-9][0-9]{8}$/', $value)) {
            // $fail('ফোন নম্বরটি অবশ্যই ১১ সংখ্যার মোবাইল নম্বর হতে হবে।');
            $fail("The {$attribute} must be a valid phone number.");
        }
    }
}

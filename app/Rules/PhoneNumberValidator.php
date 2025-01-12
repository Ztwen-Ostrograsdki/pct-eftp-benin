<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Validator;

class PhoneNumberValidator implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(strlen($value) >= 10){

            if(strpos("-", $value)){

                $parts = explode("-", $value);

                foreach($parts as $number){

                    $validator = Validator::make(
                        data: [
                            'contacts' => $number
                        ],
                        rules: [
                            'contacts' => ['required', 'numeric', 'starts_with:01', 'digits:10']
                        ],
                    );
                }

                if(!$validator){

                    $fail("Le formats des contacts n'est pas conforme");
                }
            }
            else{
                $fail("Le formats des contacts n'est pas conforme");

            }

        }
        else{
            $fail("Le formats des contacts n'est pas conforme");
        }
    }
}

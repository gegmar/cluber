<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class SeatMapLayout implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $name = 'my_layout-validation';
        $this->name = $name;
    }

    /**
     * Determine if the validation rule passes.
     * Only allow structures like...
     * 
     * 'aaaaaaa______aaaaaaa',
     * 'aaaaaaaaa____aaaaaaa',
     * 'aaaaaaaaa____aaaaaaa',
     * 'aaaaaaaaa____aaaaaaa',
     * 'aaaaaaaaa____aaaaaa',
     * 'aaaaaaaaaa__aaaaaa',
     * 'aaaaaaaaaaaaaaaaaa',
     *
     * @param  string  $attribute name of the validated field
     * @param  mixed  $value of the validated field
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Only 
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The layout does not comply to the required format.';
    }
}

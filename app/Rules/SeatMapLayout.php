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
        //
    }

    /**
     * Determine if the validation rule passes.
     * Only allow json structures like...
     * 
     * [
     *      "aaaaaaa______aaaaaaa",
     *      "aaaaaaa______aaaaaaa",
     *      "aaaaaaa_____aaaaaaa",
     *      "aaaaaaa____aaaaaaa",
     *      "aaaaaaa___aaaaaaa",
     *      ...
     * ]
     *
     * @param  string  $attribute name of the validated field
     * @param  mixed  $value of the validated field
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if($value === NULL || $value === "") {
            // it is allowed for the value to be empty
            return true;
        }

        // try to decode the json array with the expected format
        $rows = json_decode($value);

        // if json_decode result is falsy, then json object could
        // not be decoded and therefore the input is invalid
        if(!$rows) {
            return false;
        }

        // iterate over all rows to check that only valid
        // characters ('a' and '_') have been submitted
        foreach( $rows as $row ) {
            // explanation for regex ^[a_]*$
            //  ^     = Start of string
            //  [a_]  = Only characters "a" and "_" allowed
            //  *     = zero or more characters
            //  $     = End of string
            // Complete: Only match strings that contain from start to end only zero or more characters on the whitelist of a and _
            if( !preg_match('/^[a_]*$/', $row) ) {
                return false;
            }
        }

        // finally return true for a valid input,
        // since no previous check proved the contrary
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

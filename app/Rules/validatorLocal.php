<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class validatorLocal implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $latitud;
    private $longitud;
    public function __construct($latitud,$longitud)
    {
        $this->latitud = $latitud;
        $this->longitud = $longitud;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // $this->atributo = $attribute;
        // $data = json_decode($value,true);
       
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}

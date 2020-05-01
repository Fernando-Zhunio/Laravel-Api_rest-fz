<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class validar_arreglos_rule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $max;
    private $min;
    public function __construct($min, $max)
    {
        $this->min =$min;
        $this->max = $max;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    private $atributo;
    private $cantidad;

    public function passes($attribute, $value)
    {
        $this->atributo = $attribute;
        $data = json_decode($value,true);
        $can = count($data);
        $this->cantidad = $can;
        if($can >= $this->min && $can <= $this->max) return true;
        else return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The minimo es '.$this->min.' y el maximo es '.$this->max.' para el '.$this->atributo.' y tiene '.$this->cantidad;
    }
}

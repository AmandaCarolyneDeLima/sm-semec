<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class ConfirmCurrentPassword implements Rule
{
    /**
     *
     * @var  string $password
     */
    private $password;
    /**
     * Create a new rule instance.
     *
     * @return void
     * @param  mixed $password
     */
    public function __construct($password)
    {
        $this->password = $password;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     *
     * @SuppressWarnings(PHPMD)
     */
    public function passes($attribute, $value)
    {

        return Hash::check($value, $this->password);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'A senha atual está incorreta';
    }
}

<?php

namespace App\Traits;

trait DateTimeFormatter
{
    public function getDateFormat()
    {
        return 'd/m/Y H:i';
    }

    /*
     * From: https://github.com/laravel/framework/blob/7f1a1091daacd44334d6b4049faf838c7e52b620/src/Illuminate/Database/Eloquent/Concerns/HasAttributes.php
     * Original:
     * Convert a DateTime to a storable string.
     *
     * @param  mixed  $value
     * @return string|null
     *   public function fromDateTime($value)
     *   {
     *      return empty($value) ? $value : $this->asDateTime($value)->format(
     *       $this->getDateFormat()
     *      );
     *   }
     */
    public function fromDateTime($value)
    {
        return empty($value) ? $value : $this->asDateTime($value)->format('Y-m-d H:i:s');
    }
}

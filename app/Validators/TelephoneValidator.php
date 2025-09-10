<?php

namespace Validators;

use Src\Validator\AbstractValidator;

class TelephoneValidator extends AbstractValidator
{
    protected string $message = 'Некорректный номер телефона';

    public function rule(): bool
    {
        if (!preg_match('/^(\+7|8)\d{10}$/', preg_replace('/\D/', '', $this->value))) {
            return false;
        }

        return true;
    }
}

<?php

namespace Validators;

use Illuminate\Database\Capsule\Manager as Capsule;
use Src\Validator\AbstractValidator;
use Model\Authors;

class FullNameValidator extends AbstractValidator
{
    protected string $message = 'Автор с такими ФИО уже существует';

    public function rule(): bool
    {

        if (is_string($this->value)) {
            $parts = explode(' ', $this->value);
            $this->value = [
                'last_name' => $parts[0] ?? '',
                'first_name' => $parts[1] ?? '',
                'patronym' => $parts[2] ?? null,
            ];
        }

        if (empty($this->value['last_name']) || empty($this->value['first_name'])) {
            return true;
        }

        $query = Capsule::table($this->args[0])->where('last_name', $this->value['last_name'])
            ->where('first_name', $this->value['first_name']);

        if (!empty($this->value['patronym'])) {
            $query->where('patronym', $this->value['patronym']);
        } else {
            $query->where(function($q) {
                $q->where('patronym', '')
                    ->orWhereNull('patronym');
            });
        }

        return !$query->exists();
    }
}
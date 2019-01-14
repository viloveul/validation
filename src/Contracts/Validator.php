<?php

namespace Viloveul\Validation\Contracts;

interface Validator
{
    public function errors(): array;

    public function rules(): array;

    /**
     * @param $rule
     */
    public function validate(string $rule): bool;
}

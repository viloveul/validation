<?php

namespace Viloveul\Validation;

use Valitron\Validator as ValitronValidator;
use Viloveul\Validation\Contracts\Validator as IValidator;
use Viloveul\Validation\Message;

abstract class Validator implements IValidator
{
    /**
     * @var array
     */
    protected $params = [];

    /**
     * @var mixed
     */
    protected $validator;

    /**
     * @param array $data
     * @param array $params
     */
    public function __construct(array $data, array $params = [])
    {
        $this->params = $params;
        $this->validator = new ValitronValidator($data);
        if (method_exists($this, 'boot')) {
            $this->boot();
        }
    }

    /**
     * @return mixed
     */
    public function errors(): array
    {
        return $this->normalizeErrors(
            $this->validator->errors()
        );
    }

    /**
     * @param  $rule
     * @return mixed
     */
    public function validate($rule): bool
    {
        $rules = $this->rules();
        if (array_key_exists($rule, $this->rules())) {
            $this->validator->mapFieldsRules($rules[$rule]);
        }
        return $this->validator->validate();
    }

    /**
     * @param  array   $messages
     * @return mixed
     */
    protected function normalizeErrors(array $messages)
    {
        $errors = [];
        foreach ($messages as $key => $errArray) {
            foreach ($errArray as $error) {
                $errors[] = new Message($key, $error);
            }
        }
        return $errors;
    }
}

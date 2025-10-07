<?php
namespace App\Validators;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class ClientValidator extends LaravelValidator {

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'state_id' => ['nullable', 'integer', 'exists:states,id'],
            'city_id'  => ['nullable', 'integer', 'exists:cities,id'],
            'name'  => ['required', 'string', 'max:128'],
            'logo'  => ['sometimes', 'file'],
            'cnpj'  => ['required', 'string', 'max:32'],
            'contact'  => ['required', 'string', 'max:128'],
            'email'  => ['required', 'email', 'max:128'],
            'password'  => ['required', 'string', 'min:8'],
            'active' => ['required', 'boolean']
        ],
        ValidatorInterface::RULE_UPDATE => [
            'state_id' => ['sometimes', 'integer', 'exists:states,id'],
            'city_id'  => ['sometimes', 'integer', 'exists:cities,id'],
            'name'  => ['sometimes', 'string', 'max:128'],
            'logo'  => ['sometimes', 'file'],
            'cnpj'  => ['sometimes', 'string', 'max:32'],
            'contact'  => ['sometimes', 'string', 'max:128'],
            'email'  => ['sometimes', 'email', 'max:128'],
            'password'  => ['sometimes', 'string', 'min:8'],
            'active' => ['sometimes', 'boolean']
        ]
    ];

}

<?php
namespace App\Validators;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class UserValidator extends LaravelValidator {

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name'  => ['required', 'string', 'max:128'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'avatar' => ['nullable', 'file', 'image', 'max:5000']
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name'  => ['sometimes', 'string', 'max:128'],
            'email' => ['sometimes', 'email', 'unique:users,email'],
            'password' => ['sometimes', 'string', 'min:8'],
            'avatar' => ['sometimes', 'file', 'image', 'max:5000']
        ]
    ];
}

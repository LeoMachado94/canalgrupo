<?php
namespace App\Validators;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class SubjectMatterValidator extends LaravelValidator {

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'client_id' => ['required', 'integer', 'exists:clients,id'],
            'user_id' => ['required', 'integer'],
            'title'  => ['required', 'string', 'max:128'],
        ],
        ValidatorInterface::RULE_UPDATE => [
            'client_id' => ['sometimes', 'integer', 'exists:clients,id'],
            'user_id' => ['sometimes', 'integer'],
            'title'  => ['sometimes', 'string', 'max:128'],
        ]
    ];

}

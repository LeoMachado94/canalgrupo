<?php
namespace App\Validators;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class VehicleValidator extends LaravelValidator {

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'state_id' => ['required', 'integer'],
            'city_id'  => ['required', 'integer'],
            'middle_id'  => ['required', 'integer'],
            'name'  => ['required', 'string', 'max:128'],
            'description'  => ['sometimes', 'string'],
            'active' => ['sometimes', 'boolean']
        ],
        ValidatorInterface::RULE_UPDATE => [
            'state_id' => ['sometimes', 'integer'],
            'city_id'  => ['sometimes', 'integer'],
            'middle_id'  => ['sometimes', 'integer'],
            'name'  => ['sometimes', 'string', 'max:128'],
            'description'  => ['sometimes', 'string'],
            'active' => ['sometimes', 'boolean']
        ]
    ];

}

<?php
namespace App\Validators;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class EditorialValidator extends LaravelValidator {

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'vehicle_id' => ['required', 'integer'],
            'title'  => ['required', 'string', 'max:128'],
            'hour'  => ['nullable', 'date_format:H:i'],
            'responsible' => ['nullable', 'string', 'max:128'],
            'description' => ['nullable', 'string'],
            'active' => ['sometimes', 'boolean']
        ],
        ValidatorInterface::RULE_UPDATE => [
            'vehicle_id' => ['sometimes', 'integer'],
            'title'  => ['sometimes', 'string', 'max:128'],
            'hour'  => ['sometimes', 'date_format:H:i'],
            'responsible' => ['sometimes', 'string', 'max:128'],
            'description' => ['sometimes', 'string'],
            'active' => ['sometimes', 'boolean']
        ]
    ];

}

<?php
namespace App\Validators;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class SummaryValidator extends LaravelValidator {

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'client_id' => ['required', 'integer'],
            'title'  => ['required', 'string', 'max:128'],
            'date'  => ['required', 'date_format:d/m/Y'],
            'file' => ['required', 'file', 'mimes:pdf']
        ],
        ValidatorInterface::RULE_UPDATE => [
            'client_id' => ['sometimes', 'integer'],
            'title'  => ['sometimes', 'string', 'max:128'],
            'date'  => ['sometimes', 'date_format:d/m/Y'],
            'file' => ['sometimes', 'file', 'mimes:pdf']
        ]
    ];

}

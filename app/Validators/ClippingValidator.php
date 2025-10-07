<?php
namespace App\Validators;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class ClippingValidator extends LaravelValidator {

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'client_id' => ['required', 'integer', 'exists:clients,id'],
            'title' => ['required', 'max:128'],
            'subject_matter_id' => ['required', 'integer', 'exists:subject_matters,id'],
            'middle_id' => ['required', 'integer', 'exists:middles,id'],
            'vehicle_id' => ['required', 'integer', 'exists:vehicles,id'],
            'editorial_id' => ['required', 'integer', 'exists:editorials,id'],
            'classification_id' => ['required', 'integer', 'exists:classifications,id'],
            'exhibition_id' => ['required', 'integer', 'exists:exhibitions,id'],
            'source_id' => ['required', 'integer', 'exists:sources,id'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'date' => ['required', 'date_format:d/m/Y'],
            'review' => ['required', 'string'],
        ],
        ValidatorInterface::RULE_UPDATE => [
            'client_id' => ['sometimes', 'integer', 'exists:clients,id'],
            'title' => ['sometimes', 'string', 'max:128'],
            'subject_matter_id' => ['sometimes', 'integer', 'exists:subject_matters,id'],
            'middle_id' => ['sometimes', 'integer', 'exists:middles,id'],
            'vehicle_id' => ['sometimes', 'integer', 'exists:vehicles,id'],
            'editorial_id' => ['sometimes', 'integer', 'exists:editorials,id'],
            'classification_id' => ['sometimes', 'integer', 'exists:classifications,id'],
            'exhibition_id' => ['sometimes', 'integer', 'exists:exhibitions,id'],
            'source_id' => ['sometimes', 'integer', 'exists:sources,id'],
            'user_id' => ['sometimes', 'integer', 'exists:users,id'],
            'date' => ['sometimes', 'date_format:d/m/Y'],
            'review' => ['sometimes', 'string'],
        ]
    ];

}

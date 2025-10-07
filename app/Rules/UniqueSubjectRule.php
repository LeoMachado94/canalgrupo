<?php

namespace App\Rules;

use App\Models\SubjectMatter;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Builder;

class UniqueSubjectRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $subject = SubjectMatter::where(function (Builder $builder) use ($value) {
            $builder->where('client_id', request()->input('client_id'));
            $builder->where('title', $value);
            return $builder;
        });

        return $subject->count() ? false : true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Já existe um assunto com este título cadastrado.';
    }
}

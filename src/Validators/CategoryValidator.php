<?php

namespace App\Validators;

use App\Table\CategoryTable;
use App\Validator;

class CategoryValidator extends AbstractValidator
{
    public function __construct(array $data, CategoryTable $table, ?int $id = null)
    {
        Validator::lang('fr');
        parent::__construct($data);
        $this->validator->rule('required', ['name', 'slug']);
        $this->validator->rule('lengthBetween', ['name', 'slug'], 3, 200);
        $this->validator->rule('slug', 'slug');
        $this->validator->rule(function($field, $value) use ($table, $id){
            return !$table->exists($field, $value, $id);
        }, ['slug','name'], 'Cette valeur est déjà utilisé');
    }

}
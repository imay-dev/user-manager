<?php

namespace App\Http\Requests;

use App\Services\JsonResponseService;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Pearl\RequestValidate\RequestAbstract;

/**
 * Class Request
 * @package App\Http\Requests
 */
abstract class Request extends RequestAbstract
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    abstract public function authorize();

    /**
     * @param Validator $validator
     * @throws ValidationException
     */
    public function failedValidation(Validator $validator): ValidationException
    {
        throw new ValidationException($validator,
            (new JsonResponseService())->fail([
                'errors' => $validator->errors()->messages(),
            ])
        );
    }
}

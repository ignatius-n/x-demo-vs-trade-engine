<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $symbolOptions  = 'in:' . implode(',', array_keys(getAssetOptions()));
        $sideOptions    = 'in:' . implode(',', array_keys(getSideOptions()));
        return [
            'symbol'    => ['required', 'string', $symbolOptions],
            'side'      => ['required', 'string', $sideOptions],
            'price'     => ['required', 'numeric', 'gt:0'],
            'amount'    => ['required', 'numeric', 'gt:0'],
        ];
    }
}

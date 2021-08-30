<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * リスト 9.3.2.4
 *
 * このファイルの生成コマンド
 * $ php artisan make:request AddPointRequest
 */
class AddPointRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'customer_id' => 'required|int',
            'add_point' => 'required|int',
        ];
    }
}

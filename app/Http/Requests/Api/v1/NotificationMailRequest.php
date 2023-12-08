<?php

namespace App\Http\Requests\Api\v1;

use App\Models\ApiKey;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class NotificationMailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $authorization = $this->header('Authorization');

        // APIキーがヘッダに存在しない場合はfalseを返す
        if (!is_string($authorization)) {
            return false;
        }

        // APIキーが保存されているハッシュと一致するかを確認する
        return ApiKey::all()->contains(function (ApiKey $apiKey) use ($authorization): bool {
            return Hash::check($authorization, $apiKey->api_key);
        });
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<string, string>|string>
     */
    public function rules(): array
    {
        return [
            'to' => 'required|email',
            'body' => 'required|string',
        ];
    }
}

<?php

namespace App\Http\Requests\Central;

use Illuminate\Foundation\Http\FormRequest;

class DomainRequest extends FormRequest
{
    protected $errorBag = 'domainCreated';

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return !$this->user()->domains()->exists();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $extension = str_replace('.', '\\.', config('app.default_domain_extension'));
        return [
            'domain' => [
                'required',
                'string',
                'lowercase:',
                "regex:/^[A-Za-z0-9-]+{$extension}$/",
                'unique:domains,domain'
            ]
        ];
    }

    public function messages()
    {
        return [
            'domain.unique' => 'Domain is not available. Try another one',
            'domain.regex' => "Invalid format, enter the name without the extension. example: mybrand instad of mybrand" . config('app.default_domain_extension')
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'domain' => $this->formatToDomain($this->get('domain'))
        ]);
    }

    private function formatToDomain($domain): string
    {
        return $domain . config('app.default_domain_extension');
    }
}

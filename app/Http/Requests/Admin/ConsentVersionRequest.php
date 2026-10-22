<?php

namespace App\Http\Requests\Admin;

use App\Enums\ConsentStatus;
use App\Services\ResearchReadinessService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class ConsentVersionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() === true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'version' => [
                'required',
                'string',
                'max:50',
                Rule::unique('consent_versions', 'version')->ignore($this->route('consent')?->getKey()),
            ],
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string', 'max:50000'],
            'status' => [
                'required',
                Rule::in(ConsentStatus::values()),
            ],
            'effective_from' => ['nullable', 'date'],
        ];
    }

    /**
     * @return array<int, callable>
     */
    public function after(): array
    {
        return [
            function (Validator $validator): void {
                $status = ConsentStatus::tryFrom((string) $this->input('status'));

                if (! $status?->requiresCompleteText()) {
                    return;
                }

                if (app(ResearchReadinessService::class)->hasUnresolvedConsentPlaceholders((string) $this->input('body'))) {
                    $validator->errors()->add(
                        'body',
                        'Teks persetujuan masih memuat placeholder dan belum dapat masuk ke tahap ini.'
                    );
                }
            },
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'version.unique' => 'Versi teks persetujuan sudah ada.',
            'status.in' => 'Status persetujuan tidak valid.',
        ];
    }
}

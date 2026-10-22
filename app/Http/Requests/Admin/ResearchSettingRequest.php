<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ResearchSettingRequest extends FormRequest
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
            'research_title' => ['required', 'string', 'max:255'],
            'researcher_name' => ['nullable', 'string', 'max:255'],
            'institution' => ['nullable', 'string', 'max:255'],
            'contact_email' => ['nullable', 'string', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:30'],
            'genz_birth_year_start' => [
                'nullable',
                'integer',
                'between:1900,2100',
                'required_with:genz_birth_year_end',
            ],
            'genz_birth_year_end' => [
                'nullable',
                'integer',
                'between:1900,2100',
                'required_with:genz_birth_year_start',
                'gte:genz_birth_year_start',
            ],
            'minimum_age' => ['required', 'integer', 'min:18', 'max:120'],
            'region_definition' => ['nullable', 'string', 'max:2000'],
            'study_start_date' => ['nullable', 'date'],
            'study_end_date' => ['nullable', 'date', 'after_or_equal:study_start_date'],
            'age_verification_method' => [
                'nullable',
                Rule::in(['date_of_birth', 'age_years', 'birth_year_plus_age_confirmation']),
            ],
            'access_mode' => [
                'nullable',
                Rule::in(['participant_link', 'access_code', 'restricted_group']),
            ],
            'access_code' => ['nullable', 'string', 'min:6', 'max:100'],
            'remove_access_code' => ['nullable', 'boolean'],
            'ethics_confirmation_status' => [
                'nullable',
                Rule::in(['pending', 'confirmed', 'not_required']),
            ],
            'ethics_reference' => ['nullable', 'string', 'max:255'],
            'retention_months' => ['nullable', 'integer', 'min:1', 'max:600'],
            'deletion_procedure' => ['nullable', 'string', 'max:5000'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'research_title.required' => 'Judul penelitian wajib diisi.',
            'minimum_age.min' => 'Usia minimum tidak boleh kurang dari 18 tahun.',
            'access_mode.in' => 'Mode akses harus dibatasi untuk peserta penelitian, bukan publik.',
            'genz_birth_year_end.gte' => 'Tahun akhir harus sama atau lebih besar dari tahun awal.',
        ];
    }
}

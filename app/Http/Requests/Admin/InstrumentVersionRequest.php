<?php

namespace App\Http\Requests\Admin;

use App\Enums\InstrumentStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class InstrumentVersionRequest extends FormRequest
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
            'code' => ['required', 'string', 'max:50', Rule::in(['dass21'])],
            'version' => [
                'required',
                'string',
                'max:50',
                Rule::unique('instrument_versions', 'version')
                    ->where(fn ($query) => $query->where('code', $this->input('code')))
                    ->ignore($this->route('instrument')?->getKey()),
            ],
            'locale' => ['required', 'string', 'max:10'],
            'status' => [
                'required',
                Rule::in([
                    InstrumentStatus::Draft->value,
                    InstrumentStatus::PendingVerification->value,
                    InstrumentStatus::Verified->value,
                ]),
            ],
            'source_reference' => ['nullable', 'string', 'max:255', 'required_if:status,verified'],
            'source_url' => ['nullable', 'url', 'max:2048', 'required_if:status,verified'],
            'source_retrieved_at' => ['nullable', 'date', 'required_if:status,verified'],
            'translator' => ['nullable', 'string', 'max:255', 'required_if:status,verified'],
            'copyright_status' => ['nullable', 'string', 'max:100', 'required_if:status,verified'],
            'verification_notes' => ['nullable', 'string', 'max:5000'],
            'instructions' => ['nullable', 'string', 'max:5000'],
            'item_texts_raw' => ['nullable', 'string', 'max:30000'],
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
                if ($this->input('status') !== InstrumentStatus::Verified->value) {
                    return;
                }

                $lines = $this->itemTextLines();

                if (count($lines) !== (int) config('dass21.item_count', 21)) {
                    $validator->errors()->add(
                        'item_texts_raw',
                        'Status terverifikasi membutuhkan tepat 21 baris teks butir, satu butir per baris.',
                    );
                }
            },
        ];
    }

    /**
     * @return array<int, string>
     */
    public function itemTextLines(): array
    {
        $raw = (string) $this->input('item_texts_raw', '');

        if (trim($raw) === '') {
            return [];
        }

        $lines = preg_split('/\r\n|\r|\n/', trim($raw)) ?: [];

        return array_values(array_filter(
            array_map(static fn (string $line): string => trim($line), $lines),
            static fn (string $line): bool => $line !== '',
        ));
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'version.unique' => 'Versi instrumen dengan kode tersebut sudah ada.',
            'status.in' => 'Status aktif hanya dapat dicapai melalui tombol aktivasi.',
            'source_reference.required_if' => 'Referensi sumber wajib diisi untuk status terverifikasi.',
            'source_url.required_if' => 'URL sumber wajib diisi untuk status terverifikasi.',
            'source_retrieved_at.required_if' => 'Tanggal pengambilan sumber wajib diisi untuk status terverifikasi.',
            'translator.required_if' => 'Nama penerjemah wajib diisi untuk status terverifikasi.',
            'copyright_status.required_if' => 'Status penggunaan wajib diisi untuk status terverifikasi.',
            'item_texts_raw.max' => 'Teks butir terlalu panjang.',
        ];
    }
}

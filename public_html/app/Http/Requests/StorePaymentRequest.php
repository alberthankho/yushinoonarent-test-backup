<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; // <-- Import Rule for 'in' validation

class StorePaymentRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'name' => ['required', 'string','max:255'],
            'phone_number'=> ['required','string','max:255'],
            // 'proof'=> ['required','image','mimes:png,jpg,jpeg'],

            // --- New Tenant Fields ---
            'nik' => ['required', 'string', 'size:16'],
            'email' => ['required', 'email', 'max:255'],
            'tenants_address_ktp' => ['required', 'string', 'max:65535'],
            'tenants_address_domicile' => ['nullable', 'string', 'max:65535'],
            'event_rent_session' => ['nullable', 'string', 'max:255'],
            'twitter' => ['nullable', 'string', 'max:255'],
            'instagram' => ['required', 'string', 'max:255'],

            // --- New Identification Fields ---
            'first_identification_type' => ['required', 'string', Rule::in(['KTP'])],
            'second_identification_type' => ['required', 'string', Rule::in(['SIM', 'Paspor', 'Kartu Pelajar/Mahasiswa/NPWP', 'STNK/BPKB', 'Others'])],
            'second_identification_value' => ['required_if:second_identification_type,Others', 'nullable', 'string', 'max:255'], // Required only if "Others" is selected

            // --- New Guarantor Fields ---
            'guarantor_name' => ['required', 'string', 'max:255'],
            'relationship_with_guarantor' => ['required', 'string', 'max:255'],
            'guarantor_phone' => ['required', 'string', 'max:255'],

            // --- New Image Upload Fields (with validation for multiple files) ---
            'ticket_screenshot' => ['required', 'array', 'max:2'],
            'ticket_screenshot.*' => ['image', 'mimes:png,jpg,jpeg'], // Validate each file in the array
            
            'user_identification' => ['required', 'array', 'size:2'], // Use 'size:2' to enforce exactly two files
            'has_materai' => ['nullable', 'boolean'],

        ];
    }
}

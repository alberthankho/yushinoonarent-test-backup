<?php

namespace App\Http\Requests;

use App\Models\Store;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class StoreBookingRequest extends FormRequest
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
        // 🚨 Get the already bound Product model instance from the route
        $productModel = $this->route('product'); 
    
        // Safety check (already proven to work by dd, but good practice)
        if (!$productModel) {
            // This should never be hit since the route binding worked.
            return []; 
        }
        
        $stock = $productModel->stock;
        return [
            //
            'duration' => ['required','integer', 'min:1'],
            'delivery_type' => ['required', 'string'], // Good to validate this too
        
            'store_id' => [
                'required',
                'integer',
                
                // ✅ Rule 1: Validate store_id exists in the pivot table and is linked to the current product
                Rule::exists('product_store', 'store_id')->where(function ($query) use ($productModel) {
                    return $query->where('product_id', $productModel->id);
                }),
                
                // ✅ Rule 2: Custom Stock/Availability Check
                function ($attribute, $value, $fail) use ($productModel, $stock) {
                    $startDate = $this->input('started_at');
    
                    // Count confirmed bookings for THIS PRODUCT (regardless of event)
                    $bookingsOnDate = Transaction::where('product_id', $productModel->id)
                        ->where('is_dp_paid', true)
                        ->whereDate('started_at', '<=', $startDate)
                        ->whereDate('ended_at', '>=', $startDate)
                        ->count();
    
                    // If the number of existing bookings is >= product stock, fail.
                    if ($bookingsOnDate >= $stock) {
                        $fail('Sorry, this product is fully booked for the date range encompassing ' . $startDate . '.');
                    }
                    

                },
            ],
            'started_at'=> ['required','date', 'after:today'],
            // 'address'=> ['required','string'],
        ];
    }
}

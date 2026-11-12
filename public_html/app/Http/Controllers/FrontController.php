<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\StorePaymentRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use App\Models\Transaction;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AdminNewBookingNotification;
use Carbon\CarbonPeriod;


class FrontController extends Controller
{
    //
    public function index(){
        $categories = Category::all();
        $latest_product = Product::latest()->take(4)->get();
        $random_product = Product::inRandomOrder()->take(6)->get();
        return view("front.index", compact("categories", "latest_product", "random_product"));
    }

    public function category(Category $category){
        session()->put("category_id", $category->id);
        return view("front.brands", compact("category"));
    }

    public function brand(Brand $brand){
        $category_id = session()->get("category_id");
        
        $category = Category::find($category_id);

        $products = Product::where("brand_id", $brand->id)
        ->where("category_id", $category_id)
        ->latest()
        ->get();

        return view("front.gadgets", compact("brand","products", "category"));
    }

    public function details(Product $product){
        return view("front.details", compact("product"));
    }

    // public function booking(Product $product)
    // {
    //     $storesQuery = Store::where('product_id', '>=', $product->id)
    //                 ->get();
    //     $stores = $storesQuery->sortBy([
    //         // ['is_open', 'asc'], 
    //         ['event_date', 'asc']
    //     ]);
    
    //     // --- START: New Logic for Disabling Dates Based on Stock ---
    
    //     // 1. Set the minimum selectable date to tomorrow (H+1)
    //     $minDate = Carbon::tomorrow()->format('Y-m-d');
        
    //     // 2. Get the available stock for the current product
    //     $stock = $product->stock;
        
    //     // 3. Find all transactions for this product where the Down Payment is paid
    //     $bookedTransactions = Transaction::where('product_id', $product->id)
    //         ->where('is_dp_paid', true) // <-- Changed from is_paid to is_dp_paid
    //         ->get(['started_at', 'ended_at']); // Only get the columns we need
    
    //     // 4. Count how many bookings exist for each single day
    //     $bookingsPerDay = [];
    //     foreach ($bookedTransactions as $transaction) {
    //         // Create a date range for each booking (e.g., July 5th to July 7th)
    //         $period = CarbonPeriod::create($transaction->started_at, $transaction->ended_at);
    
    //         // For each day in that range, increment its booking count
    //         foreach ($period as $date) {
    //             $dateString = $date->format('Y-m-d');
    //             if (!isset($bookingsPerDay[$dateString])) {
    //                 $bookingsPerDay[$dateString] = 0;
    //             }
    //             $bookingsPerDay[$dateString]++;
    //         }
    //     }
    
    //     // 5. Create the final array of dates to disable
    //     $disabledDates = [];
    //     foreach ($bookingsPerDay as $date => $count) {
    //         // If the number of bookings for a day is >= the available stock, disable it
    //         if ($count >= $stock) {
    //             $disabledDates[] = $date;
    //         }
    //     }
    //     // --- END: New Logic ---
    
    //     // Return the view with the new, correctly calculated disabledDates
    //     return view('front.booking', compact('product', 'stores', 'minDate', 'disabledDates'));
    // }
    
    public function booking(Product $product)
    {
        // --- Start: New Logic to get Stores with Pivot Data ---
        $storesQuery = Store::query()
            // Filter Stores that have the current $product attached
            // AND check the pivot table for the product's status/availability
            ->whereHas('products', function ($query) use ($product) {
                $query->where('product_id', $product->id);
            })
            // Load the relationship and explicitly select all required pivot columns
            ->with(['products' => function ($query) use ($product) {
                $query->where('product_id', $product->id)
                      ->withPivot('price', 'description', 'is_open'); // ✅ NEW: Get pivot fields
            }])
            ->get();
    
        // The sorting logic remains valid, assuming event_date is still an accessor
        $stores = $storesQuery->sortBy([
            ['event_date', 'asc']
        ]);
        // --- End: New Logic ---
    
        // --- Stock Logic (Remains mostly the same, as it deals with Transactions) ---
    
        // 1. Set the minimum selectable date to tomorrow (H+1)
        $minDate = Carbon::tomorrow()->format('Y-m-d');
    
        // 2. Get the available stock for the current product
        $stock = $product->stock;
    
        // 3. Find all transactions for this product where the Down Payment is paid
        $bookedTransactions = Transaction::where('product_id', $product->id)
            ->where('is_dp_paid', true)
            ->get(['started_at', 'ended_at']);
    
        // 4. Count how many bookings exist for each single day
        $bookingsPerDay = [];
        foreach ($bookedTransactions as $transaction) {
            $period = CarbonPeriod::create($transaction->started_at, $transaction->ended_at);
            foreach ($period as $date) {
                $dateString = $date->format('Y-m-d');
                $bookingsPerDay[$dateString] = ($bookingsPerDay[$dateString] ?? 0) + 1;
            }
        }
    
        // 5. Create the final array of dates to disable
        $disabledDates = [];
        foreach ($bookingsPerDay as $date => $count) {
            if ($count >= $stock) {
                $disabledDates[] = $date;
            }
        }
    
        return view('front.booking', compact('product', 'stores', 'minDate', 'disabledDates'));
    }

    public function booking_save(StoreBookingRequest $request, Product $product){
        session()->put('product_id', $product->id);
        // $bookingData = $request->only(['duration', 'started_at', 'store_id', 'delivery_type', 'address']);
        $bookingData = $request->validated(); // Use validated() to get only what's in your rules() method


        // $bookingData['store_id'] = 1; // Set store_id to 1 by default
        // $bookingData['address'] = 'Pickup at Store'; // Set a default placeholder address
        // $bookingData['delivery_type'] = $request->input('delivery_type', 'pickup');

        session($bookingData);

        return redirect()->route('front.checkout', $product->slug);
    }

    public function checkout(Product $product){
        $duration = session('duration');
        $store_id = session('store_id');
        
        if (!$store_id) {
            // Handle case where store_id is missing (e.g., redirect back with error)
            return redirect()->route('front.booking', $product->slug)
                             ->withErrors(['store_id' => 'Please select an event.']);
        }
        
        $store = Store::find($store_id);
        if (!$store) {
             return redirect()->route('front.booking', $product->slug)
                              ->withErrors(['store_id' => 'Invalid event selected.']);
        }
    
        // 2. Get the specific pivot data
        $pivot = $store->products()->where('product_id', $product->id)
                       ->withPivot('price', 'description','custom_dp_amount')
                       ->first()->pivot;
    
        if (!$pivot) {
            return redirect()->back()->withErrors(['error' => 'Product is not priced for this event.']);
        }
        
        // 3. Apply Discount Logic (reusing the logic from the booking page)
        $basePrice = $pivot->price;
        $description = strtolower(trim($pivot->description));
    
        if (str_starts_with($description, 'diskon - ')) {
            $discountPrice = 0;
            sscanf($description, 'diskon - %d', $discountPrice);
            $basePrice = $discountPrice > 0 ? $discountPrice : $basePrice;
        }
        
        $default_dp = 200000;
        
        if ($store->is_special && !empty($pivot->custom_dp_amount)) {
            $dp_per_day = $pivot->custom_dp_amount;
        } else {
            $dp_per_day = $default_dp;
        }
    
        $insurance = $dp_per_day * $duration;
        $price = $basePrice;

        $subTotal = $price * $duration;
        $grandTotal = $subTotal + $insurance;

        return view('front.checkout', compact('product','insurance','subTotal','grandTotal'));
    }

    public function checkout_store(StorePaymentRequest $request){
        $bookingData = session()->only(['duration','started_at','store_id','delivery_type','address','product_id']);
        
        $duration = (int) $bookingData['duration'];
        $startedDate = Carbon::parse($bookingData['started_at']);

        $productDetails = Product::find($bookingData['product_id']);
        if(!$productDetails){
            return redirect()->back()->withErrors(['product_id' => 'Product not found.']);
        }
        
        $storeDetails = Store::find($bookingData['store_id']);
        if (!$storeDetails) {
            return redirect()->back()->withErrors(['store_id' => 'Store or event not found.']);
        }
        
        $pivot = $storeDetails->products()
                          ->where('product_id', $productDetails->id)
                          ->withPivot('price', 'description', 'custom_dp_amount')
                          ->first()->pivot;
    
        if (!$pivot) {
            return redirect()->back()->withErrors(['error' => 'Product price missing for this event.']);
        }
        
        $hasMaterai = $request->boolean('has_materai');

        $price = $pivot->price;
        $description = strtolower(trim($storeDetails->description));
    
        if (str_starts_with($description, 'diskon - ')) {
            $discountPrice = 0;
            sscanf($description, 'diskon - %d', $discountPrice);
            
            if ($discountPrice > 0) {
                $price = $discountPrice;
            }
        }
        
        $default_dp = 200000;
        
        if ($storeDetails->is_special && !empty($pivot->custom_dp_amount)) {
            $dp_per_day = $pivot->custom_dp_amount;
        } else {
            $dp_per_day = $default_dp;
        }
    
        $dp_amount = $dp_per_day * $duration;
        $materai_amount = $hasMaterai ? 0 : 11000;

        $total_amount = ($price * $duration) + 11000;
        $unpaid_amount = $total_amount - ($dp_amount + $materai_amount);
        
        $bookingTransactionId = null;
        
        $paymentAmount = $dp_amount + $materai_amount;

        $transaction = DB::transaction(function() use ($request, $bookingData, $total_amount, $dp_amount, $materai_amount, $unpaid_amount, $duration, $productDetails, $startedDate) {
        
            $validated = $request->validated();
    
            // Buat record transaksi baru dengan semua data yang divalidasi dan dihitung
            $newBooking = Transaction::create(array_merge($validated, [
                'duration' => $duration,
                'started_at' => $startedDate,
                'ended_at' => $startedDate->copy()->addDays($duration - 1),
                'store_id' => $bookingData['store_id'],
                'product_id' => $productDetails->id,
                'delivery_type' => $bookingData['delivery_type'],
                'address' => $bookingData['address'] ?? 'Pickup at store',
                'is_paid' => false,
                'is_dp_paid' => false, // Status awal adalah belum bayar DP
                'trx_id' => Transaction::generateUniqueTrxId(),
                'total_amount' => $total_amount,
                'dp_amount' => $dp_amount,
                'materai_amount' => $materai_amount,
                'unpaid_amount' => $unpaid_amount,
            ]));
    
            // Logika upload file Anda tetap di sini (kecuali untuk 'proof' manual)
            if ($request->hasFile('ticket_screenshot')) {
                foreach ($request->file('ticket_screenshot') as $file) {
                    $path = $file->store('transaction-images/ticket-screenshots', 'public');
                    $newBooking->ticketScreenshots()->create(['image_path' => $path]);
                }
            }
            if ($request->hasFile('user_identification')) {
                foreach ($request->file('user_identification') as $file) {
                    $path = $file->store('transaction-images/user-identifications', 'public');
                    $newBooking->userIdentifications()->create(['image_path' => $path]);
                }
            }
    
            return $newBooking;
        });


        $params = [
            'payment_type' => 'qris',
            'transaction_details' => [
                'order_id' => $transaction->trx_id,
                'gross_amount' => $paymentAmount,
            ],
            'customer_details' => [
                'first_name' => $transaction->name,
                'email' => $transaction->email,
                'phone' => $transaction->phone_number,
            ],
            'qris' => [
                'acquirer' => 'gopay'
            ]
        ];

        try {
            $midtransResponse = \Midtrans\CoreApi::charge($params);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Payment gateway error: ' . $e->getMessage()]);
        }

        session()->forget(['duration', 'started_at', 'store_id', 'delivery_type', 'address', 'product_id']);
    
        return view('front.payment-qris', [
            'transaction' => $transaction,
            'midtransResponse' => $midtransResponse
        ]);
    }
    
    // public function checkout_store(StorePaymentRequest $request){
    //     $bookingData = session()->only(['duration','started_at','store_id','delivery_type','address','product_id']);
        
    //     $duration = (int) $bookingData['duration'];
    //     $startedDate = Carbon::parse($bookingData['started_at']);

    //     $productDetails = Product::find($bookingData['product_id']);
    //     if(!$productDetails){
    //         return redirect()->back()->withErrors(['product_id' => 'Product not found.']);
    //     }
        
    //     $storeDetails = Store::find($bookingData['store_id']);
    //     if (!$storeDetails) {
    //         return redirect()->back()->withErrors(['store_id' => 'Store or event not found.']);
    //     }
        
    //     $hasMaterai = $request->boolean('has_materai');

    //     $price = $storeDetails->price;
    //     $description = strtolower(trim($storeDetails->description));
    
    //     if (str_starts_with($description, 'diskon - ')) {
    //         $discountPrice = 0;
    //         sscanf($description, 'diskon - %d', $discountPrice);
            
    //         if ($discountPrice > 0) {
    //             $price = $discountPrice;
    //         }
    //     }
    //     $dp_amount = 200000 * $duration;
    //     $materai_amount = $hasMaterai ? 0 : 11000;

    //     $total_amount = $price * $duration;
    //     $unpaid_amount = $total_amount - ($dp_amount + $materai_amount);
        
    //     $bookingTransactionId = null;

    //     DB::transaction(function() use ($request, &$bookingTransactionId, $duration, $bookingData, $total_amount, $dp_amount, $materai_amount, $unpaid_amount, $productDetails, $startedDate){
    //         $validated = $request->validated();

    //         if($request->hasFile('proof')){
    //             $proofPath = $request->file('proof')->store('proofs', 'public');
    //             $validated['proof'] = $proofPath;
    //         }

    //         $endedDate = $startedDate->copy()->addDays($duration - 1);

    //         $validated['started_at'] = $startedDate;
    //         $validated['ended_at'] = $endedDate;
    //         $validated['duration'] = $duration;
    //         $validated['total_amount'] = $total_amount;
    //         $validated['store_id'] = $bookingData['store_id'];
    //         $validated['product_id'] = $productDetails->id;
    //         $validated['delivery_type'] = $bookingData['delivery_type'];
    //         $validated['address'] = $bookingData['address'] ?? 'Pickup at store';
    //         $validated['is_paid'] = false;
    //         $validated['trx_id'] = Transaction::generateUniqueTrxId();
    //         $validated['dp_amount'] = $dp_amount;
    //         $validated['materai_amount'] = $materai_amount;
    //         $validated['unpaid_amount'] = $unpaid_amount;

    //         $newBooking = Transaction::create($validated);

    //         // --- START: Send Notification to Admin ---
    //         try {
    //             $adminRecipients = [
    //                 'yushinoonarent@gmail.com',
    //                 'aprilianiputri3@gmail.com',
    //             ];
    //             Notification::route('mail', $adminRecipients) 
    //                         ->notify(new AdminNewBookingNotification($newBooking));
    //         } catch (\Exception $e) {
    //             // Optional: Log the error if the email fails to send,
    //             // but don't stop the user's successful booking process.
    //             \Log::error('Email notification failed to send: ' . $e->getMessage());
    //         }
    //         // --- END: Send Notification to Admin ---

    //         // --- Handle Related Image Uploads ---
    //         // Note: We do this AFTER the main transaction is created, so we have its ID.

    //         // 1. Handle Ticket Screenshots
    //         if ($request->hasFile('ticket_screenshot')) {
    //             foreach ($request->file('ticket_screenshot') as $file) {
    //                 $path = $file->store('transaction-images/ticket-screenshots', 'public');
    //                 $newBooking->ticketScreenshots()->create(['image_path' => $path]);
    //             }
    //         }
            
    //         if ($request->hasFile('user_identification')) {
    //             foreach ($request->file('user_identification') as $file) {
    //                 $path = $file->store('transaction-images/user-identifications', 'public');
    //                 $newBooking->userIdentifications()->create(['image_path' => $path]);
    //             }
    //         }

    //         $bookingTransactionId = $newBooking->id;

    //     });

    //     return redirect()->route('front.success.booking', $bookingTransactionId); 
    // }

    public function success_booking(Transaction $transaction){
        return view('front.success_booking', compact('transaction'));
    }

    public function transactions(){
        return view('front.transactions');
    }

    public function transactions_details(Request $request){
        $request->validate([
            'trx_id' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:255'],
        ]);

        $trx_id = $request->input('trx_id');
        $phone_number = $request->input('phone_number');

        $details = Transaction::with(['store', 'product'])
        ->where('trx_id', $trx_id)
        ->where('phone_number', $phone_number)
        ->first();

        if(!$details){
            return redirect()->back()->withErrors(['error' => 'Transactions not found.']);
        }

       // Pull calculations directly from the recorded database transaction snapshot
        $insurance = $details->dp_amount;
        $materai = $details->materai_amount;
        $grandTotal = $details->total_amount;
        $unpaidAmount = $details->unpaid_amount; // <-- Fetch the remaining balance
    
        // Base subtotal calculation matching checkout_store logic
        $subTotal = $grandTotal - 11000;
    
        return view('front.transactions_details', compact([
            'details', 
            'insurance', 
            'materai', 
            'subTotal', 
            'grandTotal',
            'unpaidAmount' // <-- Send to view
        ]));
    }
    
    public function contact()
    {
        return view('front.contact');
    }
    
    public function paymentStatus(Transaction $transaction)
    {
        // Periksa status transaksi di database Anda.
        // Webhook dari Midtrans akan mengupdate ini di latar belakang.
        if ($transaction->is_dp_paid) {
            return response()->json(['status' => 'paid']);
        }
    
        return response()->json(['status' => 'pending']);
    }
    
    public function notificationHandler(Request $request)
    {
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        $notif = new \Midtrans\Notification();
        
        $transactionStatus = $notif->transaction_status;
        $orderId = $notif->order_id;
        
        $transaction = Transaction::where('trx_id', $orderId)->first();
    
        if ($transaction) {
            if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
                if ($transaction->is_dp_paid == false) {
                    $transaction->is_dp_paid = true;
                    $transaction->save();
    
                    try {
                        $adminRecipients = [
                            'yushinoonarent@gmail.com',
                            'aprilianiputri3@gmail.com',
                        ];
                        Notification::route('mail', $adminRecipients) 
                                    ->notify(new AdminNewBookingNotification($transaction));
                    } catch (\Exception $e) {
                        \Log::error('Email notification failed for trx_id ' . $transaction->trx_id . ': ' . $e->getMessage());
                    }
                }
            }
        }
    }
}

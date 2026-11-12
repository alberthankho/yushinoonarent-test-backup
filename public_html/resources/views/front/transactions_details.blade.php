<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="{{asset('output.css')}}" rel="stylesheet" />
        <link href="{{asset('main.css')}}" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
    </head>
<body>
    <main class="max-w-[640px] mx-auto min-h-screen flex flex-col relative has-[#Bottom-nav]:pb-[144px]">
        <div id="Top-navbar" class="flex items-center justify-between px-5 pt-5">
            <a href="{{url()->previous()}}">
                <div class="size-[44px] flex shrink-0">
                    <img src="{{asset('assets/images/icons/arrow-left.svg')}}" alt="icon" />
                </div>
            </a>
            <p class="text-lg leading-[27px] font-semibold">Booking Details</p>
            <button class="size-[44px] flex shrink-0">
                <img src="{{asset('assets/images/icons/more.svg')}}" alt="icon" />
            </button>
        </div>
        <section class="flex flex-col gap-[30px] mt-[30px] px-5">
            <div class="flex items-center rounded-2xl border border-[#E9E8ED] gap-2 p-4">
                <div class="w-[60px] h-[60px] flex shrink-0">
                    <img src="{{asset('assets/images/icons/crown-circle.svg')}}" alt="icon">
                </div>
                <div class="flex flex-col">
                    <p class="font-semibold">{{$details->trx_id}}</p>
                    <p class="text-sm leading-[21px] text-[#6E6E70]">Protect your booking ID</p>
                </div>
            </div>
            <hr class="border-[#EDEEF0]">
            @if($details->is_dp_paid)
            <div id="Payment-success" class="flex items-center rounded-2xl p-[14px_16px] gap-4 bg-black text-white">
                <div class="w-6 h-6 flex shrink-0">
                    <img src="{{asset('assets/images/icons/note-white.svg')}}" alt="icon">
                </div>
                <div class="flex flex-col gap-1">
                    <div class="flex items-center gap-1">
                        <p class="font-semibold text-sm leading-[21px]">Payment Success</p>
                        <div class="w-5 h-5 flex shrink-0">
                            <img src="{{asset('assets/images/icons/verify.svg')}}" alt="icon">
                        </div>
                    </div>
                    <p class="text-xs leading-[18px]">Pembayaran Anda sudah kami terima dan silahkan menunggu instruksi selanjutnya</p>
                </div>
            </div>
            @else
            <div id="Payment-pending" class="flex items-center rounded-2xl p-[14px_16px] gap-4 bg-[#FCCF2F]">
                <div class="w-6 h-6 flex shrink-0">
                    <img src="{{asset('assets/images/icons/note-black.svg')}}" alt="icon">
                </div>
                <div class="flex flex-col gap-1">
                    <div class="flex items-center gap-1">
                        <p class="font-semibold text-sm leading-[21px]">Payment Pending</p>
                    </div>
                    <p class="text-xs leading-[18px]">Tim kami sedang memeriksa transaksi ada pada booking berikut</p>
                </div>
            </div>
            @endif
            
            <hr class="border-[#EDEEF0]">
            <div class="flex items-center gap-[14px]">
                <div class="w-20 h-20 flex shrink-0 rounded-2xl overflow-hidden bg-[#F6F6F6] items-center">
                    <div class="w-full h-[50px] flex shrink-0 justify-center">
                        <img src="{{Storage::url($details->product->thumbnail)}}" class="h-full w-full object-contain" alt="thumbnail">
                    </div>
                </div>
                <div class="w-full flex flex-col gap-2">
                    <p class="font-bold text-lg leading-[27px]">{{$details->product->name}}</p>
                    <div class="flex items-center gap-[14px]">
                        <div class="flex items-center w-fit gap-1">
                            <p class="font-semibold text-sm leading-[21px] text-[#6E6E70]">Original 100%</p>
                            <div class="w-5 h-5 flex shrink-0">
                                <img src="{{asset('assets/images/icons/verify.svg')}}" alt="verify">
                            </div>
                        </div>
                        <div class="flex items-center w-fit gap-1">
                            <p class="font-semibold text-sm leading-[21px] text-[#6E6E70]">Insurance</p>
                            <div class="w-5 h-5 flex shrink-0">
                                <img src="{{asset('assets/images/icons/verify.svg')}}" alt="verify">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <section class="flex flex-col gap-5">
                <div class="info-card flex flex-col gap-2">
                    <p class="font-semibold">Full Name (Wajib Sesuai KTP)</p>
                    <div class="flex items-center rounded-2xl p-[18px_14px] gap-3 bg-[#F4F4F6]">
                        <div class="w-6 h-6 flex shrink-0">
                            <img src="{{asset('assets/images/icons/user.svg')}}" alt="icon">
                        </div>
                        <div class="flex flex-col gap-1">
                            <p class="font-semibold">{{$details->name}}</p>
                        </div>
                    </div>
                </div>
                <div class="info-card flex flex-col gap-2">
                    <p class="font-semibold">Phone Number</p>
                    <div class="flex items-center rounded-2xl p-[18px_14px] gap-3 bg-[#F4F4F6]">
                        <div class="w-6 h-6 flex shrink-0">
                            <img src="{{asset('assets/images/icons/call.svg')}}" alt="icon">
                        </div>
                        <div class="flex flex-col gap-1">
                            <p class="font-semibold">{{$details->phone_number}}</p>
                        </div>
                    </div>
                </div>
                <div class="info-card flex flex-col gap-2">
                    <p class="font-semibold">Started At</p>
                    <div class="flex items-center rounded-2xl p-[18px_14px] gap-3 bg-[#F4F4F6]">
                        <div class="w-6 h-6 flex shrink-0">
                            <img src="{{asset('assets/images/icons/calendar.svg')}}" alt="icon">
                        </div>
                        <div class="flex flex-col gap-1">
                            <p class="font-semibold">{{$details->started_at->format('M d, Y')}}</p>
                        </div>
                    </div>
                </div>
                <div class="info-card flex flex-col gap-2">
                    <p class="font-semibold">Ended At</p>
                    <div class="flex items-center rounded-2xl p-[18px_14px] gap-3 bg-[#F4F4F6]">
                        <div class="w-6 h-6 flex shrink-0">
                            <img src="{{asset('assets/images/icons/calendar.svg')}}" alt="icon">
                        </div>
                        <div class="flex flex-col gap-1">
                            <p class="font-semibold">{{$details->ended_at->format('M d, Y')}}</p>
                        </div>
                    </div>
                </div>
                <div class="info-card flex flex-col gap-2">
                     <p class="font-semibold">Pick Up</p>
                    <div class="flex items-center rounded-2xl p-[18px_14px] gap-3 bg-[#F4F4F6]">
                        <div class="w-6 h-6 flex shrink-0">
                            <img src="{{asset('assets/images/icons/buildings.svg')}}" alt="icon">
                        </div>
                        <div class="flex flex-col gap-1">
                            <p class="font-semibold">Pickup At Venue</p>
                            <p class="text-sm leading-[21px] text-[#6E6E70]">Pickup address detail via WhatsApp</p>
                        </div>
                    </div>
                </div>
                {{-- @if($details->delivery_type == 'pickup')
                    <p class="font-semibold">Pick Up At</p>
                    <div class="flex items-center rounded-2xl p-[18px_14px] gap-3 bg-[#F4F4F6]">
                        <div class="w-6 h-6 flex shrink-0">
                            <img src="{{asset('assets/images/icons/buildings.svg')}}" alt="icon">
                        </div>
                        <div class="flex flex-col gap-1">
                            <p class="font-semibold">{{$details->store->name}}</p>
                            <p class="text-sm leading-[21px] text-[#6E6E70]">{{$details->store->address}}</p>
                        </div>
                    </div>
                </div>
                @else
                <div class="info-card flex flex-col gap-2">
                    <p class="font-semibold">Home Deliver to</p>
                    <div class="flex items-center rounded-2xl p-[18px_14px] gap-3 bg-[#F4F4F6]">
                        <div class="w-6 h-6 flex shrink-0">
                            <img src="{{asset('assets/images/icons/house-2.svg')}}" alt="icon">
                        </div>
                        <div class="flex flex-col gap-1">
                            <p class="font-semibold">{{$details->address}}</p>
                        </div>
                    </div>
                </div>
                @endif --}}
            </section>
            <hr class="border-[#EDEEF0]">
            <div id="Payment-details" class="flex flex-col gap-3">
                <h2 class="font-semibold text-lg leading-[27px]">Payment Details</h2>
                <div class="flex flex-col gap-4">
                    
                    {{-- Base Rental Subtotal --}}
                    <div class="flex items-center justify-between text-sm text-gray-600">
                        <p>Harga Sewa ({{ $details->duration }} Hari)</p>
                        <p class="font-medium text-brand-dark">Rp {{ number_format($subTotal, 0, ',', '.') }}</p>
                    </div>
            
                    {{-- Materai Fee line --}}
                    <div class="flex items-center justify-between text-sm text-gray-600">
                        <p>Biaya Administrasi (Materai)</p>
                        <p class="font-medium text-brand-dark">Rp 11.000</p>
                    </div>
                    
                    <hr class="border-[#EDEEF0] my-1">
                    
                    {{-- Total Invoice Cost --}}
                    <div class="flex items-center justify-between pt-3 mt-2">
                        <p class="font-medium">Total Biaya Keseluruhan</p>
                        <p class="font-bold text-lg text-brand-dark">Rp {{ number_format($grandTotal, 0, ',', '.') }}</p>
                    </div>
            
                    <hr class="border-[#EDEEF0] my-1">
            
                    {{-- Paid DP Segment --}}
                    <div class="flex items-center justify-between text-sm text-gray-600">
                        <div class="flex items-center gap-2">
                            <p>Down Payment (DP Terbayar)</p>
                            @if($details->is_dp_paid)
                                <span class="text-[10px] bg-green-100 text-green-700 font-bold px-2 py-0.5 rounded-full">LUNAS</span>
                            @endif
                        </div>
                        <p class="font-semibold text-green-600">- Rp {{ number_format($insurance, 0, ',', '.') }}</p>
                    </div>
                    
                    <div class="flex items-center justify-between text-sm text-gray-600">
                        <div class="flex items-center gap-2">
                            <p>Pembayaran Biaya Materai</p>
                            @if($materai > 0)
                                <span class="text-[10px] bg-green-100 text-green-700 font-bold px-2 py-0.5 rounded-full">(Bawa Mandiri oleh Penyewa)</span>
                            @else
                                <span class="text-[10px] bg-green-100 text-green-700 font-bold px-2 py-0.5 rounded-full">(Disediakan oleh Yushi Noona)</span>
                            @endif
                        </div>
                        <p class="font-semibold text-green-600">- Rp {{ number_format($materai, 0, ',', '.') }}</p>
                    </div>
            
                    {{-- Final Remaining Balance Due Block --}}
                    <div class="flex items-center justify-between rounded-2xl p-4 bg-amber-50 border border-amber-200 mt-2">
                        <div class="flex flex-col">
                            <p class="font-bold text-sm text-amber-950">Sisa Pembayaran Pelunasan</p>
                            <p class="text-xs text-amber-800">Dibayarkan saat serah terima unit HANDPHONE</p>
                        </div>
                        <p class="font-black font-bold text-xl text-amber-700 underline decoration-double">
                            Rp {{ number_format($unpaidAmount, 0, ',', '.') }}
                        </p>
                    </div>
            
                </div>
            </div>
        </section>
        <div id="Bottom-nav" class="fixed bottom-0 max-w-[640px] w-full mx-auto border-t border-[#F1F1F1] overflow-hidden z-10">
            <div class="bg-white/50 backdrop-blur-sm absolute w-full h-full"></div>
            <div class="flex items-center justify-between p-5 relative z-10">
                @php
                    // 1. Define your new raw message. We use "\n\n" to create a line break.
                    $rawMessage = "Halo Admin Rental by Yushi's Noona\n\nSaya ingin tanya- tanya dong :)";
                
                    // 2. URL-encode the message for safety and compatibility.
                    $whatsappMessage = rawurlencode($rawMessage);
                
                    // 3. Construct the final URL (make sure the phone number is correct).
                    $whatsappUrl = "https://wa.me/628159254791?text=" . $whatsappMessage;
                @endphp
                <a href="{{ $whatsappUrl }}" class="rounded-full p-[12px_24px] bg-[#FCCF2F] font-bold w-full text-center">Contact Customer Service</a>
            </div>
        </div>
    </main>
</body>
</html>
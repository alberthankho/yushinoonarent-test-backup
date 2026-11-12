<!DOCTYPE html>
@extends('front.layouts.app')

@section('title', 'Checkout for ' . $product->name)
@section('meta-description', 'Complete your booking for ' . $product->name . ' by filling out your details and payment information.')

@section('content')
    <main class="max-w-[640px] mx-auto min-h-screen flex flex-col relative has-[#Bottom-nav]:pb-[144px]">
        <div id="Top-navbar" class="flex items-center justify-between px-5 pt-5">
            <a href="{{url()->previous()}}">
                <div class="size-[44px] flex shrink-0">
                    <img src="{{asset('assets/images/icons/arrow-left.svg')}}" alt="icon" />
                </div>
            </a>
            <p class="text-lg leading-[27px] font-semibold">Checkout</p>
            <button class="size-[44px] flex shrink-0">
                <img src="{{asset('assets/images/icons/more.svg')}}" alt="icon" />
            </button>
        </div>
        <form method="POST" enctype="multipart/form-data" action="{{route('front.checkout.store')}}" class="flex flex-col gap-[30px] mt-[30px]">
            @csrf
            {{-- START: Add this Error Summary Box --}}
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-2xl" role="alert">
                    <strong class="font-bold">Oops! Something went wrong.</strong>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            {{-- END: Error Summary Box --}}
            <!--<section id="Product-name" class="flex flex-col gap-3 px-5">-->
            <!--    <h2 class="font-semibold text-lg leading-[27px]">Product</h2>-->
            <!--    <div class="flex items-center gap-[14px]">-->
            <!--        <div class="w-20 h-20 flex shrink-0 rounded-2xl overflow-hidden bg-[#F6F6F6] items-center">-->
            <!--            <div class="w-full h-[50px] flex shrink-0 justify-center">-->
            <!--                <img src="{{Storage::url($product->thumbnail)}}" class="h-full w-full object-contain" alt="thumbnail">-->
            <!--            </div>-->
            <!--        </div>-->
            <!--        <div class="w-full flex flex-col gap-2">-->
            <!--            <p class="font-bold text-lg leading-[27px]">{{$product->name}}</p>-->
            <!--            <div class="flex items-center gap-[14px]">-->
            <!--                <div class="flex items-center w-fit gap-1">-->
            <!--                    <p class="font-semibold text-sm leading-[21px] text-[#6E6E70]">Original 100%</p>-->
            <!--                    <div class="w-5 h-5 flex shrink-0">-->
            <!--                        <img src="{{asset('assets/images/icons/verify.svg')}}" alt="verify">-->
            <!--                    </div>-->
            <!--                </div>-->
            <!--                <div class="flex items-center w-fit gap-1">-->
            <!--                    <p class="font-semibold text-sm leading-[21px] text-[#6E6E70]">Accessories</p>-->
            <!--                    <div class="w-5 h-5 flex shrink-0">-->
            <!--                        <img src="{{asset('assets/images/icons/verify.svg')}}" alt="verify">-->
            <!--                    </div>-->
            <!--                </div>-->
            <!--            </div>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</section>-->
            <section class="custom-card flex items-center gap-4 p-4 mx-5">
                <div class="w-20 h-20 flex shrink-0 rounded-lg overflow-hidden bg-brand-teal-light items-center justify-center p-2">
                    <img src="{{Storage::url($product->thumbnail)}}" class="h-full w-full object-contain" alt="thumbnail">
                </div>
                <div class="w-full flex flex-col gap-1">
                    <p class="font-bold text-lg leading-snug text-brand-dark">{{$product->name}}</p>
                    <div class="flex items-center gap-4">
                        <div class="flex items-center w-fit gap-1.5">
                            <img src="{{asset('assets/images/icons/verify.svg')}}" alt="verify" class="w-4 h-4">
                            <p class="font-semibold text-sm text-gray-500">Original 100%</p>
                        </div>
                        <div class="flex items-center w-fit gap-1.5">
                            <img src="{{asset('assets/images/icons/verify.svg')}}" alt="verify" class="w-4 h-4">
                            <p class="font-semibold text-sm text-gray-500">Accessories</p>
                        </div>
                    </div>
                </div>
            </section>
            
            <hr class="border-[#EDEEF0] mx-5">
            
            <div id="Customer-info" class="custom-card p-5 flex flex-col px-5 gap-5">
                <h2 class="font-semibold text-lg leading-[27px]">Customer Information</h2>
                <div class="flex flex-col gap-2">
                    <label for="name" class="font-semibold">Full Name (WAJIB Sesuai KTP)</label>
                    <div class="group w-full rounded-2xl border border-[#EDEEF0] p-[18px_14px] flex items-center gap-3 relative transition-all duration-300 focus-within:ring-2 focus-within:ring-[#FCCF2F]">
                        <div class="w-6 h-6 flex shrink-0">
                            <img src="{{asset('assets/images/icons/user.svg')}}" alt="icon">
                        </div>
                        <input type="text" name="name" id="name" class="appearance-none outline-none rounded-2xl w-full placeholder:font-normal placeholder:text-black font-semibold text-sm leading-[24px]" placeholder="Write your full name" required>
                    </div>
                </div>
                <div class="flex flex-col gap-2">
                    <label for="Name" class="font-semibold">Phone Number (Whatsapp)</label>
                    <div class="group w-full rounded-2xl border border-[#EDEEF0] p-[18px_14px] flex items-center gap-3 relative transition-all duration-300 focus-within:ring-2 focus-within:ring-[#FCCF2F]">
                        <div class="w-6 h-6 flex shrink-0">
                            <img src="{{asset('assets/images/icons/call.svg')}}" alt="icon">
                        </div>
                        <input type="tel" name="phone_number" id="Name" class="appearance-none outline-none rounded-2xl w-full placeholder:font-normal placeholder:text-black font-semibold text-sm leading-[24px]" placeholder="Write your phone number" required>
                    </div>
                </div>
            </div>
            
            <hr class="border-[#EDEEF0] mx-5">
            
            {{-- START: New Tenant Information Section --}}
            <div id="Tenant-info" class="custom-card p-5 flex flex-col px-5 gap-5">
                <h2 class="font-semibold text-lg leading-[27px]">Tenant Details (Penyewa)</h2>
                {{-- Paste this inside <div id="Tenant-info" ...> --}}

                {{-- Field for NIK --}}
                <div class="flex flex-col gap-2">
                    <label for="nik" class="font-semibold">NIK</label>
                    <input type="text" name="nik" id="nik" class="rounded-2xl border border-[#EDEEF0] p-4 w-full" placeholder="Enter NIK" required>
                </div>

                {{-- Field for Email --}}
                <div class="flex flex-col gap-2">
                    <label for="email" class="font-semibold">Email</label>
                    <input type="email" name="email" id="email" class="rounded-2xl border border-[#EDEEF0] p-4 w-full" placeholder="Enter email address" required>
                </div>

                {{-- Field for KTP Address --}}
                <div class="flex flex-col gap-2">
                    <label for="tenants_address_ktp" class="font-semibold">Address (according to KTP)</label>
                    <textarea name="tenants_address_ktp" id="tenants_address_ktp" class="rounded-2xl border border-[#EDEEF0] p-4 w-full" rows="3" placeholder="Enter address as on KTP" required></textarea>
                </div>

                {{-- Field for Domicile Address --}}
                <div class="flex flex-col gap-2">
                    <label for="tenants_address_domicile" class="font-semibold">Domicile Address (if different)</label>
                    <textarea name="tenants_address_domicile" id="tenants_address_domicile" class="rounded-2xl border border-[#EDEEF0] p-4 w-full" rows="3" placeholder="Enter current domicile address"></textarea>
                </div>

                {{-- Field for Event/Session --}}
                <div class="flex flex-col gap-2">
                    <label for="event_rent_session" class="font-semibold">Event / Rent Session</label>
                    <input type="text" name="event_rent_session" id="event_rent_session" class="rounded-2xl border border-[#EDEEF0] p-4 w-full" placeholder="e.g., Konser fan meet / session 2">
                </div>

                {{-- Fields for Identification Type (Radio Buttons) --}}
                <div class="flex flex-col gap-4"> {{-- Increased parent gap for better spacing --}}
                    <label class="font-semibold text-lg leading-[27px]">Identification Documents</label>
                    {{-- START: Add Disclaimer Here --}}
                    <p style="color: #DC2626; font-weight: 700; font-size: 0.875rem;">
                        Penyewaan akan dibatalkan & DP hangus jika unggahan tidak sesuai identifikasi. Cek kembali sebelum submit.
                    </p>
                    {{-- END: Disclaimer --}}
                    {{-- First ID (KTP) Section --}}
                    <div class="flex flex-col gap-2 p-4 border border-gray-200 rounded-2xl">
                        <label class="flex items-center gap-[6px]">
                            <input type="radio" class="w-5 h-5" checked disabled>
                            <p class="font-semibold">KTP (Wajib)</p>
                        </label>
                        <input type="hidden" name="first_identification_type" value="KTP">
                        
                        {{-- KTP File Upload --}}
                        <div class="mt-2">
                            <label for="ktp_photo" class="text-sm font-medium text-gray-600">Upload Photo KTP</label>
                            <input type="file" name="user_identification[]" id="ktp_photo"
                                   class="block w-full text-sm text-gray-500 mt-1 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 @error('user_identification.0') ring-2 ring-red-500 rounded-lg p-2 @enderror"
                                   required accept="image/*">
                            @error('user_identification.0')
                                <p class="text-red-500 text-sm mt-1">Please upload a valid KTP photo.</p>
                            @enderror
                        </div>
                    </div>
                
                
                    {{-- Second ID Section --}}
                    <div class="flex flex-col gap-2 p-4 border border-gray-200 rounded-2xl">
                        <p class="font-semibold">Second Identification (Choose One & Upload Photo)</p>
                        @php
                            $secondIdOptions = ['SIM', 'Paspor', 'Kartu Pelajar/Mahasiswa/NPWP', 'STNK/BPKB'];
                        @endphp
                        @foreach($secondIdOptions as $option)
                        <label class="flex items-center gap-[6px] py-1">
                            <input type="radio" name="second_identification_type" value="{{ $option }}" class="w-5 h-5" onclick="toggleSecondIdValue(this.value)" required>
                            <p>{{ $option }}</p>
                        </label>
                        @endforeach
                        @error('second_identification_type') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                
                        {{-- Input for "Others" option --}}
                        <!--<input type="text" name="second_identification_value" id="second_id_value_other" class="rounded-2xl border border-[#EDEEF0] p-4 w-full hidden mt-2" placeholder="Please specify other identification">-->
                        <!--@error('second_identification_value') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror-->
                
                        {{-- Second ID File Upload --}}
                        <div class="mt-2">
                             <label for="second_id_photo" class="text-sm font-medium text-gray-600">Upload Photo Second ID</label>
                             <input type="file" name="user_identification[]" id="second_id_photo"
                                   class="block w-full text-sm text-gray-500 mt-1 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 @error('user_identification.1') ring-2 ring-red-500 rounded-lg p-2 @enderror"
                                   required accept="image/*">
                            @error('user_identification.1')
                                <p class="text-red-500 text-sm mt-1">Please upload a valid second ID photo.</p>
                            @enderror
                        </div>
                    </div>
                </div>


                {{-- Fields for Social Media --}}
                <div class="flex flex-col gap-2">
                    <label for="instagram" class="font-semibold">Instagram (Real Account & Not Private)</label>
                    <input type="text" name="instagram" id="instagram" class="rounded-2xl border border-[#EDEEF0] p-4 w-full" placeholder="@username" required>
                </div>
                <div class="flex flex-col gap-2">
                    <label for="twitter" class="font-semibold">Twitter / X (Min. 6 Months, Real Account & Not Private)</label>
                    <input type="text" name="twitter" id="twitter" class="rounded-2xl border border-[#EDEEF0] p-4 w-full" placeholder="@username">
                </div>

                {{-- Field for Ticket Screenshot --}}
                <div class="flex flex-col gap-2">
                    <label for="ticket_screenshot" class="font-semibold">Ticket Screenshot (Max 2 images)</label>
                    <input type="file" name="ticket_screenshot[]" id="ticket_screenshot" class="rounded-2xl border border-[#EDEEF0] p-4 w-full" multiple accept="image/*">
                </div>            
            </div>
            {{-- END: New Tenant Information Section --}}

            <hr class="border-[#EDEEF0] mx-5">

            {{-- START: New Guarantor Information Section --}}
            <div id="Guarantor-info" class="custom-card p-5 flex flex-col px-5 gap-5">
                <h2 class="font-semibold text-lg leading-[27px]">Guarantor Information (Penjamin)</h2>
                {{-- Paste this inside <div id="Guarantor-info" ...> --}}
                <div class="flex flex-col gap-2">
                    <label for="guarantor_name" class="font-semibold">Guarantor's Full Name</label>
                    <input type="text" name="guarantor_name" id="guarantor_name" class="rounded-2xl border border-[#EDEEF0] p-4 w-full" placeholder="Enter guarantor's name" required>
                </div>

                <div class="flex flex-col gap-2">
                    <label for="relationship_with_guarantor" class="font-semibold">Relationship with Guarantor</label>
                    <input type="text" name="relationship_with_guarantor" id="relationship_with_guarantor" class="rounded-2xl border border-[#EDEEF0] p-4 w-full" placeholder="e.g., Parent, Sibling" required>
                </div>

                <div class="flex flex-col gap-2">
                    <label for="guarantor_phone" class="font-semibold">Guarantor's Phone Number</label>
                    <input type="tel" name="guarantor_phone" id="guarantor_phone" class="rounded-2xl border border-[#EDEEF0] p-4 w-full" placeholder="Enter guarantor's phone number" required>
                </div>
            </div>
            {{-- END: New Guarantor Information Section --}}

            <hr class="border-[#EDEEF0] mx-5">


            <div id="Payment-details" class="custom-card p-5 flex flex-col px-5 gap-3">
                <h2 class="font-semibold text-lg leading-[27px]">Payment Details</h2>
                <div class="flex flex-col gap-4">
                    <div class="flex items-center justify-between">
                        <p>Sub total</p>
                        <p class="font-semibold">Rp {{number_format($insurance, 0, '.')}}</p>
                    </div>
                    {{-- START: New Materai Checkbox --}}
                    <div class="flex items-center justify-between">
                        <label for="materai-checkbox" class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="has_materai" value="1" id="materai-checkbox" class="w-5 h-5 rounded">
                            <span>Punya Materai?</span>
                        </label>
                        {{-- This span will show the fee when checkbox is not checked --}}
                        <span id="materai-fee-display" class="font-semibold text-right"></span>
                    </div>
                    {{-- END: New Materai Checkbox --}}
                    {{-- <div class="flex items-center justify-between">
                        <p>PPN 11%</p>
                        <p class="font-semibold">Rp {{number_format($totalPpn, 0, '.')}}</p>
                    </div> --}}
                    <div class="flex items-center justify-between">
                        <p>Down Payment</p>
                        <p id="down-payment-display" class="font-bold text-xl leading-[30px] underline">Rp {{number_format($insurance, 0, '.')}}</p>
                    </div>
                    {{-- <div class="flex items-center justify-between">
                        <p>Grand total</p>
                        <p class="font-semibold">Rp {{number_format($grandTotal, 0, '.')}}</p>
                    </div> --}}
                </div>
            </div>
            
            <hr class="border-[#EDEEF0] mx-5">
            
            <!--<div id="Send-Payment" class="custom-card p-5 flex flex-col px-5 gap-3">-->
            <!--    <h2 class="font-semibold text-lg leading-[27px]">Send Payment for Down Payment</h2>-->
            <!--    <div class="flex items-center gap-3">-->
            <!--        <div class="w-[71px] h-[50px] flex shrink-0">-->
            <!--            <img src="{{asset('assets/images/logos/bca.svg')}}" class="w-full h-full object-contain" alt="bank logo">-->
            <!--        </div>-->
            <!--        <div class="flex flex-col gap-[2px]">-->
            <!--            <div class="flex items-center w-fit gap-1">-->
            <!--                <p class="font-semibold">DANIEL JOANA CUACA</p>-->
            <!--                <div class="w-[18px] h-[18px] flex shrink-0">-->
            <!--                    <img src="{{asset('assets/images/icons/verify.svg')}}" alt="verify">-->
            <!--                </div>-->
            <!--            </div>-->
            <!--            {{-- Wrapper for account number and copy button --}}-->
            <!--            <div class="flex items-center gap-2 relative">-->
            <!--                <p id="bca-account-number" class="text-[#6E6E70] font-semibold">1196077171</p>-->
            <!--                <button type="button" id="copy-bca-btn" title="Copy number" class="w-5 h-5 text-gray-400 hover:text-gray-800 transition-colors">-->
            <!--                    {{-- Make sure you have a copy icon at this path --}}-->
            <!--                    <img src="{{asset('assets/images/icons/copy.svg')}}" alt="copy icon" />-->
            <!--                </button>-->
            <!--                {{-- Tooltip for feedback --}}-->
            <!--                <span id="copied-bca-tooltip" class="absolute left-full ml-2 hidden text-xs bg-black text-white rounded-md px-2 py-1">Copied!</span>-->
            <!--            </div>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--    {{-- START: Seabank Account (Updated) --}}-->
            <!--    <div class="flex items-center gap-3">-->
            <!--        <div class="w-[71px] h-[50px] flex shrink-0">-->
            <!--            <img src="{{asset('assets/images/logos/seabank.png')}}" class="w-full h-full object-contain" alt="bank logo">-->
            <!--        </div>-->
            <!--        <div class="flex flex-col gap-[2px]">-->
            <!--            <div class="flex items-center w-fit gap-1">-->
            <!--                <p class="font-semibold">DANIEL JOANA CUACA</p>-->
            <!--                <div class="w-[18px] h-[18px] flex shrink-0">-->
            <!--                    <img src="{{asset('assets/images/icons/verify.svg')}}" alt="verify">-->
            <!--                </div>-->
            <!--            </div>-->
            <!--            {{-- Wrapper for Seabank account number and copy button --}}-->
            <!--            <div class="flex items-center gap-2 relative">-->
            <!--                <p id="seabank-account-number" class="text-[#6E6E70] font-semibold">901643620616</p>-->
            <!--                <button type="button" id="copy-seabank-btn" title="Copy number" class="w-5 h-5 text-gray-400 hover:text-gray-800 transition-colors">-->
            <!--                    <img src="{{asset('assets/images/icons/copy.svg')}}" alt="copy icon" />-->
            <!--                </button>-->
            <!--                <span id="copied-seabank-tooltip" class="absolute left-full ml-2 hidden text-xs bg-black text-white rounded-md px-2 py-1">Copied!</span>-->
            <!--            </div>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--    {{-- END: Seabank Account (Updated) --}}-->
            <!--    <div class="flex items-center gap-3">-->
            <!--        <div class="w-[71px] h-[50px] flex shrink-0">-->
            <!--            <img src="{{asset('assets/images/logos/blubca.png')}}" class="w-full h-full object-contain" alt="bank logo">-->
            <!--        </div>-->
            <!--        <div class="flex flex-col gap-[2px]">-->
            <!--            <div class="flex items-center w-fit gap-1">-->
            <!--                <p class="font-semibold">DANIEL JOANA CUACA</p>-->
            <!--                <div class="w-[18px] h-[18px] flex shrink-0">-->
            <!--                    <img src="{{asset('assets/images/icons/verify.svg')}}" alt="verify">-->
            <!--                </div>-->
            <!--            </div>-->
            <!--            {{-- Wrapper for blubca account number and copy button --}}-->
            <!--            <div class="flex items-center gap-2 relative">-->
            <!--                <p id="blubca-account-number" class="text-[#6E6E70] font-semibold">007167969065</p>-->
            <!--                <button type="button" id="copy-blubca-btn" title="Copy number" class="w-5 h-5 text-gray-400 hover:text-gray-800 transition-colors">-->
            <!--                    <img src="{{asset('assets/images/icons/copy.svg')}}" alt="copy icon" />-->
            <!--                </button>-->
            <!--                <span id="copied-blubca-tooltip" class="absolute left-full ml-2 hidden text-xs bg-black text-white rounded-md px-2 py-1">Copied!</span>-->
            <!--            </div>-->
            <!--        </div>-->
            <!--    </div>-->
                
            <!--    {{-- START: QR Code Section --}}-->
            <!--    <div class="flex flex-col items-center gap-2 mt-4 pt-4 border-t border-gray-200">-->
            <!--        <p class="font-bold text-gray-800">QR Code (A/N MIGOS_DIAMOND)</p>-->
            <!--        <div class="w-48 h-48 p-2 bg-white border rounded-lg">-->
            <!--            {{-- IMPORTANT: Make sure you have your QR code image at this path --}}-->
            <!--            <img src="{{ asset('assets/images/qrmigos.jpg') }}" alt="QR Code" class="w-full h-full object-contain">-->
            <!--        </div>-->
            <!--    </div>-->
            <!--    {{-- END: QR Code Section --}}-->
            <!--</div>-->
            
            <!--<hr class="border-[#EDEEF0] mx-5">-->
            
            <!--<div id="Confirm-Payment" class="custom-card p-5 flex flex-col px-5 gap-5">-->
            <!--    <h2 class="font-semibold text-lg leading-[27px]">Confirm Down Payment</h2>-->
            <!--    <div class="flex flex-col gap-2">-->
            <!--        <label for="Proof" class="font-semibold">Upload Proof (Down Payment)</label>-->
            <!--        <div class="group w-full rounded-2xl border border-[#EDEEF0] p-[18px_14px] flex items-center gap-3 relative transition-all duration-300 focus-within:ring-2 focus-within:ring-[#FCCF2F] relative">-->
            <!--            <div class="w-6 h-6 flex shrink-0">-->
            <!--            <img src="{{asset('assets/images/icons/note-add.svg')}}" alt="icon">-->
            <!--            </div>-->
            <!--            <button type="button" id="Upload-btn" class="appearance-none outline-none w-full text-left" onclick="document.getElementById('Proof').click()">-->
            <!--            Add an attachment-->
            <!--            </button>-->
            <!--            <input type="file" name="proof" id="Proof" class="absolute -z-10 opacity-0" required>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--    <label class="flex items-center gap-[6px]">-->
            <!--        <input type="checkbox" name="" class="w-[24px] h-[24px] appearance-none checked:border-[5px] checked:border-solid checked:border-white rounded-[10px] checked:bg-[#FCCF2F] ring-1 ring-[#d7f5ee] transition-all duration-300" required/>-->
            <!--        <p class="font-semibold text-sm leading-[21px]">Saya benar telah transfer pembayaran down payment <br>(Pelunasan saat COD di venue)</p>-->
            <!--    </label>-->
            <!--</div>-->
            <div id="Bottom-nav" class="fixed bottom-0 max-w-[640px] w-full mx-auto border-t border-[#F1F1F1] overflow-hidden z-10">
                <div class="bg-white/50 backdrop-blur-sm absolute w-full h-full"></div>
                <div class="p-5 relative z-10">
                    <button type="submit" class="rounded-full p-[12px_24px] bg-[#FCCF2F] font-bold w-full">Confirm Payment</button>
                </div>
            </div>
        </form>
    </main>

    <script src="{{asset('customjs/checkout.js')}}"></script>
    {{-- START: New script for radio button --}}
    // <script>
    //     function toggleSecondIdValue(value) {
    //         const otherInput = document.getElementById('second_id_value_other');
    //         if (value === 'Others') {
    //             otherInput.classList.remove('hidden');
    //             otherInput.setAttribute('required', 'required'); // Make it required if "Others" is selected
    //         } else {
    //             otherInput.classList.add('hidden');
    //             otherInput.removeAttribute('required'); // No longer required
    //         }
    //     }
    // </script>

    <script>
    /**
     * A reusable function to add "copy to clipboard" functionality to a button.
     * @param {string} buttonId - The ID of the clickable button element.
     * @param {string} textElementId - The ID of the element containing the text to copy.
     * @param {string} tooltipId - The ID of the tooltip element to show on success.
     */
    function setupCopyButton(buttonId, textElementId, tooltipId) {
        const copyButton = document.getElementById(buttonId);
        const textElement = document.getElementById(textElementId);
        const tooltipElement = document.getElementById(tooltipId);

        // Make sure all required elements exist on the page
        if (copyButton && textElement && tooltipElement) {
            copyButton.addEventListener('click', () => {
                // Get the text from the specified element
                const textToCopy = textElement.innerText;

                // Use the modern Navigator Clipboard API
                navigator.clipboard.writeText(textToCopy).then(() => {
                    // On success, show the tooltip
                    tooltipElement.classList.remove('hidden');

                    // Hide the tooltip again after 2 seconds
                    setTimeout(() => {
                        tooltipElement.classList.add('hidden');
                    }, 2000);
                }).catch(err => {
                    // Log an error if the command fails
                    console.error('Failed to copy text: ', err);
                });
            });
        }
    }

    // --- Now, we call the function for each button ---

    // Setup for the BCA copy button
    setupCopyButton('copy-bca-btn', 'bca-account-number', 'copied-bca-tooltip');

    // Setup for the Seabank copy button
    setupCopyButton('copy-seabank-btn', 'seabank-account-number', 'copied-seabank-tooltip');
    
    // Setup for the Seabank copy button
    setupCopyButton('copy-blubca-btn', 'blubca-account-number', 'copied-blubca-tooltip');

</script>
    {{-- END: New script for radio button --}}
    
    {{-- START: New script for dynamic Down Payment --}}
    <script>
        // Wait for the page to fully load
        document.addEventListener('DOMContentLoaded', function () {
            
            // Get the elements we need to work with
            const materaiCheckbox = document.getElementById('materai-checkbox');
            const downPaymentDisplay = document.getElementById('down-payment-display');
            const materaiFeeDisplay = document.getElementById('materai-fee-display');

            // Get the base down payment value from your controller (passed as $insurance)
            const baseDownPayment = {{ $insurance }};
            const materaiFee = 11000;

            // This function will calculate and update the displayed prices
            function updateDownPayment() {
                let finalDownPayment;
                
                // Check if the checkbox is checked
                if (materaiCheckbox.checked) {
                    // If CHECKED, Down Payment is the base amount
                    finalDownPayment = baseDownPayment;
                    materaiFeeDisplay.innerText = 'Rp 0'; // Show no fee
                } else {
                    // If NOT CHECKED, add the 10,000 fee
                    finalDownPayment = baseDownPayment + materaiFee;
                    materaiFeeDisplay.innerText = '+ Rp ' + new Intl.NumberFormat('id-ID').format(materaiFee); // Show the fee
                }

                // Format the final value as Indonesian Rupiah and update the display
                const formattedDownPayment = 'Rp ' + new Intl.NumberFormat('id-ID').format(finalDownPayment);
                downPaymentDisplay.innerText = formattedDownPayment;
            }

            // Add an event listener to the checkbox, so the price updates every time it's clicked
            materaiCheckbox.addEventListener('change', updateDownPayment);

            // Run the function once when the page loads to set the initial correct value
            updateDownPayment();
        });
    </script>
    {{-- END: New script for dynamic Down Payment --}}
@endsection

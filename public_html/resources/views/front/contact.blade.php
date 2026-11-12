@extends('front.layouts.app')

@section('title', 'Contact Us - Rental by Yushi\'s Noona')
@section('meta-description', 'Hubungi kami untuk pertanyaan seputar sewa handphone, jadwal event, atau bantuan lainnya. Kami siap melayani Anda.')

@section('content')
 
<main class="max-w-[640px] mx-auto min-h-screen flex flex-col relative has-[#Bottom-nav]:pb-[144px]">
    <div class="relative z-10 flex flex-col h-full px-5">

        <div id="Top-navbar" class="flex items-center justify-between pt-5 w-full">
            {{-- Since this is a main page from the nav bar, we might not need a back button,
                 but you can add one if you like: <a href="{{ route('front.index') }}">...</a> --}}
            <div class="size-[44px]"></div> {{-- Empty div for alignment --}}
            <p class="text-lg leading-[27px] font-semibold text-brand-dark">Contact Us</p>
            <div class="size-[44px]"></div> {{-- Empty div for alignment --}}
        </div>

        <section id="Contact-info" class="flex flex-col gap-5 mt-8">

            {{-- START: New Logo Section (Corrected Size) --}}
            <div class="w-full flex justify-center"> {{-- This centers the logo on the page --}}
                <div class="w-32 h-auto"> {{-- Reduced size from w-48 to w-32 (128px) --}}
                    <img src="{{ asset('assets/images/logos/logoYushiTrans.png') }}" alt="Yushi's Noona Logo" class="w-full h-auto" style="height: 250px; width: auto;">
                </div>
            </div>
            {{-- END: New Logo Section --}}
            {{-- END: New Logo Section --}}

            {{-- START: New Slogan Card --}}
            <div class="custom-card w-full text-center p-5">
                <p class="font-semibold text-lg text-brand-text-pink-dark">
                    Rental by Yushi's Noona ⭐️
                </p>
                <p class="font-semibold text-lg text-brand-text-pink-dark">
                    📱 Rental HP For Concert 😚

                </p>
                <p class="font-semibold text-lg text-brand-text-pink-dark">
                    🤳 Buat konser biar tetep catchy
                </p>
                <p class="font-semibold text-lg text-brand-text-pink-dark">
                    🚚 COD & kirim-kirim no problem
                </p>
            </div>
            {{-- END: New Slogan Card --}}
            {{-- WhatsApp Card --}}
            @php
                $whatsappMessage = rawurlencode("Halo Admin Rental by Yushi's Noona, saya ingin bertanya...");
                $whatsappUrl = "https://wa.me/628159254791?text=" . $whatsappMessage;
            @endphp
            <a href="{{ $whatsappUrl }}" target="_blank" class="custom-card flex items-center p-4 gap-4">
                <div class="w-12 h-12 flex shrink-0 items-center justify-center bg-green-100 rounded-full">
                    <img src="{{ asset('assets/images/icons/whasapp-green-icon.png') }}" alt="WhatsApp Icon" class="w-7 h-7" style="height: 100px; width: auto;">
                </div>
                <div class="flex flex-col gap-1">
                    <p class="font-bold text-brand-dark">WhatsApp Admin</p>
                    <p class="text-sm text-gray-500">Click to chat for fast response</p>
                </div>
            </a>

            {{-- Instagram Card --}}
            <a href="https://www.instagram.com/yushinoonarent/" target="_blank" class="custom-card flex items-center p-4 gap-4">
                <div class="w-12 h-12 flex shrink-0 items-center justify-center bg-pink-100 rounded-full">
                    <img src="{{ asset('assets/images/icons/instagram transparant.png') }}" alt="Instagram Icon" class="w-7 h-7" style="height: 100px; width: auto;">
                </div>
                <div class="flex flex-col gap-1">
                    <p class="font-bold text-brand-dark">Instagram</p>
                    <p class="text-sm text-gray-500">@yushisnoonarent</p>
                </div>
            </a>
            
            {{-- Tiktok Card --}}
            <a href="https://tiktok.com/@yushinoonarent_" target="_blank" class="custom-card flex items-center p-4 gap-4">
                <div class="w-12 h-12 flex shrink-0 items-center justify-center bg-pink-100 rounded-full">
                    <img src="{{ asset('assets/images/icons/tiktok_transparant.png') }}" alt="Instagram Icon" class="w-7 h-7" style="height: 100px; width: auto;">
                </div>
                <div class="flex flex-col gap-1">
                    <p class="font-bold text-brand-dark">TikTok</p>
                    <p class="text-sm text-gray-500">@yushisnoonarent_</p>
                </div>
            </a>

        </section>

    </div>

    			<div id="Bottom-nav" class="fixed bottom-0 max-w-[640px] w-full mx-auto border-t border-[#F1F1F1] overflow-hidden z-10">
				<div class="bg-white/50 backdrop-blur-sm absolute w-full h-full"></div>
				<ul class="flex items-center gap-3 justify-evenly p-5 relative z-10">
					<li>
						<a href="{{ route('front.index') }}">
							<div class="group flex flex-col items-center text-center gap-2 transition-all duration-300 hover:text-black text-[#9D9DAD]">
								<div class="w-6 h-6 flex shrink-0">
									<svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path
											d="M17.325 18.98H7.92495C7.50495 18.98 7.03495 18.65 6.89495 18.25L2.75495 6.66999C2.16496 5.00999 2.85496 4.49999 4.27496 5.51999L8.17495 8.30999C8.82495 8.75999 9.56495 8.52999 9.84495 7.79999L11.605 3.10999C12.165 1.60999 13.095 1.60999 13.655 3.10999L15.415 7.79999C15.695 8.52999 16.435 8.75999 17.075 8.30999L20.735 5.69999C22.295 4.57999 23.045 5.14999 22.405 6.95999L18.365 18.27C18.215 18.65 17.745 18.98 17.325 18.98Z"
											stroke="currentColor"
											stroke-width="2"
											stroke-linecap="round"
											stroke-linejoin="round"
										/>
										<path d="M7.125 22H18.125" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
										<path d="M10.125 14H15.125" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
									</svg>
								</div>
								<p class="font-semibold text-sm leading-[21px] text-[]">Browse</p>
							</div>
						</a>
					</li>
					<li>
						<a href="{{ route('front.transactions') }}">
							<div class="group flex flex-col items-center text-center gap-2 transition-all duration-300 hover:text-black text-[#9D9DAD]">
								<div class="w-6 h-6 flex shrink-0">
									<svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M8.875 2V5" stroke="currentColor" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
										<path d="M16.875 2V5" stroke="currentColor" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
										<path d="M7.875 13H15.875" stroke="currentColor" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
										<path d="M7.875 17H12.875" stroke="currentColor" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
										<path
											d="M16.875 3.5C20.205 3.68 21.875 4.95 21.875 9.65V15.83C21.875 19.95 20.875 22.01 15.875 22.01H9.875C4.875 22.01 3.875 19.95 3.875 15.83V9.65C3.875 4.95 5.545 3.69 8.875 3.5H16.875Z"
											stroke="currentColor"
											stroke-width="2"
											stroke-miterlimit="10"
											stroke-linecap="round"
											stroke-linejoin="round"
										/>
									</svg>
								</div>
								<p class="font-semibold text-sm leading-[21px] text-[]">Orders</p>
							</div>
						</a>
					</li>
					<li>
						<a href="{{ route('front.contact') }}">
							<div class="group flex flex-col items-center text-center gap-2 transition-all duration-300 hover:text-black">
								<div class="w-6 h-6 flex shrink-0">
									<svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path
											d="M18.375 18.86H17.615C16.815 18.86 16.055 19.17 15.495 19.73L13.785 21.42C13.005 22.19 11.735 22.19 10.955 21.42L9.245 19.73C8.685 19.17 7.915 18.86 7.125 18.86H6.375C4.715 18.86 3.375 17.53 3.375 15.89V4.97998C3.375 3.33998 4.715 2.01001 6.375 2.01001H18.375C20.035 2.01001 21.375 3.33998 21.375 4.97998V15.89C21.375 17.52 20.035 18.86 18.375 18.86Z"
											stroke="currentColor"
											stroke-width="2"
											stroke-miterlimit="10"
											stroke-linecap="round"
											stroke-linejoin="round"
										/>
										<path
											d="M7.375 9.16003C7.375 8.23003 8.135 7.46997 9.065 7.46997C9.995 7.46997 10.755 8.23003 10.755 9.16003C10.755 11.04 8.085 11.24 7.495 13.03C7.375 13.4 7.685 13.77 8.075 13.77H10.755"
											stroke="currentColor"
											stroke-width="2"
											stroke-linecap="round"
											stroke-linejoin="round"
										/>
										<path
											d="M16.415 13.76V8.05003C16.415 7.79003 16.245 7.55997 15.995 7.48997C15.745 7.41997 15.475 7.51997 15.335 7.73997C14.615 8.89997 13.835 10.22 13.155 11.38C13.045 11.57 13.045 11.82 13.155 12.01C13.265 12.2 13.475 12.3199 13.705 12.3199H17.375"
											stroke="currentColor"
											stroke-width="2"
											stroke-linecap="round"
											stroke-linejoin="round"
										/>
									</svg>
								</div>
								<p class="font-semibold text-sm leading-[21px] text-[]">Contact</p>
							</div>
						</a>
					</li>
				</ul>
			</div>

</main>

@endsection
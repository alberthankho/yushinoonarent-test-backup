@extends('front.layouts.app')
@section('title', "Sewa Handphone Konser & Event - Rental by Yushi's Noona")
@section('content')

		<main class="max-w-[640px] mx-auto min-h-screen flex flex-col relative has-[#Bottom-nav]:pb-[144px]">
            <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; z-index: -1; overflow: hidden; pointer-events: none;">
                {{-- Existing Stars --}}
                <span class="animate-twinkle" style="position: absolute; top: 8%; right: 10%; font-size: 3rem; color: #fde047; opacity: 0.6; transform: rotate(15deg); animation-delay: 0.5s;">⭐</span>
                <span style="position: absolute; top: 15%; left: 5%; font-size: 2.25rem; color: #fde047; opacity: 0.4; transform: rotate(-5deg);">⭐</span>
                <span class="animate-twinkle" style="position: absolute; top: 25%; right: 15%; font-size: 1.875rem; color: #fde047; opacity: 0.5; transform: rotate(10deg);">⭐</span>
                <span class="animate-twinkle" style="position: absolute; top: 80%; left: 20%; font-size: 4.5rem; color: #fde047; opacity: 0.3; transform: rotate(-15deg); animation-delay: 1s;">⭐</span>
                <span style="position: absolute; top: 88%; right: 5%; font-size: 3rem; color: #fde047; opacity: 0.5; transform: rotate(20deg);">🌟</span>
                <span class="animate-twinkle" style="position: absolute; top: 95%; left: 10%; font-size: 1.875rem; color: #fde047; opacity: 0.6; transform: rotate(5deg); animation-delay: 2s;">⭐</span>
            
                {{-- START: Added More Stars --}}
                <span style="position: absolute; top: 30%; left: 30%; font-size: 1.5rem; color: #fde047; opacity: 0.5; transform: rotate(25deg);">⭐</span>
                <span class="animate-twinkle" style="position: absolute; top: 50%; left: 50%; font-size: 2.5rem; color: #fde047; opacity: 0.6; transform: translate(-50%, -50%) rotate(-10deg); animation-delay: 1.5s;">⭐</span>
                <span style="position: absolute; top: 70%; right: 25%; font-size: 1.25rem; color: #fde047; opacity: 0.4; transform: rotate(18deg);">⭐</span>
                <span class="animate-twinkle" style="position: absolute; top: 8%; left: 45%; font-size: 1.5rem; color: #fde047; opacity: 0.5; transform: rotate(-10deg); animation-delay: 2.5s;">🌟</span>
                <span style="position: absolute; top: 2%; left: 15%; font-size: 1.25rem; color: #fde047; opacity: 0.6;">⭐</span>
                <span class="animate-twinkle" style="position: absolute; top: 55%; right: 40%; font-size: 1.875rem; color: #fde047; opacity: 0.3; animation-delay: 0.2s;">⭐</span>
                <span style="position: absolute; top: 75%; left: 5%; font-size: 2rem; color: #fde047; opacity: 0.5; transform: rotate(-12deg);">⭐</span>
                <span style="position: absolute; top: 45%; left: 60%; font-size: 1.25rem; color: #fde047; opacity: 0.4;">⭐</span>
                <span class="animate-twinkle" style="position: absolute; top: 95%; right: 50%; font-size: 1.5rem; color: #fde047; opacity: 0.5; animation-delay: 3s;">⭐</span>
                {{-- END: Added More Stars --}}
            
                {{-- START: New Colorful Star Ornaments --}}
                <img class="animate-pulse" src="{{ asset('assets/images/icons/bintang transparant.png') }}" style="position: absolute; top: 12%; left: 75%; width: 40px; transform: rotate(-20deg); opacity: 0.7; animation-delay: 0.8s;">
                <img src="{{ asset('assets/images/icons/bintang transparant.png') }}" style="position: absolute; top: 60%; right: 3%; width: 60px; transform: rotate(35deg); opacity: 0.5; animation-delay: 1.2s;">
                <img class="animate-twinkle" src="{{ asset('assets/images/icons/bintang transparant.png') }}" style="position: absolute; bottom: 15%; left: 35%; width: 50px; transform: rotate(10deg); opacity: 0.6; animation-delay: 2.1s;">
                {{-- END: New Colorful Star Ornaments --}}
                
                {{-- START: Your New Image Ornaments --}}
    {{-- Make sure the image path is correct --}}

    {{-- A medium-sized one on the middle-right --}}
    <img src="{{ asset('assets/images/icons/bintang transparant.png') }}" alt="ornament"
         class="animate-twinkle"
         style="position: absolute; top: 45%; right: 8%; width: 80px; transform: rotate(20deg); opacity: 0.7; animation-delay: 1.2s;">

    {{-- A smaller one on the upper-right to fill a gap --}}
    <img src="{{ asset('assets/images/icons/bintang transparant.png') }}" alt="ornament"
         style="position: absolute; top: 18%; right: 30%; width: 45px; transform: rotate(-10deg); opacity: 0.5;">

    {{-- A larger, fainter one on the lower-right --}}
    <img src="{{ asset('assets/images/icons/bintang transparant.png') }}" alt="ornament"
         class="animate-pulse"
         style="position: absolute; top: 75%; right: 22%; width: 100px; transform: rotate(10deg); opacity: 0.3; animation-delay: 0.5s;">
         
    {{-- A small one to balance the left side --}}
    <img src="{{ asset('assets/images/icons/bintang transparant.png') }}" alt="ornament"
         class="animate-twinkle"
         style="position: absolute; top: 55%; left: 10%; width: 40px; transform: rotate(15deg); opacity: 0.6; animation-delay: 2s;">
         
    {{-- END: Your New Image Ornaments --}}
            
            </div>
		    {{-- This wrapper ensures all your content stays on top of the ornaments --}}
            <div class="relative z-10 flex flex-col h-full">
    			<div id="Top-navbar" class="flex items-center justify-between pt-5 px-5">
    				<a href="{{route('front.index')}}" class="flex shrink-0">
    					<img src="{{asset('assets/images/logos/logoYushiTrans.png')}}" alt="Yushi's Noona Logo" style="height: 250px; width: auto;">
    				</a>
    				{{-- <a href="#" class="w-11 h-11 flex shrink-0">
    					<img src="{{asset('assets/images/icons/notifications.svg')}}" alt="icon" />
    				</a> --}}
    			</div>
    			<section id="Categories" class="flex flex-col gap-[10px] mt-[20px] px-5">
                    <h2 class="font-semibold text-lg leading-[27px] text-brand-text-pink-dark">By Categories</h2>
                    <div class="grid grid-cols-3 gap-4">
                        @forelse($categories as $category)
                        <a href="{{route('front.category', $category->slug)}}" class="custom-card">
                            <div class="p-4 flex flex-col items-center gap-3 text-center">
                                <div class="w-[50px] h-[50px] flex shrink-0">
                                    <img src="{{Storage::url($category->icon)}}" alt="icon" />
                                </div>
                                <p class="font-semibold text-brand-dark">{{$category->name}}</p>
                            </div>
                        </a>
                        @empty
                        <p class="text-brand-dark col-span-3">No categories yet.</p>
                        @endforelse
                    </div>
                </section>
    			{{-- <a id="promo" href="#" class="px-5 mt-[30px]">
    				<div class="w-full aspect-[353/100] flex shrink-0 overflow-hidden rounded-2xl">
    					<img src="{{asset('assets/images/backgrounds/promo.png')}}" class="w-full h-full object-cover" alt="promo" />
    				</div>
    			</a> --}}
    			<section id="New" class="flex flex-col gap-[10px] mt-[30px]">
                <h2 class="font-semibold text-lg leading-[27px] px-5 text-brand-text-pink-dark">You Might Like</h2>
                <div class="swiper w-full h-fit">
                    <div class="swiper-wrapper py-4"> {{-- Added padding for shadow --}}
                        @forelse($latest_product as $item_latest_product)
                        <a href="{{route('front.details', $item_latest_product->slug)}}" class="swiper-slide max-w-[150px] first-of-type:ml-5 last-of-type:mr-5">
                            <div class="custom-card flex flex-col">
                                <div class="product-card-image-bg">
                                    <div class="h-[70px] w-full flex shrink-0 justify-center p-2">
                                        <img src="{{Storage::url($item_latest_product->thumbnail)}}" class="w-full h-full object-contain" alt="thumbnail" />
                                    </div>
                                </div>
                                <div class="product-card-details">
                                    <p class="font-semibold break-words text-brand-dark truncate">{{$item_latest_product->name}}</p>
                                    <p class="text-sm text-gray-500">{{ optional($item_latest_product->category)->name }}</p>
                                </div>
                            </div>
                        </a>
                        @empty
                        <p class="px-5 text-brand-dark">No new products yet.</p>
                        @endforelse
                    </div>
                </div>
            </section>
    			{{-- <section id="Recommendation" class="flex flex-col gap-[10px] mt-[30px] px-5">
    				<h2 class="font-semibold text-lg leading-[27px]">You Might Like</h2>
    				<div class="flex flex-col gap-5">
    
                        @forelse($random_product as $item_random_product)
    					<a href="{{route('front.details', $item_random_product->slug)}}" class="card">
    						<div class="flex items-center gap-3">
    							<div class="w-20 h-20 flex shrink-0 rounded-2xl overflow-hidden bg-[#F6F6F6] items-center">
    								<div class="w-full h-[50px] flex shrink-0 justify-center">
    									<img src="{{Storage::url($item_random_product->thumbnail)}}" class="h-full w-full object-contain" alt="thumbnail" />
    								</div>
    							</div>
    							<div class="w-full flex flex-col gap-1">
    								<p class="font-semibold">{{$item_random_product->name}}</p>
    								<div class="flex items-center justify-between">
    									<p class="text-sm leading-[21px] text-[#6E6E70]">Rp {{number_format($item_random_product->price, 0, '.')}}/day</p>
    									<div class="flex items-center w-fit gap-[2px]">
    										<div class="w-4 h-4 flex shrink-0">
    											<img src="{{asset('assets/images/icons/Star 1.svg')}}" alt="star" />
    										</div>
    										<p class="text-sm leading-[21px]"><span class="font-semibold">4/5</span> <span class="text-[#6E6E70]">(777)</span></p>
    									</div>
    								</div>
    							</div>
    						</div>
    					</a>
                        @empty
                        <p>Belum ada data rekomendasi produk terbaru</p>
                        @endforelse
    				</div>
    			</section> --}}
    
                @php
                    // 1. Define your new raw message. We use "\n\n" to create a line break.
                    $rawMessage = "Halo Admin Rental by Yushi's Noona\n\nSaya ingin tanya- tanya dong :)";
                
                    // 2. URL-encode the message for safety and compatibility.
                    $whatsappMessage = rawurlencode($rawMessage);
                
                    // 3. Construct the final URL (make sure the phone number is correct).
                    $whatsappUrl = "https://wa.me/628159254791?text=" . $whatsappMessage;
                @endphp
    			<a  href="{{ $whatsappUrl }}"
    				target="_blank"
    				title="Chat on WhatsApp"
    				style="position: fixed;
    						bottom: 115px;  /* Adjust: BottomNav is ~93px tall. 93px + 22px (gap) = 115px. */
    						right: 20px;     /* Distance from the right edge of the browser window. Adjust if needed. */
    						width: 56px;
    						height: 56px;
    						background-color: white; /* White background for your green icon */
    						border: 1px solid #e0e0e0; /* Light gray border for definition */
    						border-radius: 50%;      /* Makes it a circle */
    						box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15); /* A nice shadow */
    						display: flex;
    						align-items: center;
    						justify-content: center;
    						z-index: 2000;           /* High z-index, make sure it's above your Bottom-nav */
    						pointer-events: auto;
    						text-decoration: none;
    						transition: background-color 0.2s ease-in-out, transform 0.1s ease-in-out;"
    				{{-- JavaScript for basic hover and active (pressed) effect --}}
    				onmouseover="this.style.backgroundColor='#f5f5f5';" {{-- Lighter gray on hover --}}
    				onmouseout="this.style.backgroundColor='white';"
    				onmousedown="this.style.transform='scale(0.95)'; this.style.backgroundColor='#eeeeee';" {{-- Slightly shrink and darker gray on press --}}
    				onmouseup="this.style.transform='scale(1)'; this.style.backgroundColor='#f5f5f5';">
    
    					{{-- Using YOUR icon name. Ensure this path is correct from your 'public' folder. --}}
    					<img src="{{ asset('assets/images/icons/whasapp-green-icon.png') }}"
    						alt="WhatsApp Icon"
    						style="width: 36px; height: 36px;"/>
    			</a>
    
    			<div id="Bottom-nav" class="fixed bottom-0 max-w-[640px] w-full mx-auto border-t border-[#F1F1F1] overflow-hidden z-10">
    				<div class="bg-white/50 backdrop-blur-sm absolute w-full h-full"></div>
    				<ul class="flex items-center gap-3 justify-evenly p-5 relative z-10">
    					<li>
    						<a href="{{route('front.index')}}">
    							<div class="group flex flex-col items-center text-center gap-2 transition-all duration-300 hover:text-black">
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
    					{{-- <li>
    						<a href="">
    							<div class="group flex flex-col items-center text-center gap-2 transition-all duration-300 hover:text-black text-[#9D9DAD]">
    								<div class="w-6 h-6 flex shrink-0">
    									<svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
    										<path
    											d="M19.625 12.5C19.625 11.12 20.745 10 22.125 10V9C22.125 5 21.125 4 17.125 4H7.125C3.125 4 2.125 5 2.125 9V9.5C3.505 9.5 4.625 10.62 4.625 12C4.625 13.38 3.505 14.5 2.125 14.5V15C2.125 19 3.125 20 7.125 20H17.125C21.125 20 22.125 19 22.125 15C20.745 15 19.625 13.88 19.625 12.5Z"
    											stroke="currentColor"
    											stroke-width="2"
    											stroke-linecap="round"
    											stroke-linejoin="round"
    										/>
    										<path d="M9.125 14.75L15.125 8.75" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
    										<path d="M15.1195 14.75H15.1285" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
    										<path d="M9.11951 9.25H9.12849" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
    									</svg>
    								</div>
    								<p class="font-semibold text-sm leading-[21px] text-[]">Promos</p>
    							</div>
    						</a>
    					</li> --}}
    					<li>
    						<a href="{{ route('front.contact') }}">
    							<div class="group flex flex-col items-center text-center gap-2 transition-all duration-300 hover:text-black text-[#9D9DAD]">
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
    		</div>
		</main>
		@endsection

		@push('after-styles')
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
		@endpush

		@push('after-scripts')
		<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
		<script src="{{asset('customjs/browse.js')}}"></script>
		<!-- Brevo Conversations {literal} -->
 <script>
//     (function(d, w, c) {
//         w.BrevoConversationsID = '6842c3f5a88494ddad0d96c0';
//         w[c] = w[c] || function() {
//             (w[c].q = w[c].q || []).push(arguments);
//         };
//         var s = d.createElement('script');
//         s.async = true;
//         s.src = 'https://conversations-widget.brevo.com/brevo-conversations.js';
//         if (d.head) d.head.appendChild(s);
//     })(document, window, 'BrevoConversations');
 </script>
<!-- /Brevo Conversations {/literal} -->
		@endpush

		

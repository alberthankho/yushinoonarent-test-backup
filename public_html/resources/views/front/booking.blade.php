<!DOCTYPE html>
@extends('front.layouts.app')

@section('title', 'Booking for ' . $product->name)
@section('meta-description', 'Sewa ' . $product->name . ' dengan harga harian terbaik. Pilih tanggal dan event untuk booking sekarang.')

@section('content')

	<main class="max-w-[640px] mx-auto min-h-screen flex flex-col relative has-[#Bottom-nav]:pb-[144px]">
		<div id="Top-navbar" class="flex items-center justify-between px-5 pt-5">
            <a href="{{ route('front.details', $product->slug) }}">
				<div class="size-[44px] flex shrink-0">
					<img src="{{asset('assets/images/icons/arrow-left.svg')}}" alt="icon" />
				</div>
			</a>
			<p class="text-lg leading-[27px] font-semibold">Booking</p>
			<button class="size-[44px] flex shrink-0">
				<img src="{{asset('assets/images/icons/more.svg')}}" alt="icon" />
			</button>
		</div>
		
		{{-- Product Header Card --}}
        <section id="Product-name" class="custom-card flex items-center gap-4 p-4 mx-5 mt-[30px]">
            <div class="w-20 h-20 flex shrink-0 rounded-lg overflow-hidden bg-brand-teal-light items-center justify-center p-2">
                <img src="{{Storage::url($product->thumbnail)}}" class="h-full w-full object-contain" alt="thumbnail" />
            </div>
            <div class="w-full flex flex-col gap-1">
                <p class="font-bold text-lg leading-snug text-brand-dark">{{$product->name}}</p>
                <div class="flex items-center gap-4">
                    <div class="flex items-center w-fit gap-1.5">
                        <img src="{{asset('assets/images/icons/verify.svg')}}" alt="verify" class="w-4 h-4" />
                        <p class="font-semibold text-sm text-gray-500">Original 100%</p>
                    </div>
                    <div class="flex items-center w-fit gap-1.5">
                        <img src="{{asset('assets/images/icons/verify.svg')}}" alt="verify" class="w-4 h-4" />
                        <p class="font-semibold text-sm text-gray-500">Accessories</p>
                    </div>
                </div>
            </div>
        </section>
		
		<hr class="mt-[30px] border-[#EDEEF0] mx-5" />
		<div class="flex flex-col gap-3 px-5 mt-[30px]">
			<h2 class="font-semibold text-lg leading-[27px]">Details</h2>
			<p class="text-sm leading-[24px] text-[#6E6E70]">Silahkan tuliskan details booking dengan teliti untuk
				menghindari kesalahan biaya sewa barang</p>
		</div>
		<!--<a id="promo" href="#" class="px-5 mt-[30px]">-->
		<!--	<div class="w-full aspect-[353/100] flex shrink-0 overflow-hidden rounded-2xl">-->
		<!--		<img src="{{asset('assets/images/backgrounds/promo.png')}}" class="w-full h-full object-cover" alt="promo" />-->
		<!--	</div>-->
		<!--</a>-->
		<!--@if($errors->any())-->
		<!--	@foreach($errors->all() as $error)-->
		<!--		<div class="py-3 w-full rounded-3xl bg-[#FCCF2F] text-black">-->
		<!--			{{$error}}-->
		<!--		</div>-->
		<!--	@endforeach-->
		<!--@endif-->
		<form method="POST" action="{{route('front.booking_save', $product->slug)}}" class="flex flex-col gap-[30px] mt-[30px]">
			@csrf
			<input type="hidden" name="started_at" id="started_at" required />
			<input type="hidden" value="{{$product->price}}" id="productPrice"/>
			<input type="hidden" name="delivery_type" value="pickup" id="deliveryType"/>
			<input type="hidden" name="duration" id="duration" value="1" class="absolute -z-10 opacity-0 w-1"
						required />

			@if($errors->any())
            <div class="px-5">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-2xl" role="alert">
                    <strong class="font-bold">Oops! Something went wrong.</strong>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
			<div class="flex items-center justify-between px-5">
				<label for="days" class="font-semibold">How many days?</label>
				<div class="flex items-center gap-3 relative">
					<button type="button" id="Minus"
						class="w-11 h-11 flex shrink-0 rounded-full transition-all duration-300 hover:ring-2 hover:ring-[#d7f5ee]">
						<img src="{{asset('assets/images/icons/minus.svg')}}" alt="minus" />
					</button>
					<p id="CountDays" class="font-semibold text-lg leading-[27px]">1</p>
					<input type="number" name="days" id="Days" value="1" class="absolute -z-10 opacity-0 w-1"
						required />
					<button type="button" id="Plus"
						class="w-11 h-11 flex shrink-0 rounded-full transition-all duration-300 hover:ring-2 hover:ring-[#d7f5ee]">
						<img src="{{asset('assets/images/icons/plus.svg')}}" alt="plus" />
					</button>
				</div>
			</div>
			
			{{-- Started At --}}
                <!--<div class="flex flex-col gap-2">-->
                <!--    <label for="date-picker" class="font-semibold text-brand-dark">Start Date</label>-->
                <!--    <div class="relative custom-card p-4 flex items-center gap-3 cursor-pointer">-->
                <!--        <img src="{{asset('assets/images/icons/calendar.svg')}}" alt="icon" class="w-6 h-6 shrink-0" />-->
                <!--        <p id="DateTriggerText" class="w-full text-gray-500">Select date</p>-->
                <!--        <input type="text" name="started_at" id="date-picker" class="absolute inset-0 opacity-0 w-full h-full cursor-pointer" required />-->
                <!--    </div>-->
                <!--</div>-->
			{{-- Events/Stores List --}}
                <div class="flex flex-col gap-2 px-5">
                    <label class="font-semibold text-brand-dark">Available Events</label>
                    {{-- START: New Disclaimer Text --}}
                    @php
                        // Prepare the WhatsApp link and message
                        $waMessage = rawurlencode("Halo Admin, saya ingin bertanya tentang penyewaan untuk event lain.");
                        $waUrl = "https://wa.me/628159254791?text=" . $waMessage;
                    @endphp
                    <p style="font-size: 0.875rem; color: #6b7280; margin-top: -0.25rem; margin-bottom: 0.5rem;">
                        Tidak menemukan event yang diinginkan atau ingin menyewa untuk kepentingan lain? 
                        <a href="{{ $waUrl }}" target="_blank" style="color: #ef7c8b; text-decoration: underline; font-weight: 600;">Hubungi Admin via Whatsapp</a> 
                        untuk info lebih lanjut!
                    </p>
                    {{-- END: New Disclaimer Text --}}
                    <div class="flex flex-col gap-4">
                       @forelse ($stores as $store)
                        @php
                            $pivot = $store->products->first()->pivot;
                        
                            $isDisabled = !$pivot->is_open;
                            
                            $statusText = '';
                            $statusColor = '';
                            $isDiscount = false;
                            $discountPrice = 0;
                    
                            $description = strtolower(trim($pivot->description));
                            $storePrice = $pivot->price;

                            // --- START: Corrected Logic ---
                            // First, check if the event is a discount, as this can be active or disabled.
                            if (str_starts_with($description, 'diskon - ')) {
                                $isDiscount = true;
                                sscanf($description, 'diskon - %d', $discountPrice);
                                $statusText = 'DISCOUNT';
                                $statusColor = '#4f46e5'; // A nice, bold indigo for discounts
                            }elseif ($description === '1 left') {
                                $statusText = '1 SLOT LEFT';
                                $statusColor = '#7e22ce'; // Vibrant Purple
                            }
                    
                            // Then, handle the other statuses ONLY if the event is disabled AND not a discount.
                            if ($isDisabled && !$isDiscount) {
                                if ($description === 'passed') {
                                    $statusText = 'PASSED ';
                                    $statusColor = '#15803d'; // Bolder Green
                                } elseif ($description === 'full slot') {
                                    $statusText = 'FULL BOOKED';
                                    $statusColor = '#d97706'; // Bolder Orange/Amber
                                } elseif ($description === 'cancel') {
                                    $statusText = 'CANCELLED';
                                    $statusColor = '#b91c1c'; // Bolder Red
                                }
                            }
                            // --- END: Corrected Logic ---
                        @endphp
                    
                        <label class="custom-card p-4 transition-all duration-300
                                    {{-- An event is only truly unclickable if it's disabled AND not an active discount --}}
                                    @if($isDisabled && !$isDiscount)
                                        event-card-disabled
                                    @else
                                        has-[:checked]:ring-2 has-[:checked]:ring-[#FCCF2F] has-[:checked]:border-transparent cursor-pointer
                                    @endif
                                    ">
                            
                            @if($statusText)
                                <div class="status-stamp" style="background-color: {{ $statusColor }};">
                                    {{ $statusText }}
                                </div>
                            @endif
                    
                            <div class="flex items-center gap-3">
                                <img src="{{asset('assets/images/icons/buildings.svg')}}" alt="icon" class="w-6 h-6 shrink-0" />
                                <div class="flex flex-col gap-1">
                                    <p class="font-semibold text-sm leading-[21px] text-brand-dark">{{$store->name}}</p>
                                    
                                    <div class="flex items-center gap-2">
                                        @if($isDiscount)
                                            <span style="text-decoration: line-through; color: #9ca3af; font-size: 0.75rem;">Rp {{ number_format($storePrice) }}/day</span>
                                            <span class="text-xs font-bold text-brand-dark">Rp {{ number_format($discountPrice) }}/day</span>
                                        @else
                                            <p class="text-xs font-bold text-brand-dark">Rp {{number_format($storePrice)}}/day</p>
                                        @endif
                                    </div>
                                </div>
                    
                                <input type="radio" value="{{$store->id}}" name="store_id"
                                       data-price="{{ $isDiscount ? $discountPrice : $storePrice }}"
                                       data-date="{{ $store->event_date ? $store->event_date->format('Y-m-d') : '' }}"
                                       class="store-option absolute opacity-0"
                                       @if($isDisabled && !$isDiscount) disabled @endif
                                       required />
                            </div>
                        </label>
                    @empty
                        <div class="custom-card p-4 text-center text-gray-500">
                            <p>No available events for this product at the moment.</p>
                        </div>
                    @endforelse
                    </div>
                </div>
			<div id="Bottom-nav"
				class="fixed bottom-0 max-w-[640px] w-full mx-auto border-t border-[#F1F1F1] overflow-hidden z-10">
				<div class="bg-white/50 backdrop-blur-sm absolute w-full h-full"></div>
				<div class="flex items-center justify-between p-5 relative z-10">
					<div class="flex flex-col gap-1 w-fit">
						<p id="Total" class="font-bold text-xl leading-[30px]"></p>
						<p class="text-sm leading-[21px]">Sub total</p>
					</div>
					<button type="submit"
						class="rounded-full p-[12px_24px] bg-[#FCCF2F] font-bold w-fit">Checkout</button>
				</div>
			</div>
		</form>
		{{-- START: TNC Modal - Place this inside <main> before #Bottom-nav --}}

		<div id="tnc-backdrop"
			style="position: fixed;
					inset: 0;
					background-color: rgba(0, 0, 0, 0.75); /* Darker backdrop */
					z-index: 50; /* High z-index */
					display: none;">
		</div>

		<div id="tnc-modal-content"
			style="position: fixed;
					top: 50%;
					left: 50%;
					transform: translate(-50%, -50%);
					width: 90%;
					max-width: 500px; /* Slightly smaller for better fit */
					max-height: 85vh;
					background-color: white;
					border-radius: 1rem;
					box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
					z-index: 51; /* Explicitly higher than the backdrop AND bottom-nav */
					display: none; /* Initially hidden */
					flex-direction: column; /* For internal layout */
					overflow: hidden;">

			{{-- Header --}}
			<div style="padding: 1.5rem; border-bottom: 1px solid #e5e7eb; flex-shrink: 0;">
				<h2 style="font-size: 1.5rem; line-height: 2rem; font-weight: 700; color: #111827;">Terms & Conditions</h2>
				<p style="font-size: 0.875rem; line-height: 1.25rem; color: #6b7280; margin-top: 0.25rem;">Please read and agree to continue.</p>
			</div>

			{{-- Scrollable Body --}}
			<div style="padding: 1.5rem; overflow-y: auto; flex-grow: 1;">
				<div style="display: flex; flex-direction: column; gap: 1rem; color: #374151;">
					
					<h3 style="font-weight: 600; color: #1f2937;">Syarat dan Ketentuan Penyewaan:</h3>
					<ul style="list-style-type: disc; padding-left: 1.25rem; display: flex; flex-direction: column; gap: 0.75rem;">
						<li>
							<strong>Durasi Sewa:</strong>
							<ul style="list-style-type: circle; padding-left: 1.25rem; margin-top: 0.5rem;">
								<li>Tarif sewa berlaku untuk periode 1 (satu) hari.</li>
								<li> Pengembalian dapat dilakukan pada H+1 setelah konser atau langsung di lokasi konser setelah acara selesai.</li>
							</ul>
						</li>
						<li>
							<strong>Pengiriman dan Pengembalian:</strong>
							<ul style="list-style-type: circle; padding-left: 1.25rem; margin-top: 0.5rem;">
								<li>Biaya pengiriman unit ke venue pada hari H acara sudah termasuk dalam harga sewa.</li>
								<li>Pengembalian unit pada H+1 disepakati di sekitar venue, hotel atau stasiun gambir/senen (tidak menerima di Bandara)</li>
								<!--<li>Pengembalian unit pada H+1 disepakati di sekitar venue, hotel atau stasiun gambir/senen (tidak menerima di Bandara)</li>-->
							</ul>
						</li>
						<li>
							<strong>Booking Slot:</strong>
							<ul style="list-style-type: circle; padding-left: 1.25rem; margin-top: 0.5rem;">
								<li>Diperlukan pembayaran booking slot sebesar Rp200.000.</li>
								<li>Apabila penyewa membatalkan secara sepihak sewa-menyewa HANDPHONE sebelum masa sewa-menyewa berlangsung, maka uang muka (DP) yang telah dibayarkan akan dianggap hangus dan tidak dapat dikembalikan.</li>
							</ul>
						</li>
						<li>
							<strong>Jaminan:</strong> Penyewa wajib menyediakan minimal 2 (dua) dokumen jaminan:
							<ul style="list-style-type: circle; padding-left: 1.25rem; margin-top: 0.5rem;">
								<li>Kartu Tanda Penduduk (KTP) (wajib).</li>
								<li>Pilih salah satu: Kartu Mahasiswa/Pelajar/Pegawai, Paspor, SIM</li>
							</ul>
						</li>
						<li>
							<strong>Informasi Kontak:</strong> Penyewa bersedia memberikan nomor handphone, akun media sosial pribadi, serta nomor handphone keluarga inti atau teman terdekat.
						</li>
						<li>
							<strong>Surat Perjanjian Sewa:</strong> 
							<ul style="list-style-type: circle; padding-left: 1.25rem; margin-top: 0.5rem;">
								<li>Penyewa bersedia menandatangani surat pernyataan sewa di atas materai 10.000.</li>
								<li>Apabila Penyewa menyediakan materai secara mandiri untuk keperluan perjanjian, maka tidak akan dikenakan biaya pembelian materai sebesar Rp11.000 (sebelas ribu Rupiah), begitupun sebaliknya.</li>
							</ul>
						</li>
					</ul>

					<h3 style="font-weight: 600; color: #1f2937;">Kelengkapan Sewa:</h3>
					<p>Setiap unit sewa sudah termasuk:</p>
					<ul style="list-style-type: disc; padding-left: 1.25rem; display: flex; flex-direction: column; gap: 0.25rem;">
						<li>1 (satu) unit Handphone.</li>
						<li>1 (satu) unit Powerbank.</li>
						<li>1 (satu) unit Pouch.</li>
						<li>1 (satu) unit Cable Type C.</li>
						<li>1 (satu) unit Flashdisk OTG 128 GB.</li>
						<li>1 (satu) unit  Converter Lighting to USB.</li>

					</ul>

					<h3 style="font-weight: 600; color: #1f2937;">Transfer Data:</h3>
					<ul style="list-style-type: disc; padding-left: 1.25rem; display: flex; flex-direction: column; gap: 0.25rem;">
                        <li>Penyewa dapat memindahkan data sendiri via flashdisk yang disediakan atau dibantu oleh tim via Telegram bila handphone tidak mendukung.</li>
                        <li>Transfer data melalui Google Drive memerlukan waktu 2x24 jam hingga data dapat diakses.</li>
                        
                    </ul>

					<h3 style="font-weight: 600; color: #1f2937;">Ketentuan Lain:</h3>
					<ul style="list-style-type: circle; padding-left: 1.25rem; margin-top: 0.5rem;">
						<li>Akun media sosial seperti instagram dan X, jangan diprivate hingga masa sewa selesai</li>
						<li>Kerusakan HP: Sepenuhnya tanggung jawab Penyewa, termasuk biaya perbaikan.</li>
						<li>Kamera Laser/Sinar Panggung: Kerusakan akibat laser/sinar panggung sepenuhnya tanggung jawab Penyewa</li>
						<li>Dead Pixel/White Dot: Ditemukan dead pixel/white dot setelah HP dikembalikan, kena biaya penggantian.</li>
						<li>Kesalahan pemindahan atau transfer data melalui flashdisk dan lainnya, sepenuhnya tanggung jawab kamu.</li>
					</ul>
					<p>Detail ketentuan tambahan akan diuraikan lebih lanjut dalam surat perjanjian sewa Handphone.</p>
				</div>
			</div>

			{{-- Footer with Button --}}
			<div style="padding: 1.5rem; border-top: 1px solid #e5e7eb; background-color: #f9fafb; text-align: right; flex-shrink: 0;">
				<button id="close-tnc-btn" type="button"
						style="padding: 0.75rem 1.5rem; background-color: #FCCF2F; font-weight: 700; color: black; border: none; border-radius: 9999px; cursor: pointer; transition: transform 0.1s ease;">
					I Understand & Agree
				</button>
			</div>
		</div>

		{{-- END: TNC Modal --}}
	</main>

	<!--<script src="{{asset('customjs/booking.js')}}"></script>-->
	<script>
        document.addEventListener('DOMContentLoaded', function () {
            // --- TNC Modal Logic ---
            const tncModal = document.getElementById('tnc-modal-content');
            const tncBackdrop = document.getElementById('tnc-backdrop');
            const closeTncBtn = document.getElementById('close-tnc-btn');
            const body = document.body;
            
            const bookingForm = document.querySelector('form');
            // Listen for the form submit event
            if (bookingForm) {
                bookingForm.addEventListener('submit', function (e) {
                    const selectedStore = document.querySelector('input[name="store_id"]:checked');
                    const startedAtInput = document.getElementById('started_at'); // Get the hidden input
        
                    if (!selectedStore) {
                        e.preventDefault(); // Stop form submission
                        alert('Please select an available event before proceeding.');
                        return;
                    }
                    
                    // Set the date just before submission (in case the selection event didn't fire)
                    // This relies on your existing logic to determine eventDate
                    const eventDate = selectedStore.getAttribute('data-date');
                    startedAtInput.value = eventDate;
                    
                    // Final check on date required for the backend
                    if (!eventDate) {
                         e.preventDefault(); // Stop form submission
                         alert('The selected event is missing a valid date.');
                         return;
                    }
                    
                    // At this point, the form will submit store_id (from radio) and started_at (from hidden input).
                });
            }
    
            function showTncModal() {
                if (tncBackdrop && tncModal) {
                    tncBackdrop.style.display = 'block';
                    tncModal.style.display = 'flex';
                    body.style.overflow = 'hidden';
                }
            }
    
            function hideTncModal() {
                if (tncBackdrop && tncModal) {
                    tncBackdrop.style.display = 'none';
                    tncModal.style.display = 'none';
                    body.style.overflow = 'auto';
                }
            }
    
            // Show the modal when the page loads
            showTncModal();
            // Add the event listener for the close button
            if (closeTncBtn) {
                closeTncBtn.addEventListener('click', hideTncModal);
            }
    
            // --- Booking Calculation Logic ---
            const minusButton = document.getElementById('Minus');
            const plusButton = document.getElementById('Plus');
            const countDaysElement = document.getElementById('CountDays');
            const durationInput = document.getElementById('duration');
            const totalDisplay = document.getElementById('Total');
            const storeOptions = document.querySelectorAll('.store-option');
            const startedAtInput = document.getElementById('started_at');
    
            function calculateAndUpdateTotal() {
                const duration = parseInt(durationInput.value) || 1;
                let storePrice = 0;
    
                const selectedStore = document.querySelector('input[name="store_id"]:checked');
                if (selectedStore) {
                    storePrice = parseInt(selectedStore.getAttribute('data-price')) || 0;
                    eventDate = selectedStore.getAttribute('data-date');
                }
                
                const subTotal = storePrice * duration;
                totalDisplay.innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(subTotal);
                
                startedAtInput.value = eventDate;
            }
    
            if(minusButton && plusButton && countDaysElement && durationInput) {
                minusButton.addEventListener('click', () => {
                    let currentDays = parseInt(durationInput.value);
                    if (currentDays > 1) {
                        currentDays--;
                        durationInput.value = currentDays;
                        countDaysElement.innerText = currentDays;
                        calculateAndUpdateTotal();
                    }
                });
    
                plusButton.addEventListener('click', () => {
                    let currentDays = parseInt(durationInput.value);
                    currentDays++;
                    durationInput.value = currentDays;
                    countDaysElement.innerText = currentDays;
                    calculateAndUpdateTotal();
                });
            }
    
            storeOptions.forEach(radio => {
                radio.addEventListener('change', calculateAndUpdateTotal);
            });
    
            // --- Flatpickr Logic ---
            // const minDate = '{{ $minDate }}';
            // const disabledDates = @json($disabledDates);
            // const dateTriggerText = document.getElementById('DateTriggerText');
            // const datePickerInput = document.getElementById('date-picker');
    
            // if (datePickerInput) {
            //      flatpickr(datePickerInput, {
            //         minDate: minDate,
            //         disable: disabledDates,
            //         dateFormat: "Y-m-d",
            //         onChange: function(selectedDates, dateStr, instance) {
            //             if (dateStr) {
            //                 dateTriggerText.textContent = dateStr;
            //                 dateTriggerText.classList.add('font-semibold');
            //             } else {
            //                 dateTriggerText.textContent = 'Select date';
            //                 dateTriggerText.classList.remove('font-semibold');
            //             }
            //         }
            //     });
            // }
            
            // Initial calculation on page load
            calculateAndUpdateTotal();
        });
    </script>
@endsection

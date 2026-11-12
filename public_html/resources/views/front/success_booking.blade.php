@extends('front.layouts.app')

@section('title', 'Success Booking for ' . $transaction->product->name)
@section('meta-description', 'Completed your booking for ' . $transaction->product->name)

@section('content')
		<main class="max-w-[640px] mx-auto min-h-screen flex flex-col relative has-[#Bottom-nav]:pb-[144px]">
			<section id="finishBook" class="flex flex-col gap-[30px] max-w-[353px] p-[30px_20px] items-center m-auto">
				<div class="flex flex-col gap-2 items-center">
					<h1 class="text-2xl leading-[36px] font-bold">Finish Booking</h1>
					<p class="leading-[30px] text-[#00000] text-center">Halaman ini perlu discreenshot / dicatat untuk keperluan Booking ID</p>

					<p class="leading-[30px] text-[#6E6E70] text-center">Admin akan segera mengkonfirmasi pesanan.</p>
				</div>
				<div class="w-full h-[220px] flex items-center justify-center flex-shrink-0">
					<img src="{{Storage::url($transaction->product->thumbnail)}}" alt="Thumbnail" class="size-full object-contain" />

				</div>
				<h1 class="text-2xl leading-[20px]">{{ $transaction->product->name }}</h1>

				<div class="custom-card p-5 flex flex-col gap-2 rounded-2xl overflow-hidden outline outline-1 outline-[#E9E8ED] p-4 w-full">
					<p class="font-semibold">Your Booking ID</p>
					<div class="flex items-center gap-3">
						<div class="w-[60px] h-[60px] flex shrink-0">
							<img src="{{asset('assets/images/icons/crown-circle.svg')}}" alt="icon" />
						</div>
						<div class="flex flex-col">
							{{-- Wrapper for Booking ID and copy button --}}
							<div class="flex items-center gap-2 relative">
								<p id="booking-id-text" class="font-semibold text-lg">{{$transaction->trx_id}}</p>
								<button type="button" id="copy-booking-id-btn" title="Copy Booking ID" class="w-5 h-5 text-gray-400 hover:text-gray-800 transition-colors">
									{{-- Make sure you have a copy icon at this path --}}
									<img src="{{asset('assets/images/icons/copy.svg')}}" alt="copy icon" />
								</button>
								{{-- Tooltip for feedback --}}
								<span id="copied-booking-id-tooltip" class="absolute left-full ml-2 hidden whitespace-nowrap text-xs bg-black text-white rounded-md px-2 py-1">Copied!</span>
							</div>
							<p class="text-sm leading-[21px] text-[#6E6E70]">Protect your booking ID</p>
						</div>
					</div>
				</div>
				<div class="w-[220px] flex flex-col gap-3 items-center">
						@php
							// 1. Prepare the raw message string with the dynamic transaction ID.
							//    \n\n creates a line break in the WhatsApp message.
							$rawMessage = "Halo Admin Rental by Yushi's Noona, Saya sudah booking dengan TRXID " . $transaction->trx_id . " ya :)\n\n(Kirimkan screenshot halaman Finish Booking)";

							// 2. URL-encode the entire message to make it safe for a link.
							$whatsappMessage = rawurlencode($rawMessage);

							// 3. Construct the final URL.
							//    IMPORTANT: Replace the phone number here with your actual WhatsApp number.
							$whatsappUrl = "https://wa.me/628159254791?text=" . $whatsappMessage;
						@endphp
						<a href="{{ $whatsappUrl }}"
						target="_blank"
						rel="noopener noreferrer"
						style="width: 100%;
								display: flex;
								align-items: center;
								justify-content: center;
								gap: 8px; /* gap-2 equivalent */
								border-radius: 9999px; /* rounded-full */
								padding: 12px 24px;
								background-color: #25D366; /* The green color */
								font-weight: 700; /* font-bold */
								color: white; /* text-white */
								text-decoration: none;
								transition: background-color 0.2s ease;"
						onmouseover="this.style.backgroundColor='#1DAE54'" {{-- Darker green on hover --}}
						onmouseout="this.style.backgroundColor='#25D366'">

							{{-- SVG Icon --}}
							<svg class="w-6 h-6" fill="currentColor" style="width: 24px; height: 24px;" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
								<path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91C2.13 13.66 2.59 15.35 3.43 16.84L2.05 22L7.32 20.64C8.75 21.4 10.35 21.83 12.04 21.83C17.5 21.83 21.95 17.38 21.95 11.92C21.95 9.27 20.92 6.78 19.05 4.91C17.18 3.04 14.69 2 12.04 2ZM17.44 15.93C17.22 16.29 16.39 16.82 15.91 16.92C15.43 17.02 14.82 17.05 14.32 16.87C13.82 16.69 12.81 16.34 11.76 15.34C10.46 14.12 9.67 12.65 9.49 12.3C9.31 11.95 9.17 11.81 8.94 11.81C8.71 11.81 8.51 11.81 8.33 11.81C8.15 11.81 7.88 11.86 7.65 12.13C7.42 12.4 6.87 12.94 6.87 13.99C6.87 15.04 7.68 15.96 7.82 16.14C7.96 16.32 9.06 17.99 10.73 18.72C12.4 19.45 13.22 19.16 13.73 19.1C14.24 19.04 15.27 18.45 15.62 18.05C15.97 17.65 15.97 17.33 15.92 17.23C15.87 17.13 15.72 17.08 15.49 16.98C15.26 16.88 14.26 16.38 14.04 16.29C13.82 16.2 13.68 16.15 13.53 16.42C13.38 16.69 12.97 17.13 12.82 17.27C12.67 17.41 12.53 17.44 12.35 17.34C12.17 17.24 11.45 17.01 10.61 16.25C9.95 15.63 9.48 14.86 9.36 14.64C9.24 14.42 9.34 14.28 9.46 14.16C9.58 14.04 9.71 13.88 9.83 13.74C9.95 13.6 10.02 13.48 10.12 13.3C10.22 13.12 10.17 13 10.08 12.87C9.99 12.74 9.51 11.53 9.32 11.08C9.13 10.63 8.93 10.69 8.81 10.69H8.33L7.93 10.7C7.58 10.7 7.23 10.84 7.02 11.15C6.81 11.46 6.26 11.98 6.26 12.98C6.26 13.98 7.05 14.87 7.19 15.05C7.33 15.23 8.38 16.86 10.01 17.57C11.64 18.28 12.71 18.21 13.71 17.65C14.02 17.49 14.91 16.92 15.14 16.83C15.53 16.68 15.75 16.65 15.92 16.47C16.25 16.14 16.47 15.98 16.65 15.73C16.83 15.48 16.92 15.23 16.92 14.98C16.92 14.73 16.87 14.51 16.82 14.33C16.77 14.15 16.59 14.02 16.39 13.91C16.19 13.8 15.92 13.74 15.7 13.74C15.48 13.74 15.31 13.77 15.14 13.82C14.97 13.87 14.72 13.95 14.56 14.04C14.4 14.13 14.23 14.23 14.13 14.29C13.82 14.51 13.65 14.69 13.65 15.01C13.65 15.33 13.97 15.61 14.07 15.68C14.27 15.83 15.92 16.63 16.15 16.73C16.54 16.91 16.8 16.93 16.97 17.03C17.14 17.13 17.37 17.4 17.44 15.93Z"/>
							</svg>

							<span>Chat on WhatsApp</span>
						</a>
						{{-- END: WhatsApp Button --}}
					{{-- Updated "Rent More" button --}}
					<a id="rent-more-btn"
					href="{{route('front.index')}}"
					data-action-text="rent another item"
					class="w-full text-center rounded-full p-[12px_24px] bg-[#FCCF2F] font-bold text-black">Rent More</a>

					{{-- Updated "Booking Details" button --}}
					<a id="booking-details-btn"
					href="{{route('front.transactions')}}"
					data-action-text="view your booking details"
					class="w-full text-center rounded-full p-[12px_24px] bg-white font-bold text-black outline outline-1">Booking Details</a>
				</div>
			</section>

			{{-- CONFIRMATION MODAL --}}
			<div id="confirmation-modal" style="position: fixed; inset: 0; z-index: 10000; display: none; align-items: center; justify-content: center; padding: 1rem;">
				{{-- Backdrop --}}
				<div style="position: absolute; inset: 0; background-color: rgba(0, 0, 0, 0.75);"></div>

				{{-- Modal Content --}}
				<div style="position: relative; background-color: white; border-radius: 1rem; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2); width: 100%; max-width: 400px; text-align: center; padding: 2rem;">
					<h2 style="font-size: 1.25rem; line-height: 1.75rem; font-weight: 700; color: #111827;">Confirm Action</h2>
					
					<p id="confirmation-message" style="margin-top: 1rem; color: #4b5563;">Are you sure?</p>

					{{-- Button Group --}}
					<div style="margin-top: 1.5rem; display: flex; gap: 0.75rem; justify-content: center;">
						<button id="confirm-no-btn" type="button"
								style="padding: 0.5rem 1rem; background-color: #e5e7eb; font-weight: 600; color: #1f2937; border: none; border-radius: 9999px; cursor: pointer; min-width: 80px;">
							No
						</button>
						<button id="confirm-yes-btn" type="button"
								style="padding: 0.5rem 1rem; background-color: #FCCF2F; font-weight: 700; color: black; border: none; border-radius: 9999px; cursor: pointer; min-width: 80px;">
							Yes
						</button>
					</div>
				</div>
			</div>
		</main>
		<script>
			// --- SCRIPT FOR BCA COPY BUTTON (from before) ---
			const copyBcaButton = document.getElementById('copy-bca-btn');
			// ... (rest of your existing BCA script) ...
			if (copyBcaButton) {
				// ... (your existing BCA event listener) ...
			}


			// --- NEW SCRIPT FOR BOOKING ID COPY BUTTON ---
			const copyBookingIdButton = document.getElementById('copy-booking-id-btn');
			const bookingIdTextElement = document.getElementById('booking-id-text');
			const copiedBookingIdTooltip = document.getElementById('copied-booking-id-tooltip');

			if (copyBookingIdButton) {
				copyBookingIdButton.addEventListener('click', () => {
					const bookingId = bookingIdTextElement.innerText;

					navigator.clipboard.writeText(bookingId).then(() => {
						// Show the "Copied!" tooltip
						copiedBookingIdTooltip.classList.remove('hidden');

						// Hide the tooltip again after 2 seconds
						setTimeout(() => {
							copiedBookingIdTooltip.classList.add('hidden');
						}, 2000);

					}).catch(err => {
						console.error('Failed to copy booking ID: ', err);
					});
				});
			}
		</script>

		<script>
			// --- Get all the necessary elements ---
			const confirmationModal = document.getElementById('confirmation-modal');
			const confirmationMessage = document.getElementById('confirmation-message');
			const rentMoreBtn = document.getElementById('rent-more-btn');
			const bookingDetailsBtn = document.getElementById('booking-details-btn');
			const confirmYesBtn = document.getElementById('confirm-yes-btn');
			const confirmNoBtn = document.getElementById('confirm-no-btn');
			const bodyForConfirm = document.body;

			let pendingUrl = null; // This will store the URL we want to go to

			// --- Functions to show/hide the confirmation modal ---
			function showConfirmationModal() {
				if (confirmationModal) {
					confirmationModal.style.display = 'flex';
					bodyForConfirm.style.overflow = 'hidden';
				}
			}

			function hideConfirmationModal() {
				if (confirmationModal) {
					confirmationModal.style.display = 'none';
					bodyForConfirm.style.overflow = 'auto';
				}
			}

			// --- Function to handle the click on the original buttons ---
			function handleConfirmationClick(event) {
				event.preventDefault(); // IMPORTANT: This stops the link from navigating immediately
				const link = event.currentTarget;
				pendingUrl = link.href; // Store the URL for later
				const actionText = link.getAttribute('data-action-text'); // Get the custom message text

				// Set the custom message in the popup
				confirmationMessage.textContent = `Are you sure you want to ${actionText}?`;
				
				// Show the popup
				showConfirmationModal();
			}

			// --- Attach Event Listeners ---

			// Listen for clicks on the "Rent More" and "Booking Details" buttons
			if (rentMoreBtn) {
				rentMoreBtn.addEventListener('click', handleConfirmationClick);
			}
			if (bookingDetailsBtn) {
				bookingDetailsBtn.addEventListener('click', handleConfirmationClick);
			}

			// Listen for clicks on the "No" button in the popup
			if (confirmNoBtn) {
				confirmNoBtn.addEventListener('click', () => {
					hideConfirmationModal(); // Just close the modal
					pendingUrl = null; // Clear the stored URL
				});
			}

			// Listen for clicks on the "Yes" button in the popup
			if (confirmYesBtn) {
				confirmYesBtn.addEventListener('click', () => {
					if (pendingUrl) {
						window.location.href = pendingUrl; // Go to the stored URL
					}
					hideConfirmationModal(); // Close the modal
				});
			}
		</script>
@endsection


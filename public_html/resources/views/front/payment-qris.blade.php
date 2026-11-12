@extends('front.layouts.app')

@section('title', 'Scan to Pay - ' . $transaction->trx_id)

@section('content')

{{-- Add the QR Code generator library --}}
@push('before-scripts')
    <script src="https://cdn.jsdelivr.net/npm/davidshimjs-qrcodejs/qrcode.min.js"></script>
@endpush

<main class="max-w-[640px] mx-auto min-h-screen flex flex-col items-center justify-center p-5">
    
    <div class="custom-card w-full max-w-sm text-center p-6 md:p-8">
        <h1 class="text-2xl font-bold text-brand-dark">Scan to Pay</h1>
        <p class="text-gray-500 mt-2 mb-4">Scan QR code di bawah menggunakan e-wallet atau aplikasi mobile banking favorit Anda.</p>

        {{-- This div will hold the scannable QR code image --}}
        <div class="flex justify-center my-6">
            @php
                // Find the URL for 'generate-qr-code' from the Midtrans response
                $qrCodeUrl = '';
                if (isset($midtransResponse->actions)) {
                    foreach ($midtransResponse->actions as $action) {
                        if ($action->name === 'generate-qr-code') {
                            $qrCodeUrl = $action->url;
                            break;
                        }
                    }
                }
            @endphp

            @if ($qrCodeUrl)
                {{-- We now display the QR code image directly from the URL provided by Midtrans --}}
                <img src="{{ $qrCodeUrl }}" alt="QR Code" class="w-[220px] h-[220px] rounded-lg border p-2 bg-white">
            @else
                <p class="text-red-500">Gagal memuat QR Code. Silakan coba lagi.</p>
            @endif
        </div>

        <div class="text-left space-y-3">
            <div class="flex justify-between py-3 border-b border-gray-100">
                <span class="text-gray-500">Jumlah Pembayaran</span>
                <span class="font-bold text-brand-dark">Rp {{ number_format($midtransResponse->gross_amount, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between py-3">
                <span class="text-gray-500">Order ID</span>
                <span class="font-bold text-brand-dark">{{ $transaction->trx_id }}</span>
            </div>
        </div>

        <div class="mt-6">
            <p id="payment-status" class="text-lg font-semibold text-amber-600 transition-colors">Menunggu Pembayaran...</p>
            <p class="text-sm text-gray-400 mt-1">Halaman ini akan otomatis beralih setelah pembayaran berhasil.</p>
        </div>
        
        <div class="w-full bg-gray-200 rounded-full mt-4 overflow-hidden">
            <div id="timer-bar" class="h-2 bg-[#FCCF2F] rounded-full" style="width: 100%; transition: width 5s linear;"></div>
        </div>
    </div>

</main>

{{-- We pass the URLs to JavaScript via a script tag to ensure they are rendered correctly --}}
<script>
    const CHECK_STATUS_URL = "{{ route('front.payment.status', $transaction) }}";
    const SUCCESS_URL = "{{ route('front.success.booking', $transaction->id) }}";
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusElement = document.getElementById('payment-status');
        const timerBar = document.getElementById('timer-bar');
        let totalTime = 600; // 10 minutes in seconds
        let timePassed = 0;

        const intervalId = setInterval(() => {
            fetch(CHECK_STATUS_URL)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'paid') {
                        clearInterval(intervalId);
                        statusElement.textContent = 'Pembayaran Berhasil!';
                        statusElement.classList.remove('text-amber-600');
                        statusElement.classList.add('text-green-600');
                        setTimeout(() => {
                            window.location.href = SUCCESS_URL;
                        }, 1500);
                    }
                })
                .catch(error => {
                    console.error('Error checking payment status:', error);
                });
            
            timePassed += 5;
            let percentRemaining = ((totalTime - timePassed) / totalTime) * 100;
            if (timerBar) {
                timerBar.style.width = percentRemaining + '%';
            }

        }, 5000);

        setTimeout(() => {
            clearInterval(intervalId);
            if (statusElement.textContent.includes('Waiting')) {
                statusElement.textContent = 'Pembayaran kadaluarsa. Silakan coba lagi.';
                statusElement.classList.remove('text-amber-600');
                statusElement.classList.add('text-red-600');
            }
        }, totalTime * 1000);
    });
</script>

@endsection

@extends('front.layouts.app')

{{-- Set the Title and Meta Description for SEO --}}
@section('title', 'Sewa ' . $product->name . ' - ' . $product->category->name)
@section('meta-description', 'Sewa ' . $product->name . ' dengan harga harian terbaik. Lihat spesifikasi lengkap, benefit, dan booking sekarang untuk event atau konser Anda.')

@section('content')

<main class="max-w-[640px] mx-auto min-h-screen flex flex-col relative has-[#Bottom-nav]:pb-[144px]">
    {{-- This wrapper gets the gradient from your app.blade.php --}}

        <div id="Top-navbar" class="flex items-center justify-between px-5 pt-5 absolute top-0 z-20 w-full">
            <a href="{{ str_contains(url()->previous(), 'booking') ? route('front.index') : url()->previous() }}">
                <div class="size-[44px] flex shrink-0 bg-white/80 backdrop-blur-sm rounded-full items-center justify-center">
                    <img src="{{asset('assets/images/icons/arrow-left.svg')}}" alt="icon" />
                </div>
            </a>
            {{-- The title is now part of the content, not fixed at the top --}}
            <button class="size-[44px] flex shrink-0 bg-white/80 backdrop-blur-sm rounded-full items-center justify-center">
                <img src="{{asset('assets/images/icons/more.svg')}}" alt="icon" />
            </button>
        </div>

        {{-- Product Image Gallery --}}
       <section id="Thumbnail" class="flex flex-col relative h-[370px] pt-[94px] pb-[66px] bg-[#F6F6F6]">
            <div class="w-full h-[210px] flex items-center justify-center flex-shrink-0">
                <img id="mainThumbnail" src="{{Storage::url($product->thumbnail)}}" alt="Main view of {{ $product->name }}"
                    class="size-full object-contain" />
            </div>
            
            <div class="flex gap-4 absolute -bottom-[35px] w-full items-center justify-center">
                {{-- Main product thumbnail --}}
                <button class="thumbnail-button size-[70px] flex p-[15px_20px] rounded-full overflow-hidden bg-white flex-shrink-0 ring-2 ring-brand-teal shadow-lg">
                    <img src="{{Storage::url($product->thumbnail)}}" data-src="{{Storage::url($product->thumbnail)}}" alt="Thumbnail of {{ $product->name }}" class="size-full" />
                </button>
        
                {{-- Additional product photos --}}
                @forelse($product->photos as $photo)
                <button class="thumbnail-button size-[70px] flex p-[15px_20px] rounded-full overflow-hidden bg-white flex-shrink-0 ring-1 ring-gray-300 hover:ring-brand-teal transition-all">
                    <img src="{{Storage::url($photo->photo)}}" data-src="{{Storage::url($photo->photo)}}" alt="Additional photo of {{ $product->name }}"
                        class="size-full" />
                </button>
                @empty
                @endforelse
            </div>
        </section>

        {{-- Product Details Section --}}
        <section id="Details" class="flex flex-col mt-[65px] px-5 w-full gap-8">
            {{-- Heading --}}
            <div id="Heading" class="flex items-center justify-between">
                <div class="flex flex-col gap-1">
                    <h1 class="text-2xl leading-snug font-bold text-brand-dark">{{$product->name}}</h1>
                    <p class="text-brand-text-pink-dark font-semibold">{{$product->category->name}}</p>
                </div>
            </div>

            {{-- Specifications --}}
            <div id="About" class="flex flex-col gap-3">
                <h2 class="font-semibold text-lg text-brand-dark">Specifications</h2>
                <div class="space-y-2 text-sm text-gray-700 leading-relaxed">
                    @php
                        $details = preg_split('/\\r\\n|\\r|\\n/', $product->about);
                    @endphp
                    @foreach ($details as $line)
                        @php
                            $cleanedLine = rtrim(str_replace(',', '', $line));
                            if (empty(trim($cleanedLine))) continue;
                            $indentation = strlen($cleanedLine) - strlen(ltrim($cleanedLine));
                            $paddingLeft = $indentation * 0.75;
                            $displayLine = ltrim($cleanedLine);
                            $parts = explode(':', $displayLine, 2);
                        @endphp
                        @if (count($parts) === 2)
                            <div class="flex" style="padding-left: {{ $paddingLeft }}rem;">
                                <span class="w-5 shrink-0">-</span>
                                <p><strong>{{ trim($parts[0]) }}:</strong>{{ trim($parts[1]) }}</p>
                            </div>
                        @else
                            @if ($indentation > 0)
                                <div class="flex" style="padding-left: {{ $paddingLeft }}rem;">
                                    <span class="w-5 shrink-0">-</span>
                                    <p>{{ str_replace('-', '', $displayLine) }}</p>
                                </div>
                            @else
                                <h3 class="font-semibold text-brand-dark pt-3 mt-3 first:mt-0 first:pt-0">{{ $displayLine }}</h3>
                            @endif
                        @endif
                    @endforeach
                </div>
            </div>

            {{-- Benefits Section --}}
            <div id="Benefits" class="flex flex-col gap-3">
                <h2 class="font-semibold text-lg text-brand-dark">Benefits</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div class="custom-card flex p-4 gap-3 items-center">
                        <div class="size-6 flex shrink-0">
                            <img src="{{asset('assets/images/icons/note-favorite.svg')}}" alt="icon" class="size-full" />
                        </div>
                        <p class="text-sm font-semibold text-nowrap text-brand-dark">Original 100%</p>
                    </div>
                    <div class="custom-card flex p-4 gap-3 items-center">
                        <div class="size-6 flex shrink-0">
                            <img src="{{asset('assets/images/icons/dollar-circle.svg')}}" alt="icon" class="size-full" />
                        </div>
                        <p class="text-sm font-semibold text-nowrap text-brand-dark">Accessories</p>
                    </div>
                    <div class="custom-card flex p-4 gap-3 items-center">
                        <div class="size-6 flex shrink-0">
                            <img src="{{asset('assets/images/icons/location.svg')}}" alt="icon" class="size-full" />
                        </div>
                        <p class="text-sm font-semibold text-nowrap text-brand-dark">Full Services</p>
                    </div>
                    <div class="custom-card flex p-4 gap-3 items-center">
                        <div class="size-6 flex shrink-0">
                            <img src="{{asset('assets/images/icons/shield-tick.svg')}}" alt="icon" class="size-full" />
                        </div>
                        <p class="text-sm font-semibold text-nowrap text-brand-dark">Insurances</p>
                    </div>
                </div>
            </div>
        </section>

        
        <div class="h-[120px]"></div>

        {{-- Bottom Navigation / CTA --}}
        <div id="Bottom-nav"
            class="fixed bottom-0 max-w-[640px] w-full mx-auto border-t border-gray-200/80 overflow-hidden z-20">
            <div class="bg-white/80 backdrop-blur-sm absolute w-full h-full"></div>
            <div class="flex items-center justify-between p-5 relative z-10">
                <div class="flex flex-col gap-1 w-fit">
                    {{-- Price can be shown here if needed --}}
                </div>
                <a href="{{route('front.booking', $product->slug)}}" class="rounded-full py-5 px-8 bg-[#FCCF2F] font-bold w-full text-center text-black text-lg shadow-md active:scale-95 transition-transform">Rent Now</a>
            </div>
        </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const mainThumbnail = document.getElementById('mainThumbnail');
        const thumbnailButtons = document.querySelectorAll('.thumbnail-button');

        thumbnailButtons.forEach(button => {
            button.addEventListener('click', () => {
                const newSrc = button.querySelector('img').getAttribute('data-src');

                // Fade out, change src, fade in
                mainThumbnail.style.opacity = 0;
                setTimeout(() => {
                    mainThumbnail.src = newSrc;
                    mainThumbnail.style.opacity = 1;
                }, 300);

                // Update active state styling
                thumbnailButtons.forEach(btn => {
                    btn.classList.remove('ring-2', 'ring-brand-teal', 'shadow-lg');
                    btn.classList.add('ring-1', 'ring-gray-300');
                });
                button.classList.add('ring-2', 'ring-brand-teal', 'shadow-lg');
                button.classList.remove('ring-1', 'ring-gray-300');
            });
        });
    });
</script>

@endsection
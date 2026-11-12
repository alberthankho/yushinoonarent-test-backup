@extends('front.layouts.app')
@section('title', 'Choose Brand for ' . $category->name)
@section('content')

<main class="max-w-[640px] mx-auto min-h-screen flex flex-col relative">
    {{-- This wrapper gets the gradient from your app.blade.php, we just need to control content --}}
    <div class="relative z-10 flex flex-col h-full">

        <div id="Top-navbar" class="flex items-center justify-between px-5 pt-5 w-full">
            <a href="{{ route('front.index') }}">
                <div class="size-[44px] flex shrink-0">
                    <img src="{{asset('assets/images/icons/arrow-left.svg')}}" alt="icon" />
                </div>
            </a>
            <p class="text-lg leading-[27px] font-semibold text-brand-dark">Choose Brand</p>
            <button class="size-[44px] flex shrink-0">
                <img src="{{asset('assets/images/icons/more.svg')}}" alt="icon" />
            </button>
        </div>

        <section id="Brand" class="flex flex-col gap-[30px] mt-[30px] px-5">
            <div id="PhoneBrands" class="grid grid-cols-2 gap-5">

                @forelse($category->brandCategories as $brand)
                {{-- Use the .custom-card class for a consistent look --}}
                <a href="{{route('front.brand', ['category' => $category->slug, 'brand' => $brand->brand->slug])}}" class="custom-card">
                    <div class="p-4 flex items-center justify-center h-28"> {{-- Set a fixed height for consistency --}}
                        <img src="{{Storage::url($brand->brand->logo)}}" alt="{{ $brand->brand->name }} logo" class="w-auto h-16 object-contain" />
                    </div>
                </a>
                @empty
                <p class="text-brand-dark col-span-2 text-center">No brands available for this category yet.</p>
                @endforelse
                
            </div>
        </section>
    </div>
</main>

@endsection
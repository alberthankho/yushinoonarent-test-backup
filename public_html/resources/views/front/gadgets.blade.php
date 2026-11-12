@extends('front.layouts.app')
@section('title', 'Choose Product from ' . $brand->name)
@section('content')

<main class="max-w-[640px] mx-auto min-h-screen flex flex-col relative">
    {{-- This wrapper gets the gradient from your app.blade.php --}}
    <div class="relative z-10 flex flex-col h-full">

        <div id="Top-navbar" class="flex items-center justify-between px-5 pt-5 w-full">
            <a href="{{ route('front.category', $category->slug) }}">
                <div class="size-[44px] flex shrink-0">
                    <img src="{{asset('assets/images/icons/arrow-left.svg')}}" alt="icon" />
                </div>
            </a>
            <p class="text-lg leading-[27px] font-semibold text-brand-dark">Choose Product</p>
            <button class="size-[44px] flex shrink-0">
                <img src="{{asset('assets/images/icons/more.svg')}}" alt="icon" />
            </button>
        </div>

        {{-- Brand Header Card --}}
        <section id="brand" class="custom-card flex p-4 items-center justify-between mt-[30px] mx-5">
            <div class="h-[30px] w-auto flex shrink-0">
                <img src="{{Storage::url($brand->logo)}}" alt="{{ $brand->name }} logo" class="w-full h-full object-contain" />
            </div>
            <div class="flex flex-col items-end gap-1">
                <p class="font-semibold text-brand-dark">{{$brand->name}}</p>
                <p class="text-sm leading-[21px] text-brand-teal font-medium">{{$brand->products->count()}} Products</p>
            </div>
        </section>

        {{-- Product List --}}
        <section id="Explore" class="flex flex-col gap-4 mx-5 mt-[30px] pb-40">
            <h2 class="text-lg leading-[27px] font-semibold text-brand-text-pink-dark">Explore Phones</h2>
            <div class="flex flex-col gap-4">

                @forelse($products as $product)
                {{-- Use the .custom-card class for a consistent look --}}
                <a href="{{route('front.details', $product->slug)}}" class="custom-card flex items-center p-4 gap-4">
                    <div class="w-20 h-20 flex shrink-0 rounded-lg overflow-hidden bg-brand-teal-light items-center justify-center p-2">
                        <img src="{{Storage::url($product->thumbnail)}}" class="h-full w-full object-contain" alt="Thumbnail of {{ $product->name }}" />
                    </div>
                    <div class="w-full flex flex-col gap-1">
                        <p class="font-semibold text-brand-dark">{{$product->name}}</p>
                        {{-- You can add back price or other details here if you like --}}
                    </div>
                </a>
                @empty
                <div class="custom-card p-4 text-center text-gray-500">
                    <p>No products found for {{$brand->name}} in this category.</p>
                </div>
                @endforelse

            </div>
        </section>

    </div>
</main>

@endsection
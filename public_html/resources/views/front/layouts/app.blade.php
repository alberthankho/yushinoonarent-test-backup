<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title')</title>
        {{-- START: Add Favicon Links --}}
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
        {{-- START: Add Flatpickr CSS --}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        {{-- END: Add Flatpickr CSS --}}
        {{-- The generator might also give you a site.webmanifest file, if so, include this line --}}
        {{-- <link rel="manifest" href="{{ asset('site.webmanifest') }}"> --}}
        {{-- END: Favicon Links --}}
        @stack('before-styles')
        <link href="{{asset('main.css')}}" rel="stylesheet" />
        <link href="{{asset('output.css')}}" rel="stylesheet" />
        @stack('after-styles')
		<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />
		<style>
            /* A little helper style for showing/hiding the "Others" text input */
            .hidden-by-default {
                display: none;
            }
        </style>
	</head>
    <body class="bg-brand-gradient">
        @yield('content')

        @stack('before-scripts')
        {{-- START: Add Flatpickr JS --}}
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        {{-- END: Add Flatpickr JS --}}
        
        @stack('after-scripts')
    </body>
</html>
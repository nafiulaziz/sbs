<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Service Booking System') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.ts'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <div id="app">
        <nav class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('home') }}" class="text-xl font-bold text-gray-900">
                            Service Booking
                        </a>
                    </div>
                    <div class="flex items-center space-x-4">
                        <auth-nav></auth-nav>
                    </div>
                </div>
            </div>
        </nav>
        
        <main class="py-8">
            @yield('content')
        </main>
        
        <toast-container></toast-container>
    </div>
</body>
</html>
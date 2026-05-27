<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', "THORNG DY'S SHOP")</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        khmer: ['"Noto Sans Khmer"', '"Kantumruy Pro"', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Khmer:wght@300;400;500;600;700;800&family=Kantumruy+Pro:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"/>

    @stack('styles')
</head>
<body class="bg-gray-50 antialiased min-h-screen" style="font-family:'Noto Sans Khmer','Kantumruy Pro',sans-serif;">

    <main>
        @yield('content')
    </main>

    <script>window.APP_URL = "{{ url('/') }}";</script>
    <script src="{{ asset('js/script.js') }}"></script>
    @stack('scripts')
</body>
</html>

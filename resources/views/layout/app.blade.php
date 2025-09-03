<html>

<head>
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="" />
    <link rel="stylesheet" as="style" onload="this.rel='stylesheet'"
        href="https://fonts.googleapis.com/css2?display=swap&amp;family=Inter%3Awght%40400%3B500%3B700%3B900&amp;family=Noto+Sans%3Awght%40400%3B500%3B700%3B900" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <title>@yield('title')</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    @livewireStyles

    <style type="text/tailwindcss">
        @layer base {
            :root {
                --color-dashboard: #111418;
                --color-background: #f9fafb;
                --color-textColor: #374151;
            }
        }
    </style>
</head>

<body>
    <div class="flex min-h-screen bg-white" style='font-family: Inter, "Noto Sans", sans-serif;'>

        {{-- Sidebar --}}
        @include('layout.sidebar')

        {{-- Main content --}}
        <main class="flex-1 bg-gray-50 flex flex-col">
            {{-- header --}}
            @include('layout.navigation')
            {{-- Page Content --}}
            <div class="flex-1 p-8">
                @yield('content')
            </div>
        </main>
    </div>

    @livewireScripts
</body>

</html>

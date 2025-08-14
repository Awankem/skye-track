<html>

<head>
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="" />
    <link rel="stylesheet" as="style" onload="this.rel='stylesheet'"
        href="https://fonts.googleapis.com/css2?display=swap&amp;family=Inter%3Awght%40400%3B500%3B700%3B900&amp;family=Noto+Sans%3Awght%40400%3B500%3B700%3B900" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <title>@yield('title')</title>
    <link rel="icon" type="image/x-icon" href="data:image/x-icon;base64,">

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <style type="text/tailwindcss">
        @layer base {
            :root {
                /* Primary Palette */
                --color-primary: #4f46e5;
                --color-primary-hover: #4338ca;
                --color-primary-focus: #3730a3;

                /* Secondary Palette */
                --color-secondary: #6b7280;
                --color-secondary-hover: #4b5563;
                --color-secondary-focus: #374151;

                /* Accent Palette */
                --color-accent: #ec4899;
                --color-accent-hover: #db2777;
                --color-accent-focus: #be185d;

                /* Text Colors */
                --color-text-primary: #111827;
                --color-text-secondary: #6b7280;
                --color-text-muted: #9ca3af;
                --color-text-on-primary: #ffffff;

                /* Background Colors */
                --color-background-primary: #ffffff;
                --color-background-secondary: #f9fafb;
                --color-background-tertiary: #f3f4f6;

                /* Border Colors */
                --color-border: #e5e7eb;

                /* Status Colors */
                --color-success: #10b981;
                --color-warning: #f59e0b;
                --color-error: #ef4444;
                --color-info: #3b82f6;

                /* Original Colors from the project */
                --color-dashboard: #111418;
                --color-background: #f1f2f4;
                --color-textColor: #687582;
            }
        }
    </style>

</head>

<body>
    <div class="relative flex size-full min-h-screen flex-col bg-white group/design-root overflow-x-hidden"
        style='font-family: Inter, "Noto Sans", sans-serif;'>
        <div class="layout-container flex h-full grow flex-col">
            <header
                class="flex items-center justify-between whitespace-nowrap border-b border-solid border-b-[#f0f2f4] px-10 py-3">
                <div class="flex items-center gap-4 text-dashboard">
                    <div class="size-4">
                        <svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_6_330)">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M24 0.757355L47.2426 24L24 47.2426L0.757355 24L24 0.757355ZM21 35.7574V12.2426L9.24264 24L21 35.7574Z"
                                    fill="currentColor"></path>
                            </g>
                            <defs>
                                <clipPath id="clip0_6_330">
                                    <rect width="48" height="48" fill="white"></rect>
                                </clipPath>
                            </defs>
                        </svg>
                    </div>
                    <h2 class="text-dashboard text-lg font-bold leading-tight tracking-[-0.015em]">SKYETRACK</h2>
                </div>
                <div class="flex flex-1 justify-end gap-8">
                    <div class="flex items-center gap-9">
                        <a class="text-dashboard text-md font-medium leading-normal" href="{{route('dashboard')}}"><i
                                class="fas fa-tachometer-alt"></i> Dashboard</a>
                        <a class="text-dashboard text-md font-medium leading-normal" href="{{route('intern.index')}}"><i
                                class="fas fa-users"></i> Interns</a>
                        <a class="text-dashboard text-md font-medium leading-normal" href="#"><i
                                class="fas fa-file-alt"></i> Reports</a>
                        <a class="text-dashboard text-md- font-medium leading-normal" href="#"><i
                                class="fas fa-cog"></i>
                            Settings</a>
                    </div>
                    <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10"
                        style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuDiO1QZmOHmmRzvf63w0AbpgFBLEq7b8f2TKIbHaau4xUbnIoQeEUvsECsYQqwHC0guhKJ5-ItsAqEkqOccf_UtLQ4yAxwUtOlqNv9X_3WugeJSvZL9yM2Ifo5_QFkrW-obOH7yZgfk1RTbDWFJcrbARUSmtcdw3QVM4ZRZEm1eIuEWDkpeJlybyTjLfxplScwdvcKvb9zYJSNcr4vGhlZ-Xjc-BdX0skRRub_Xj4_ef-ZM_A-L2BF7ovoLGvmPj4c1yz8dUnI4mMa4");'>
                    </div>
                </div>
            </header>
            @yield('content')
        </div>
    </div>
</body>

</html>

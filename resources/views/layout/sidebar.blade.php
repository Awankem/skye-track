{{-- Sidebar --}}
<aside class="w-64 bg-white border-r border-gray-200 flex flex-col">
    {{-- Logo --}}
    <div class="flex items-center gap-3 px-6 py-6 border-b border-gray-200">
        <div class="w-7 h-7 text-blue-500">
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
        <h2 class="text-gray-900 text-xl font-bold tracking-tight">SKYETRACK</h2>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 px-4 py-6 space-y-3 text-lg">
        <a href="{{route('dashboard')}}"
            class="flex items-center gap-4 px-4 py-3 rounded-lg border text-gray-700 font-medium hover:bg-indigo-50 hover:text-blue-500 transition">
            <i class="fas fa-tachometer-alt w-5"></i> Dashboard
        </a>
        <a href="{{route('intern.index')}}"
            class="flex items-center gap-4 px-4 py-3 rounded-lg border text-gray-700 font-medium hover:bg-indigo-50 hover:text-blue-500 transition">
            <i class="fas fa-users w-5"></i> Interns
        </a>
        <a href="#"
            class="flex items-center gap-4 px-4 py-3 rounded-lg border text-gray-700 font-medium hover:bg-indigo-50 hover:text-blue-500 transition">
            <i class="fas fa-file-alt w-5"></i> Reports
        </a>
        <a href="#"
            class="flex items-center gap-4 px-4 py-3 rounded-lg border text-gray-700 font-medium hover:bg-indigo-50 hover:text-blue-500 transition">
            <i class="fas fa-cog w-5"></i> Settings
        </a>
    </nav>


    {{-- Profile --}}
    <div class="flex items-center gap-3 ml-2 justify-start border-t border-gray-200 px-4 py-6">
        <div class="relative inline-flex items-center justify-center w-10 h-10 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600">
            <span class="font-medium text-gray-600 dark:text-gray-300">A</span>
        </div>

        <div>
            <p class="text-gray-900 font-semibold text-xl">Admin</p>
        </div>
    </div>
</aside>
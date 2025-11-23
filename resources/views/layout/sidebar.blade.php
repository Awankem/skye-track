{{-- Sidebar --}}
<aside class="w-64 bg-gradient-to-b from-gray-50 to-white border-r border-gray-200 flex flex-col shadow-sm">
    {{-- Logo --}}
    <div class="flex items-center gap-3 px-6 py-5 border-b border-gray-200 bg-white">
        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-md">
            <svg class="w-6 h-6 text-white" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
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
        <div>
            <h2 class="text-gray-900 text-xl font-bold tracking-tight">SKYETRACK</h2>
            <p class="text-gray-500 text-xs">Attendance System</p>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 px-3 py-6 space-y-1.5 overflow-y-auto">
        @php
            $currentRoute = request()->route() ? request()->route()->getName() : '';
        @endphp
        
        <a href="{{route('dashboard')}}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all duration-200 group {{ $currentRoute === 'dashboard' ? 'bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-md shadow-blue-500/30' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' }}">
            <i class="fas fa-tachometer-alt w-5 text-center {{ $currentRoute === 'dashboard' ? 'text-white' : 'text-gray-500 group-hover:text-blue-600' }}"></i>
            <span>Dashboard</span>
            @if($currentRoute === 'dashboard')
                <div class="ml-auto w-2 h-2 bg-white rounded-full"></div>
            @endif
        </a>
        
        <a href="{{route('intern.index')}}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all duration-200 group {{ str_starts_with($currentRoute, 'intern.') ? 'bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-md shadow-blue-500/30' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' }}">
            <i class="fas fa-users w-5 text-center {{ str_starts_with($currentRoute, 'intern.') ? 'text-white' : 'text-gray-500 group-hover:text-blue-600' }}"></i>
            <span>Interns</span>
            @if(str_starts_with($currentRoute, 'intern.'))
                <div class="ml-auto w-2 h-2 bg-white rounded-full"></div>
            @endif
        </a>
        
        <a href="{{route('reports.index')}}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all duration-200 group {{ str_starts_with($currentRoute, 'reports.') ? 'bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-md shadow-blue-500/30' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' }}">
            <i class="fas fa-file-alt w-5 text-center {{ str_starts_with($currentRoute, 'reports.') ? 'text-white' : 'text-gray-500 group-hover:text-blue-600' }}"></i>
            <span>Reports</span>
            @if(str_starts_with($currentRoute, 'reports.'))
                <div class="ml-auto w-2 h-2 bg-white rounded-full"></div>
            @endif
        </a>
        
        <a href="{{route('settings.index')}}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all duration-200 group {{ str_starts_with($currentRoute, 'settings.') ? 'bg-gradient-to-r from-blue-500 to-indigo-600 text-white shadow-md shadow-blue-500/30' : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' }}">
            <i class="fas fa-cog w-5 text-center {{ str_starts_with($currentRoute, 'settings.') ? 'text-white' : 'text-gray-500 group-hover:text-blue-600' }}"></i>
            <span>Settings</span>
            @if(str_starts_with($currentRoute, 'settings.'))
                <div class="ml-auto w-2 h-2 bg-white rounded-full"></div>
            @endif
        </a>
    </nav>

    {{-- Profile --}}
    <div class="border-t border-gray-200 bg-white px-4 py-4">
        <div class="flex items-center gap-3 p-3 rounded-xl bg-gradient-to-r from-gray-50 to-gray-100 hover:from-gray-100 hover:to-gray-200 transition-all duration-200 cursor-pointer group">
            <div class="relative inline-flex items-center justify-center w-11 h-11 overflow-hidden bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl shadow-md flex-shrink-0">
                <span class="font-semibold text-white text-sm">
                    @php
                        $name = Auth::user()->name;
                        $words = explode(' ', $name);
                        $initials = '';
                        foreach ($words as $word) {
                            $initials .= strtoupper(substr($word, 0, 1));
                        }
                        echo $initials;
                    @endphp
                </span>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-gray-900 font-semibold text-sm truncate">{{ Auth::user()->name }}</p>
                <p class="text-gray-500 text-xs truncate">{{ Auth::user()->email }}</p>
            </div>
            <i class="fas fa-chevron-right text-gray-400 text-xs group-hover:text-blue-600 transition-colors"></i>
        </div>
    </div>
</aside>

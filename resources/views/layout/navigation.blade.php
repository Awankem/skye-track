{{-- Topbar --}}
<header class="flex items-center justify-between px-6 py-4 border-b border-gray-200 bg-white shadow-sm sticky top-0 z-40">
    {{-- Search --}}
    <div class="flex-1 flex justify-start max-w-2xl">
        {{-- Quick Search --}}
        <div class="mr-4 relative w-full" 
             x-data="{ open: false, search: '', results: [] }" 
             @click.away="open = false">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" 
                       x-model="search" 
                       @input="
                            if (search.length > 0) {
                                open = true;
                                const routes = [
                                    { name: 'Dashboard', url: '{{ route('dashboard') }}', icon: 'fas fa-tachometer-alt', description: 'Main dashboard' },
                                    { name: 'Interns', url: '{{ route('intern.index') }}', icon: 'fas fa-users', description: 'Manage interns' },
                                    { name: 'Reports', url: '{{ route('reports.index') }}', icon: 'fas fa-file-alt', description: 'View reports' },
                                    { name: 'Settings', url: '{{ route('settings.index') }}', icon: 'fas fa-cog', description: 'Application settings' }
                                ];
                                results = routes.filter(route =>
                                    route.name.toLowerCase().includes(search.toLowerCase()) ||
                                    route.description.toLowerCase().includes(search.toLowerCase())
                                ).slice(0, 8);
                            } else {
                                open = false;
                                results = [];
                            }
                        " 
                       @keydown.escape="open = false" 
                       @focus="if (search.length > 0) open = true"
                       placeholder="Search pages and features..."
                       class="w-full pl-12 pr-10 py-3 text-sm font-medium border-2 border-gray-200 rounded-xl bg-gray-50 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 hover:border-gray-300 transition-all duration-200 shadow-sm hover:shadow-md focus:bg-white">

                {{-- Clear Button --}}
                <div x-show="search.length > 0" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     class="absolute inset-y-0 right-0 pr-3 flex items-center">
                    <button @click="search = ''; open = false; results = []"
                        class="p-1.5 text-gray-400 hover:text-gray-600 hover:bg-gray-200 rounded-lg transition-all duration-200">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </div>
            </div>

            {{-- Search Results Dropdown --}}
            <div x-show="open && (results.length > 0 || search.length > 0)"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-1"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-1"
                class="absolute left-0 top-full mt-2 w-full bg-white rounded-xl shadow-2xl border border-gray-200 max-h-96 overflow-y-auto"
                style="z-index: 999999 !important;">

                <div class="py-2" x-show="results.length > 0">
                    <template x-for="result in results" :key="result.url">
                        <a :href="result.url"
                            class="flex items-center px-4 py-3 hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-150 group border-b border-gray-50 last:border-b-0"
                            @click="open = false; search = ''">
                            <div
                                class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-lg flex items-center justify-center group-hover:from-blue-200 group-hover:to-indigo-200 transition-all duration-150">
                                <i :class="result.icon + ' text-blue-600 text-sm'"></i>
                            </div>
                            <div class="ml-3 flex-1">
                                <div class="text-sm font-semibold text-gray-900" x-text="result.name"></div>
                                <div class="text-xs text-gray-500" x-text="result.description"></div>
                            </div>
                            <div class="flex-shrink-0">
                                <i class="fas fa-arrow-right text-gray-400 text-xs group-hover:text-blue-600 group-hover:translate-x-1 transition-all duration-150"></i>
                            </div>
                        </a>
                    </template>
                </div>

                {{-- No Results --}}
                <div x-show="search.length > 0 && results.length === 0" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     class="px-4 py-8 text-center">
                    <div class="text-gray-300 mb-3">
                        <i class="fas fa-search text-3xl"></i>
                    </div>
                    <div class="text-sm text-gray-500">
                        No results found for "<span x-text="search" class="font-semibold text-gray-700"></span>"
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Profile Dropdown --}}
    <div x-data="{ open: false }" class="relative">
        {{-- Trigger --}}
        <button @click="open = !open" 
                class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-gray-50 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            <div class="relative inline-flex items-center justify-center w-10 h-10 overflow-hidden bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl shadow-md">
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
            <div class="hidden md:block text-left">
                <p class="text-gray-900 font-semibold text-sm leading-tight">{{ Auth::user()->name }}</p>
                <p class="text-gray-500 text-xs leading-tight">Administrator</p>
            </div>
            {{-- Dropdown Arrow --}}
            <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" 
                 :class="{ 'rotate-180': open }" 
                 fill="none" 
                 stroke="currentColor" 
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>

        {{-- Dropdown Menu --}}
        <div x-show="open"
             @click.away="open = false"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 translate-y-1 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 translate-y-1 scale-95"
             class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-gray-200 py-2 z-50"
             style="display: none;">
            
            {{-- User Info --}}
            <div class="px-4 py-3 border-b border-gray-100">
                <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
            </div>

            {{-- Menu Items --}}
            <div class="py-1">
                <a href="{{ route('settings.index') }}" 
                   class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-150">
                    <i class="fas fa-cog w-5 text-gray-400"></i>
                    <span>Settings</span>
                </a>
            </div>

            {{-- Logout --}}
            <div class="border-t border-gray-100 pt-1">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" 
                            class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors duration-150">
                        <i class="fas fa-sign-out-alt w-5"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>

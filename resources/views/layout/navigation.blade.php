{{-- Topbar --}}
<header class="flex items-center justify-between px-6 py-4 border-b border-gray-200 bg-white">
    {{-- Search --}}
    <div class="flex-1 flex justify-center">
        {{-- Quick Search --}}
        <div class="mr-4 relative" 
             x-data="{ open: false, search: '', results: [] }" 
             @click.away="open = false">
            <div class="relative">
                <input type="text" 
                       x-model="search" 
                       @input="
                            if (search.length > 0) {
                                open = true;
                                const routes = [
                                    { name: 'Dashboard', url: '{{ route('dashboard') }}', icon: 'fas fa-tachometer-alt', description: 'Main dashboard' },
                                    { name: 'Interns', url: '{{ route('intern.index') }}', icon: 'fas fa-users', description: 'Manage interns' },
                                    { name: 'Reports', url: '#', icon: 'fas fa-file-alt', description: 'View reports' },
                                    { name: 'Settings', url: '#', icon: 'fas fa-cog', description: 'Application settings' }
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
                       class="w-80 px-4 py-2.5 pl-11 text-sm font-medium border-2 border-slate-200/60 rounded-xl bg-white/95 backdrop-blur-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-blue-500/20 focus:border-blue-400 hover:border-slate-300 transition-all duration-300 shadow-sm hover:shadow-md">

                {{-- Clear Button --}}
                <div x-show="search.length > 0" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                    <button @click="search = ''; open = false; results = []"
                        class="p-1 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-full transition-all duration-200">
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
                class="absolute left-0 top-full mt-2 w-80 bg-white rounded-lg shadow-2xl border border-gray-200 max-h-96 overflow-y-auto"
                style="z-index: 999999 !important;">

                <div class="py-2" x-show="results.length > 0">
                    <template x-for="result in results" :key="result.url">
                        <a :href="result.url"
                            class="flex items-center px-4 py-3 hover:bg-blue-50 transition-colors duration-150 group border-b border-gray-50 last:border-b-0"
                            @click="open = false; search = ''">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors duration-150">
                                <i :class="result.icon + ' text-blue-600 text-sm'"></i>
                            </div>
                            <div class="ml-3 flex-1">
                                <div class="text-sm font-medium text-gray-900" x-text="result.name"></div>
                                <div class="text-xs text-gray-500" x-text="result.description"></div>
                            </div>
                            <div class="flex-shrink-0">
                                <i class="fas fa-arrow-right text-gray-400 text-xs group-hover:text-blue-600 transition-colors duration-150"></i>
                            </div>
                        </a>
                    </template>
                </div>

                {{-- No Results --}}
                <div x-show="search.length > 0 && results.length === 0" class="px-4 py-6 text-center">
                    <div class="text-gray-400 mb-2">
                        <i class="fas fa-search text-2xl"></i>
                    </div>
                    <div class="text-sm text-gray-500">
                        No results found for "<span x-text="search" class="font-medium"></span>"
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Profile --}}
    <div class="flex items-center gap-3">
        <div class="relative inline-flex items-center justify-center w-10 h-10 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600">
            <span class="font-medium text-gray-600 dark:text-gray-300">A</span>
        </div>

        <div>
            <p class="text-gray-900 font-semibold text-xl">Admin</p>
        </div>
    </div>
</header>
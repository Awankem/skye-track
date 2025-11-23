<div>
    <div class="px-40 flex flex-1 justify-center py-5">
    <div class="layout-content-container flex flex-col max-w-[1200px] flex-1">
        <x-session-status :status="session('success') ?? session('error')" />
        {{-- Interns --}}
        <div class="flex flex-wrap justify-between gap-3 p-4">
            <p class="text-[#121417] tracking-light text-[32px] font-bold leading-tight min-w-72">Interns</p>
            <button
                class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-8 px-4 bg-blue-599 text-[#121417] text-sm font-medium leading-normal bg-blue-500"
                @click="$dispatch('open-add-intern-modal')">
                <span class="truncate">Add Intern</span>
            </button>
        </div>
        {{-- Search Bar --}}
        <div class="px-4 py-3">
            <label class="flex flex-col min-w-40 h-12 w-full font-medium border-2 border-slate-200/60 rounded-xl bg-white/95 backdrop-blur-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-blue-500/20 focus:border-blue-400 hover:border-slate-300 transition-all duration-300 shadow-sm hover:shadow-md">
                <div class="flex w-full flex-1 items-stretch rounded-xl h-full">
                    <div class="text-textColor flex border-none bg-background items-center justify-center pl-4 rounded-l-xl border-r-0"
                        data-icon="MagnifyingGlass" data-size="24px" data-weight="regular">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor"
                            viewBox="0 0 256 256">
                            <path
                                d="M229.66,218.34l-50.07-50.06a88.11,88.11,0,1,0-11.31,11.31l50.06,50.07a8,8,0,0,0,11.32-11.32ZM40,112a72,72,0,1,1,72,72A72.08,72.08,0,0,1,40,112Z">
                            </path>
                        </svg>
                    </div>
                    <input placeholder="Search interns by name..." type="text" wire:model.live="search"
                        class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121417] focus:outline-0 focus:ring-0 border-none bg-background focus:border-none h-full placeholder:text-textColor px-4 rounded-l-none border-l-0 pl-2 text-base font-normal leading-normal" />
                </div>
            </label>
        </div>
        {{-- Department Dropdown --}}
        <div class="px-4 py-3">
            <label class="flex flex-col min-w-40 h-12 w-full">
                <select wire:model.live="department" class="form-select flex w-full min-w-0 flex-1 rounded-xl text-[#121417] focus:outline-0 focus:ring-0 border2 border-none bg-background focus:border-none h-full placeholder:text-textColor px-4 rounded-l-none border-l-0 pl-2 text-base font-normal leading-normal">
                    <option value="">All Departments</option>
                    @foreach(getDistinctDepartments() as $department)
                        <option value="{{ $department }}">{{ $department }}</option>
                    @endforeach
                </select>
            </label>
        </div>
        {{-- Exports --}}
        <div class="flex justify-stretch">
            <div class="flex flex-1 gap-3 flex-wrap px-4 py-3 justify-end">
                <a href="{{route('interns.export')}}">
                <x-primary-button>
                    Export as CSV
                </x-primary-button>
                </a>
                <a href="{{route('interns.export.pdf')}}">
                    <x-primary-button>
                    Export as PDF
                </x-primary-button>
                </a>
            </div>
        </div>
        {{-- Table Data --}}
        <div class="px-4 py-3 @container" wire:loading.class="opacity-50">
            <div class="flex overflow-hidden rounded-xl border border-[#dde0e4] bg-white">
                <table class="flex-1 border-none overflow-hidden">
                    <thead>
                        <tr class="bg-white">
                            <th
                                class="name px-4 py-3 text-left text-[#121417] w-[400px] text-xl font-bold leading-normal bg-gradient-to-r from-gray-200 to-gray-400">
                                Name</th>
                            <th
                                class="department px-4 py-3 text-left text-[#121417] w-[400px] text-xl font-bold leading-normal bg-gradient-to-r from-gray-300 to-gray-200">
                                Department
                            </th>
                            <th
                                class="email px-4 py-3 text-left text-[#121417] w-[400px] text-xl font-bold leading-normal bg-gradient-to-r from-gray-100 to-gray-300">
                                Email</th>
                            <th
                                class="phone px-4 py-3 text-left text-[#121417] w-[400px] text-xl font-bold leading-normal bg-gradient-to-r from-gray-200 to-gray-400">
                                Phone</th>
                            <th
                                class="status px-4 py-3 text-left text-[#121417] w-60 text-xl font-bold leading-normal bg-gradient-to-r from-gray-100 to-gray-300">
                                Status</th>
                            <th
                                class="action px-4 py-3 text-left text-[#121417] w-60 text-textColor text-xl font-bold leading-normal bg-gradient-to-r from-gray-200 to-gray-400">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($interns as $intern)
                        <tr class="border-t border-t-[#dde0e4]">
                            <td
                                class="name h-[72px] px-4 py-2 w-[400px] text-[#121417] text-lg font-normal leading-normal">
                                {{$intern->name}}
                            </td>
                            <td
                                class="department h-[72px] px-4 py-2 w-[400px] text-textColor text-sm font-normal leading-normal">
                                {{$intern->department}}
                            </td>
                            <td
                                class="email h-[72px] px-4 py-2 w-[400px] text-textColor text-sm font-normal leading-normal">
                                {{$intern->email}}
                            </td>
                            <td
                                class="phone h-[72px] px-4 py-2 w-[400px] text-textColor text-sm font-normal leading-normal">
                                {{ $intern->phone ?? '555-123-4567' }}
                            </td>
                            <td class="status h-[72px] px-4 py-2 w-60 text-sm font-normal leading-normal">
                                @if ($intern->attendances()->where('date', today())->where('status','present')->exists())
                                <div
                                    class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-tl-3xl rounded-br-3xl h-11 w-20 px-4 bg-green-300 text-[#121417] text-sm font-medium leading-normal">
                                    <span class="truncate">Active</span>
                                </div>
                                @else
                                <div
                                    class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-tl-3xl rounded-br-3xl h-11 w-20 px-4 bg-red-300 text-[#121417] text-sm font-medium leading-normal">
                                    <span class="truncate">Inactive</span>
                                </div>
                                @endif
                            </td>
                            <td
                                class="action flex flex-row gap-3 px-5 py-3 text-textColor text-sm font-bold leading-normal tracking-[0.015em]">
                                <button wire:click="editIntern({{ $intern->id }})" class="bg-blue-400 p-2 rounded-xl h-7 w-7 hover:bg-blue-100 transition">
                                    <i class="fas fa-pen text-gray-600"></i>
                                </button>
                                <button wire:click="confirmDelete({{ $intern->id }})" 
                                    class="bg-red-300 items-center p-2 rounded-xl h-7 w-7 hover:bg-red-100 transition">
                                    <i class="fas fa-trash text-black with-3d-shadow"></i>
                                </button>
                                <a href="{{route('intern.show', $intern->id)}}"  class="bg-gray-300 items-center rounded-xl h-5 w-8 hover:bg-gray-100 transition">
                                    <i class="fa fa-eye p-1 pl-2 items-center" aria-hidden="true"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-gray-500">
                                No interns found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if($interns->hasPages())
        <div class="px-4 py-3">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Showing {{ $interns->firstItem() ?? 0 }} to {{ $interns->lastItem() ?? 0 }} of {{ $interns->total() }} results
                </div>
                <div class="flex space-x-2">
                    {{-- Previous Button --}}
                    @if ($interns->onFirstPage())
                        <span class="px-3 py-2 text-sm text-gray-400 bg-gray-200 rounded-md cursor-not-allowed">
                            Previous
                        </span>
                    @else
                        <button wire:click="previousPage" 
                                class="px-3 py-2 text-sm text-white bg-[#3971c5] rounded-md hover:bg-blue-600 transition">
                            Previous
                        </button>
                    @endif

                    {{-- Page Numbers --}}
                    @foreach ($interns->getUrlRange(1, $interns->lastPage()) as $page => $url)
                        @if ($page == $interns->currentPage())
                            <span class="px-3 py-2 text-sm text-white bg-[#3971c5] rounded-md">
                                {{ $page }}
                            </span>
                        @else
                            <button wire:click="gotoPage({{ $page }})" 
                                    class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition">
                                {{ $page }}
                            </button>
                        @endif
                    @endforeach

                    {{-- Next Button --}}
                    @if ($interns->hasMorePages())
                        <button wire:click="nextPage" 
                                class="px-3 py-2 text-sm text-white bg-[#3971c5] rounded-md hover:bg-blue-600 transition">
                            Next
                        </button>
                    @else
                        <span class="px-3 py-2 text-sm text-gray-400 bg-gray-200 rounded-md cursor-not-allowed">
                            Next
                        </span>
                    @endif
                </div>
            </div>
        </div>
        @endif


    {{-- Edit Modal --}}
    @if ($showEditModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center">
        <div class="bg-white rounded-3xl shadow-2xl p-10 max-w-4xl w-full mx-6 transform">
            
            <!-- Header -->
            <div class="relative mb-8 pb-6 border-b-2 border-gray-100">
                <button type="button" 
                    wire:click="$set('showEditModal', false)"
                    class="absolute -right-2 -top-2 w-10 h-10 flex items-center justify-center text-gray-400 hover:text-gray-700 hover:bg-gray-100 rounded-full transition-all duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                
                <div class="flex items-center gap-5">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 via-blue-600 to-indigo-600 rounded-2xl flex items-center justify-center shadow-xl">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 text-3xl">Edit Intern</h3>
                        <p class="text-gray-500 text-base mt-1">Update the intern's information below</p>
                    </div>
                </div>
            </div>
            
            <!-- Form -->
            <form wire:submit.prevent="updateIntern" class="space-y-6">
                
                <!-- Two Column Layout for Name and Email -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div class="group">
                        <label for="edit-name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Full Name <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400 group-focus-within:text-blue-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <input 
                                type="text" 
                                id="edit-name"
                                wire:model="name" 
                                placeholder="e.g., John Doe"
                                class="block w-full pl-12 pr-4 py-3.5 border-2 border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 hover:border-gray-400 transition-all duration-200 text-base">
                        </div>
                        @error('name') 
                            <p class="text-red-600 text-sm mt-2 flex items-center gap-1.5">
                                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    
                    <!-- Email -->
                    <div class="group">
                        <label for="edit-email" class="block text-sm font-semibold text-gray-700 mb-2">
                            Email Address <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400 group-focus-within:text-blue-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input 
                                type="email" 
                                id="edit-email"
                                wire:model="email" 
                                placeholder="e.g., john.doe@company.com"
                                class="block w-full pl-12 pr-4 py-3.5 border-2 border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 hover:border-gray-400 transition-all duration-200 text-base">
                        </div>
                        @error('email') 
                            <p class="text-red-600 text-sm mt-2 flex items-center gap-1.5">
                                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
                
                <!-- Two Column Layout for Department and MAC Address -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Department -->
                    <div class="group">
                        <label for="edit-department" class="block text-sm font-semibold text-gray-700 mb-2">
                            Department <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400 group-focus-within:text-blue-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <select 
                                id="edit-department" 
                                wire:model="departmentEdit"
                                class="block w-full pl-12 pr-12 py-3.5 border-2 border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 hover:border-gray-400 transition-all duration-200 text-base appearance-none bg-white cursor-pointer">
                                <option value="">Select a department</option>
                                @foreach (getDistinctDepartments() as $department)
                                    <option value="{{ $department }}" @if(old('department')==$department) selected @endif>
                                        {{ $department }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </div>
                        @error('department')
                            <p class="text-red-600 text-sm mt-2 flex items-center gap-1.5">
                                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- MAC Address -->
                    <div class="group">
                        <label for="edit-mac" class="block text-sm font-semibold text-gray-700 mb-2">
                            MAC Address
                            <span class="text-gray-400 text-xs font-normal ml-1">(Optional)</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400 group-focus-within:text-blue-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                                </svg>
                            </div>
                            <input 
                                type="text" 
                                id="edit-mac"
                                wire:model="mac_address" 
                                placeholder="e.g., 00:1B:44:11:3A:B7"
                                class="block w-full pl-12 pr-4 py-3.5 border-2 border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 hover:border-gray-400 transition-all duration-200 text-base">
                        </div>
                        @error('mac_address') 
                            <p class="text-red-600 text-sm mt-2 flex items-center gap-1.5">
                                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex justify-end gap-4 mt-10 pt-8 border-t-2 border-gray-100">
                    <button 
                        type="button" 
                        wire:click="$set('showEditModal', false)"
                        class="px-8 py-3 bg-white border-2 border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300 transition-all duration-200 text-base">
                        Cancel
                    </button>
                    <button 
                        type="submit"
                        class="px-8 py-3 bg-gradient-to-r from-blue-600 via-blue-600 to-indigo-600 text-white font-semibold rounded-xl shadow-lg hover:from-blue-700 hover:via-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transform hover:scale-[1.02] transition-all duration-200 text-base inline-flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Update Intern
                    </button>
                </div>
            </form>
        </div>
    </div>
@endif



        {{-- Delete Confirmation Modal --}}
            @if ($confirmingInternDeletion)
                <div class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50">
                    <div class="bg-white rounded-xl shadow-lg p-6 w-[400px]">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">Confirm Deletion</h2>
                        <p class="text-gray-600 mb-6">Are you sure you want to delete this intern? This action cannot be undone.</p>
                        <div class="flex justify-end gap-3">
                            <button wire:click="$set('confirmingInternDeletion', false)" class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">Cancel</button>
                            <button wire:click="deleteIntern" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">Delete</button>
                        </div>
                    </div>
                </div>
            @endif
        {{-- Modal and Scripts inside the main div to keep single root --}}
        @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('add-intern-dialog').showModal();
            });
        </script>
        @endif
    </div>
</div>
</div>

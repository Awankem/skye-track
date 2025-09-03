<div>
    <div class="px-40 flex flex-1 justify-center py-5">
    <div class="layout-content-container flex flex-col max-w-[1200px] flex-1">
        <x-session-status :status="session('success') ?? session('error')" />
        {{-- Interns --}}
        <div class="flex flex-wrap justify-between gap-3 p-4">
            <p class="text-[#121417] tracking-light text-[32px] font-bold leading-tight min-w-72">Interns</p>
            <button
                class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-8 px-4 bg-blue-599 text-[#121417] text-sm font-medium leading-normal bg-blue-500"
                command="show-modal" commandfor="add-intern-dialog">
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
        <div class="px-4 py-3 @container">
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
            <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
                <div class="bg-white p-6 rounded-lg w-1/3">
                    <h2 class="text-2xl font-bold mb-4">Edit Intern</h2>
                    <form wire:submit.prevent="updateIntern">
                        <div class="mb-3">
                            <label>Name</label>
                            <input type="text" wire:model="name" class="border rounded w-full px-3 py-2">
                            @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" wire:model="email" class="border rounded w-full px-3 py-2">
                            @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </div>
                        <div class="mb-3">
                            <label>MAC Address</label>
                            <input type="text" wire:model="mac_address" class="border rounded w-full px-3 py-2">
                            @error('mac_address') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="department" class="text-sm font-medium text-gray-700">
                                Department
                            </label>
                            <select id="department" name="department" wire:model="departmentEdit"
                                class="mt-2 w-full rounded-md border-gray-300 shadow-sm focus:border-[#3971c5] focus:ring-[#3971c5] sm:text-sm">
                                @foreach (getDistinctDepartments() as $department)
                                <option value="{{ $department }}" @if(old('department')==$department) selected
                                    @endif>
                                    {{ $department }}
                                </option>
                                @endforeach
                            </select>
                            @error('department')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end space-x-2">
                            <button type="button" wire:click="$set('showEditModal', false)"
                                class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">Cancel</button>
                            <button type="submit" wire:click="updateIntern"
                                class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Update</button>
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

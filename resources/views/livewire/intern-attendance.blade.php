<div>
    <h2 class="text-[#111418] text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">Attendance Log</h2>
    <div class="flex justify-between gap-2 px-4 py-3">
        {{-- Sorting and filtering UI can be placed here --}}
    </div>
    <div class="px-4 py-3 flex flex-row justify-between gap-3 items-center">
        <div class="flex flex-row gap-2">
            <div class="flex items-center gap-2">
                <input 
                    type="date" 
                    wire:model.lazy="date" 
                    class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500"
                >
                @if($date)
                    <button wire:click="clearFilter" class="text-red-500 text-sm">Clear Filter</button>
                @endif
            </div>
        </div>
        <a href="{{ route('intern.attendance.export', $intern->id) }}"
            class="flex max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-10 bg-[#2789ec] text-white gap-2 text-sm font-bold leading-normal tracking-[0.015em] min-w-0 px-4"
        >
            <div class="text-white" data-icon="DownloadSimple" data-size="20px" data-weight="fill">
                <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" fill="currentColor" viewBox="0 0 256 256">
                    <path
                        d="M82.34,117.66A8,8,0,0,1,88,104h32V40a8,8,0,0,1,16,0v64h32a8,8,0,0,1,5.66,13.66l-40,40a8,8,0,0,1-11.32,0ZM216,144a8,8,0,0,0-8,8v56H48V152a8,8,0,0,0-16,0v56a16,16,0,0,0,16,16H208a16,16,0,0,0,16-16V152A8,8,0,0,0,216,144Z"
                    ></path>
                </svg>
            </div>
            <span class="truncate">Export</span>
        </a>
    </div>

    <div class="px-4 py-3 @container" wire:loading.class="opacity-50">
        <div class="flex overflow-hidden rounded-xl border border-[#dbe0e6] bg-white">
            <table class="flex-1">
                <thead>
                    <tr class="bg-white">
                        <th class="date px-4 py-3 text-left text-[#111418] w-[400px] text-xl font-bold leading-normal bg-gradient-to-r from-gray-200 to-gray-400">Date</th>
                        <th class="status px-4 py-3 text-left text-[#111418] w-[400px] text-xl font-bold leading-normal bg-gradient-to-r from-gray-300 to-gray-200">Status</th>
                        <th class="time-in px-4 py-3 text-left text-[#111418] w-[400px] text-xl font-bold leading-normal bg-gradient-to-r from-gray-100 to-gray-300">Time In</th>
                        <th class="time-out px-4 py-3 text-left text-[#111418] w-[400px] text-xl font-bold leading-normal bg-gradient-to-r from-gray-200 to-gray-400">
                            Time Out
                        </th>
                        <th class="duration px-4 py-3 text-left text-[#111418] w-[400px] text-xl font-bold leading-normal bg-gradient-to-r from-gray-100 to-gray-300">
                            Duration<span>/Hours</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($internAttendance as $attendance)     
                    <tr class="border-t border-t-[#dbe0e6]">
                        <td class="date h-[72px] px-4 py-2 w-[400px] text-[#617589] text-md font-medium leading-normal">
                            {{ ($attendance->date)->format('l, j F Y') }}
                        </td>
                        <td class="status h-[72px] px-4 py-2 w-[400px] text-[#617589] text-sm font-normal leading-normal">{{ $attendance->status }}</td>
                        <td class="time-in h-[72px] px-4 py-2 w-[400px] text-[#617589] text-sm font-normal leading-normal">{{ substr($attendance->sign_in, 11) }}</td>
                        <td class="time-out h-[72px] px-4 py-2 w-[400px] text-[#617589] text-sm font-normal leading-normal">{{ substr($attendance->sign_out, 11) }}</td>
                        <td class="duration h-[72px] px-4 py-2 w-[400px] text-[#617589] text-sm font-normal leading-normal">{{ calculateDuration($attendance->sign_out, $attendance->sign_in) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-gray-500">No attendance records found for this date.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <style>
            @container(max-width:120px){.table-8c03f1c7-002b-4d4f-8e93-6347bc2c2b98-column-100{display: none;}}
            @container(max-width:120px){.status{display: none;}}
            @container(max-width:240px){.time-in{display: none;}}
            @container(max-width:360px){.time-out{display: none;}}
            @container(max-width:480px){.duration{display: none;}}
        </style>
    </div>
    {{-- Pagination --}}
    @if($internAttendance->hasPages())
        <div class="px-4 py-3">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Showing {{ $internAttendance->firstItem() ?? 0 }} to {{ $internAttendance->lastItem() ?? 0 }} of {{ $internAttendance->total() }} results
                </div>
                <div class="flex space-x-2">
                    {{-- Previous Button --}}
                    @if ($internAttendance->onFirstPage())
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
                    @foreach ($internAttendance->getUrlRange(1, $internAttendance->lastPage()) as $page => $url)
                        @if ($page == $internAttendance->currentPage())
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
                    @if ($internAttendance->hasMorePages())
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
</div>

@extends('layout.app')
@section('title', 'Interns')

@section('content')
<div class="px-40 flex flex-1 justify-center py-5">
    <div class="layout-content-container flex flex-col max-w-[1200px] flex-1">
        <x-session-status :status="session('success') ?? session('error')" />
        {{-- Interns --}}
        <div class="flex flex-wrap justify-between gap-3 p-4">
            <p class="text-[#121417] tracking-light text-[32px] font-bold leading-tight min-w-72">Interns</p>
            <button
                class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-8 px-4 bg-[#3971c5] text-[#121417] text-sm font-medium leading-normal"
                command="show-modal" commandfor="dialog">
                <span class="truncate">Add Intern</span>
            </button>
        </div>
        {{-- Search Bar --}}
        <div class="px-4 py-3">
            <label class="flex flex-col min-w-40 h-12 w-full border-[#3971c5] border-2 rounded-md">
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
                    <input placeholder="Search interns"
                        class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121417] focus:outline-0 focus:ring-0 border-none bg-background focus:border-none h-full placeholder:text-textColor px-4 rounded-l-none border-l-0 pl-2 text-base font-normal leading-normal"
                        value="" />
                </div>
            </label>
        </div>
        {{-- All Departments --}}
        <div class="flex gap-3 p-3 flex-wrap pr-4">
            <button class="flex h-8 shrink-0 items-center justify-center gap-x-2 rounded-full bg-background pl-4 pr-2">
                <p class="text-[#121417] text-sm font-medium leading-normal">All Departments</p>
                <div class="text-[#121417]" data-icon="CaretDown" data-size="20px" data-weight="regular">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" fill="currentColor"
                        viewBox="0 0 256 256">
                        <path
                            d="M213.66,101.66l-80,80a8,8,0,0,1-11.32,0l-80-80A8,8,0,0,1,53.66,90.34L128,164.69l74.34-74.35a8,8,0,0,1,11.32,11.32Z">
                        </path>
                    </svg>
                </div>
            </button>
        </div>
        {{-- Exports --}}
        <div class="flex justify-stretch">
            <div class="flex flex-1 gap-3 flex-wrap px-4 py-3 justify-end">
                <x-primary-button>
                    Export as CSV
                </x-primary-button>
                <x-primary-button>
                    Export as PDF
                </x-primary-button>
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
                                class="department px-4 py-3 text-left text-[#121417] w-[400px] text-xk font-bold leading-normal bg-gradient-to-r from-gray-300 to-gray-200">
                                Department
                            </th>
                            <th
                                class="emailpx-4 py-3 text-left text-[#121417] w-[400px] text-xl font-bold leading-normal bg-gradient-to-r from-gray-100 to-gray-300">
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
                        @foreach ($interns as $intern)

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
                                555-123-4567
                            </td>
                            <td class="status h-[72px] px-4 py-2 w-60 text-sm font-normal leading-normal">
                                @if ($intern->attendances()->where('status','present')->exists())
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
                                <a class="bg-blue-400 p-2 rounded-xl h-7 w-7 hover:bg-gray-700 transition">
                                    <i class="fas fa-pen text-gray-600"></i>
                                </a>
                                <a class="bg-red-300 items-center  p-2 rounded-xl h-7 w-7 hover:bg-gray-700 transition">
                                    <i class="fas fa-trash text-black with-3d-shadow"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>





{{-- Modal --}}
<el-dialog>
    <dialog id="dialog" aria-labelledby="dialog-title"
        class="fixed inset-0 size-auto max-h-none max-w-none overflow-y-auto bg-transparent backdrop:bg-transparent">
        <el-dialog-backdrop
            class="fixed inset-0 bg-gray-500/75 transition-opacity data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in">
        </el-dialog-backdrop>

        <div tabindex="0"
            class="flex min-h-full items-end justify-center p-4 text-center focus:outline-none sm:items-center sm:p-0">
            <el-dialog-panel
                class="relative transform overflow-hidden rounded-md bg-white text-left shadow-xl transition-all data-closed:translate-y-4 data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in sm:my-8 sm:w-full sm:max-w-lg data-closed:sm:translate-y-0 data-closed:sm:scale-95">
                <div class="bg-white px-6 pt-6 pb-4 sm:p-8 sm:pb-6">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 id="dialog-title" class="font-semibold text-gray text-3xl">Add New Intern</h3>
                            <form class="mt-6 space-y-6" method="POST" action="{{ route('intern.store') }}">
                                @csrf
                                {{-- Intern Name --}}
                                <div>
                                    <label for="intern-name" class="text-sm font-medium text-gray-700">
                                        Intern Name
                                    </label>
                                    <input type="text" id="intern-name" name="name" value="{{ old('name') }}"
                                        placeholder="Enter intern's full name"
                                        class="mt-2 w-full rounded-md border-gray-300 shadow-sm focus:border-[#3971c5] focus:ring-[#3971c5] sm:text-sm">
                                    @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                {{-- Department --}}
                                <div>
                                    <label for="department" class="text-sm font-medium text-gray-700">
                                        Department
                                    </label>
                                    <select id="department" name="department"
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
                                {{-- Email --}}
                                <div>
                                    <label for="email" class="text-sm font-medium text-gray-700">
                                        Email
                                    </label>
                                    <input type="text" id="email" name="email" value="{{ old('email') }}"
                                        placeholder="Enter email address"
                                        class="mt-2 w-full rounded-md border-gray-300 shadow-sm focus:border-[#3971c5] focus:ring-[#3971c5] sm:text-sm">
                                    @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>


                                {{-- Mac Address --}}
                                <div>
                                    <label for="mac_address" class="block text-sm font-medium text-gray-700">
                                        MAC Address
                                    </label>
                                    <input type="text" id="mac_address" name="mac_address"
                                        value="{{ old('mac_address') }}" placeholder="Enter MAC address"
                                        class="mt-2 w-full rounded-md border-gray-300 shadow-sm focus:border-[#3971c5] focus:ring-[#3971c5] sm:text-sm">
                                    @error('mac_address')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse sm:px-8">
                                    <button type="submit"
                                        class="inline-flex w-full justify-center rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-xs hover:bg-blue-500 sm:ml-3 sm:w-auto">
                                        Save
                                    </button>
                                    <button type="button" command="close" commandfor="dialog"
                                        class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-xs ring-1 ring-gray-300 ring-inset hover:bg-gray-50 sm:mt-0 sm:w-auto">
                                        Cancel
                                    </button>
                                </div>


                            </form>
                        </div>
                    </div>
                </div>

            </el-dialog-panel>
        </div>
    </dialog>
</el-dialog>

@if ($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('dialog').showModal();
            });
</script>
@endif
@endsection
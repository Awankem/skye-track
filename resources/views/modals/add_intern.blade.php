
{{-- Modal --}}
<el-dialog>
    <dialog id="add-intern-dialog" aria-labelledby="add_intern"
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
                                    <button type="button" command="close" commandfor="add-intern-dialog"
                                        class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">
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

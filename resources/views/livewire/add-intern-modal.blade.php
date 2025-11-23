{{-- @if ($showModal)
    <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white p-6 rounded-lg w-1/3">
            <h2 class="text-2xl font-bold mb-4">Add New Intern</h2>
            <form wire:submit.prevent="saveIntern">
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
                    <input type="text" wire:model="macAddress" class="border rounded w-full px-3 py-2">
                    @error('macAddress') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>
                <div class="mb-3">
                    <label for="department" class="text-sm font-medium text-gray-700">
                        Department
                    </label>
                    <select id="department" name="department" wire:model="department"
                        class="mt-2 w-full rounded-md border-gray-300 shadow-sm focus:border-[#3971c5] focus:ring-[#3971c5] sm:text-sm">
                        <option value="">Select Department</option>
                        @foreach ($departments as $department)
                        <option value="{{ $department }}">
                            {{ $department }}
                        </option>
                        @endforeach
                    </select>
                    @error('department')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" wire:click="closeModal"
                        class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">Cancel</button>
                    <button type="submit"
                        class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Save Intern</button>
                </div>
            </form>
        </div>
    </div>
@endif --}}
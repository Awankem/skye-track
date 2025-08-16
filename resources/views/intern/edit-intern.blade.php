@extends('layout.app')
@section('title', 'Edit Intern')
@section('content')
<div class="relative flex size-full min-h-screen flex-col bg-white group/design-root overflow-x-hidden" style='font-family: Inter, "Noto Sans", sans-serif;'>
  <div class="layout-container flex h-full grow flex-col">
    <div class="px-40 flex flex-1 justify-center py-5">
      <div class="layout-content-container flex flex-col w-[512px] max-w-[512px] py-5 max-w-[960px] flex-1">
        <div class="flex flex-wrap justify-between gap-3 p-4">
          <p class="text-[#121417] tracking-light text-[32px] font-bold leading-tight min-w-72">Edit Intern Data</p>
        </div>
        

        {{-- Display success message --}}
        @if (session('success'))
          <div class="alert alert-success mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
          </div>
        @endif
        
        <form action="{{ route('intern.update', $intern->id) }}" method="POST">
          @csrf
          @method('PUT')
          
          <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
            <label class="flex flex-col min-w-40 flex-1">
              <p class="text-[#121417] text-base font-medium leading-normal pb-2">Name</p>
              <input
                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121417] focus:outline-0 focus:ring-0 border border-[#dde0e4] bg-white focus:border-[#dde0e4] h-14 placeholder:text-[#687582] p-[15px] text-base font-normal leading-normal"
                value="{{ old('name', $intern->name) }}"
                name="name"
                type="text"
                required
              />
              @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
            </label>
          </div>
          
          <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
            <label class="flex flex-col min-w-40 flex-1">
              <p class="text-[#121417] text-base font-medium leading-normal pb-2">Department</p>
              <select
                name="department"
                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121417] focus:outline-0 focus:ring-0 border border-[#dde0e4] bg-white focus:border-[#dde0e4] h-14 placeholder:text-[#687582] p-[15px] text-base font-normal leading-normal"
                required
              >
                <option value="">Select Department</option>
                @foreach (getDistinctDepartments() as $department)
                  <option value="{{ $department }}" 
                    @if(old('department', $intern->department) == $department) selected @endif>
                    {{ $department }}
                  </option>
                @endforeach
              </select>
              @error('department')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
            </label>
          </div>
          
          <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
            <label class="flex flex-col min-w-40 flex-1">
              <p class="text-[#121417] text-base font-medium leading-normal pb-2">Email</p>
              <input
                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121417] focus:outline-0 focus:ring-0 border border-[#dde0e4] bg-white focus:border-[#dde0e4] h-14 placeholder:text-[#687582] p-[15px] text-base font-normal leading-normal"
                value="{{ old('email', $intern->email) }}"
                name="email"
                type="email"
                required
              />
              @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
            </label>
          </div>
          
          <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
            <label class="flex flex-col min-w-40 flex-1">
              <p class="text-[#121417] text-base font-medium leading-normal pb-2">Phone</p>
              <input
                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121417] focus:outline-0 focus:ring-0 border border-[#dde0e4] bg-white focus:border-[#dde0e4] h-14 placeholder:text-[#687582] p-[15px] text-base font-normal leading-normal"
                value="{{ old('phone', $intern->phone) }}"
                name="phone"
                type="tel"
              />
              @error('phone')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
            </label>
          </div>
          
          
          <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
            <label class="flex flex-col min-w-40 flex-1">
              <p class="text-[#121417] text-base font-medium leading-normal pb-2">MAC Address</p>
              <input
                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-xl text-[#121417] focus:outline-0 focus:ring-0 border border-[#dde0e4] bg-white focus:border-[#dde0e4] h-14 placeholder:text-[#687582] p-[15px] text-base font-normal leading-normal"
                value="{{ old('mac_address', $intern->mac_address) }}"
                name="mac_address"
                type="text"
                placeholder="00:00:00:00:00:00"
              />
              @error('mac_address')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
              @enderror
            </label>
          </div>
          
          <div class="flex justify-stretch">
            <div class="flex flex-1 gap-3 flex-wrap px-4 py-3 justify-end">
              <a href="{{ route('intern.index') }}"
                class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-10 px-4 bg-[#f1f2f4] text-[#121417] text-sm font-bold leading-normal tracking-[0.015em]"
              >
                <span class="truncate">Cancel</span>
              </a>
              <button type="submit"
                class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-10 px-4 bg-[#c0d6ec] text-[#121417] text-sm font-bold leading-normal tracking-[0.015em]"
              >
                <span class="truncate">Save Changes</span>
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
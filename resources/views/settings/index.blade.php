@extends('layout.app')
@section('title', 'Settings')
@section('content')

<!-- Main container -->
<div class="flex flex-1 w-full justify-center py-5">
    <div class="layout-content-container flex flex-col w-full max-w-[1200px] flex-1">
        
        <!-- Header Section -->
        <div class="flex flex-wrap justify-between gap-3 p-4">
            <div class="flex min-w-72 flex-col gap-3">
                <p class="text-dashboard tracking-light text-[32px] font-bold leading-tight">System Settings</p>
                <p class="text-[#617589] text-sm font-normal leading-normal">
                    Configure system parameters and preferences that affect attendance tracking.
                </p>
            </div>
        </div>

        @if(session('success'))
        <div class="mx-4 mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
        @endif

        @if(session('info'))
        <div class="mx-4 mb-4 p-4 bg-blue-100 border border-blue-400 text-blue-700 rounded-lg">
            <i class="fas fa-info-circle mr-2"></i>{{ session('info') }}
        </div>
        @endif

        <!-- System Statistics -->
        <div class="flex flex-wrap gap-4 p-4">
            <div class="flex min-w-[158px] flex-1 flex-col gap-2 rounded-xl p-6 bg-[#f0f2f4]">
                <p class="text-dashboard text-base font-medium leading-normal">Total Interns</p>
                <p class="text-dashboard tracking-light text-2xl font-bold leading-tight">{{ number_format($totalInterns) }}</p>
            </div>
            <div class="flex min-w-[158px] flex-1 flex-col gap-2 rounded-xl p-6 bg-[#f0f2f4]">
                <p class="text-dashboard text-base font-medium leading-normal">Departments</p>
                <p class="text-dashboard tracking-light text-2xl font-bold leading-tight">{{ number_format($totalDepartments) }}</p>
            </div>
            <div class="flex min-w-[158px] flex-1 flex-col gap-2 rounded-xl p-6 bg-[#f0f2f4]">
                <p class="text-dashboard text-base font-medium leading-normal">Attendance Records</p>
                <p class="text-dashboard tracking-light text-2xl font-bold leading-tight">{{ number_format($totalAttendanceRecords) }}</p>
            </div>
        </div>

        <!-- Late Arrival Threshold Section (Dedicated) -->
        <div class="p-4">
            <div class="flex flex-col gap-4 rounded-xl border-2 border-orange-200 bg-gradient-to-br from-orange-50 to-red-50 p-6 shadow-sm">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-red-500 rounded-xl flex items-center justify-center shadow-md">
                        <i class="fas fa-clock text-white text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-dashboard text-2xl font-bold">Late Arrival Threshold</h2>
                        <p class="text-[#617589] text-sm">Set the time after which attendance is considered late</p>
                    </div>
                </div>
                
                <!-- Current Value Display -->
                <div class="bg-white rounded-lg p-4 border border-orange-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Current Late Threshold</p>
                            <p class="text-3xl font-bold text-gray-900">{{ $lateThreshold }}</p>
                            <p class="text-xs text-gray-500 mt-1">Interns arriving after this time are marked as late</p>
                        </div>
                        <div class="text-right">
                            <div class="inline-flex items-center gap-2 px-4 py-2 bg-orange-100 rounded-lg">
                                <i class="fas fa-exclamation-triangle text-orange-600"></i>
                                <span class="text-sm font-semibold text-orange-700">Active</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit Form -->
                <form method="POST" action="{{ route('settings.update') }}" class="bg-white rounded-lg p-4 border border-orange-200">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-edit mr-2 text-orange-500"></i>Update Late Threshold
                            </label>
                            <input type="time" 
                                   name="late_threshold" 
                                   value="{{ $lateThreshold }}" 
                                   required
                                   class="w-full px-4 py-3 text-lg font-semibold border-2 border-orange-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 bg-white">
                            <p class="text-xs text-gray-500 mt-2 flex items-start gap-1">
                                <i class="fas fa-info-circle text-blue-500 mt-0.5"></i>
                                <span>Interns signing in after this time will be marked as late. Changes take effect immediately for all reports, dashboards, and attendance calculations.</span>
                            </p>
                        </div>
                        <input type="hidden" name="working_hours_start" value="{{ $workingHoursStart }}">
                        <input type="hidden" name="working_hours_end" value="{{ $workingHoursEnd }}">
                        @foreach($workingDays as $day)
                            <input type="hidden" name="working_days[]" value="{{ $day }}">
                        @endforeach
                        <button type="submit" 
                            class="w-full px-6 py-3 bg-gradient-to-r from-orange-500 to-red-500 text-white rounded-lg hover:from-orange-600 hover:to-red-600 transition font-semibold shadow-md hover:shadow-lg">
                            <i class="fas fa-save mr-2"></i>Update Late Threshold
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Settings Forms -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 p-4">
            
            <!-- Working Hours Settings -->
            <div class="flex flex-col gap-4 rounded-xl border border-[#dbe0e6] p-6">
                <div class="flex items-center gap-3 mb-2">
                    <i class="fas fa-clock text-blue-500 text-xl"></i>
                    <h2 class="text-dashboard text-xl font-bold">Working Hours</h2>
                </div>
                <p class="text-[#617589] text-sm mb-4">
                    Configure the standard working hours for attendance tracking.
                </p>
                
                <form method="POST" action="{{ route('settings.update') }}">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Start Time</label>
                            <input type="time" name="working_hours_start" value="{{ $workingHoursStart }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">End Time</label>
                            <input type="time" name="working_hours_end" value="{{ $workingHoursEnd }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <input type="hidden" name="late_threshold" value="{{ $lateThreshold }}">
                        @foreach($workingDays as $day)
                            <input type="hidden" name="working_days[]" value="{{ $day }}">
                        @endforeach
                        <button type="submit" 
                            class="w-full px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-medium">
                            <i class="fas fa-save mr-2"></i>Save Working Hours
                        </button>
                    </div>
                </form>
            </div>

            <!-- Working Days Settings -->
            <div class="flex flex-col gap-4 rounded-xl border border-[#dbe0e6] p-6">
                <div class="flex items-center gap-3 mb-2">
                    <i class="fas fa-calendar-alt text-blue-500 text-xl"></i>
                    <h2 class="text-dashboard text-xl font-bold">Working Days</h2>
                </div>
                <p class="text-[#617589] text-sm mb-4">
                    Select the days of the week when attendance should be tracked.
                </p>
                
                <form method="POST" action="{{ route('settings.update') }}">
                    @csrf
                    <div class="space-y-3">
                        @php
                            $days = ['monday' => 'Monday', 'tuesday' => 'Tuesday', 'wednesday' => 'Wednesday', 
                                     'thursday' => 'Thursday', 'friday' => 'Friday', 'saturday' => 'Saturday', 'sunday' => 'Sunday'];
                        @endphp
                        @foreach($days as $key => $day)
                        <label class="flex items-center gap-3 p-3 rounded-lg border border-gray-200 hover:bg-gray-50 cursor-pointer">
                            <input type="checkbox" name="working_days[]" value="{{ $key }}" 
                                {{ in_array($key, $workingDays) ? 'checked' : '' }}
                                class="w-5 h-5 text-blue-500 border-gray-300 rounded focus:ring-blue-500">
                            <span class="text-sm font-medium text-gray-700">{{ $day }}</span>
                        </label>
                        @endforeach
                        <input type="hidden" name="working_hours_start" value="{{ $workingHoursStart }}">
                        <input type="hidden" name="working_hours_end" value="{{ $workingHoursEnd }}">
                        <input type="hidden" name="late_threshold" value="{{ $lateThreshold }}">
                        <button type="submit" 
                            class="w-full px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-medium mt-4">
                            <i class="fas fa-save mr-2"></i>Save Working Days
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Departments Section -->
        <div class="p-4">
            <div class="flex flex-col gap-4 rounded-xl border border-[#dbe0e6] p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <i class="fas fa-building text-blue-500 text-xl"></i>
                        <h2 class="text-dashboard text-xl font-bold">Departments</h2>
                    </div>
                </div>
                <p class="text-[#617589] text-sm mb-4">
                    Departments are automatically created when interns are added. Current departments in the system:
                </p>
                
                @if($departments->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                    @foreach($departments as $dept)
                    <div class="flex items-center gap-2 px-4 py-3 bg-gray-50 rounded-lg border border-gray-200">
                        <i class="fas fa-folder text-blue-500"></i>
                        <span class="text-sm font-medium text-gray-700">{{ $dept }}</span>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-inbox text-4xl mb-2"></i>
                    <p>No departments found. Departments will appear when interns are added.</p>
                </div>
                @endif
            </div>
        </div>

        <!-- System Information -->
        <div class="p-4">
            <div class="flex flex-col gap-4 rounded-xl border border-[#dbe0e6] p-6">
                <div class="flex items-center gap-3 mb-2">
                    <i class="fas fa-info-circle text-blue-500 text-xl"></i>
                    <h2 class="text-dashboard text-xl font-bold">System Information</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm font-medium text-gray-500 mb-1">Current Working Hours</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $workingHoursStart }} - {{ $workingHoursEnd }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm font-medium text-gray-500 mb-1">Late Threshold</p>
                        <p class="text-lg font-semibold text-gray-900">
                            {{ $lateThreshold }}
                            <span class="text-xs text-gray-500 ml-2">(After this time = Late)</span>
                        </p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm font-medium text-gray-500 mb-1">Working Days</p>
                        <p class="text-lg font-semibold text-gray-900">
                            {{ ucwords(implode(', ', $workingDays)) }}
                        </p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <p class="text-sm font-medium text-gray-500 mb-1">System Status</p>
                        <p class="text-lg font-semibold text-green-600">
                            <i class="fas fa-check-circle mr-2"></i>Active
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


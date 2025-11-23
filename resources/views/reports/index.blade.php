@extends('layout.app')
@section('title', 'Reports')
@section('content')

<!-- Main container -->
<div class="flex flex-1 w-full justify-center py-5">
    <div class="layout-content-container flex flex-col w-full max-w-[1400px] flex-1">
        
        <!-- Header Section -->
        <div class="flex flex-wrap justify-between gap-3 p-4">
            <div class="flex min-w-72 flex-col gap-3">
                <p class="text-dashboard tracking-light text-[32px] font-bold leading-tight">Attendance Reports</p>
                <p class="text-[#617589] text-sm font-normal leading-normal">
                    View and analyze attendance data with detailed reports and statistics.
                </p>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="flex flex-wrap gap-4 p-4">
            <form method="GET" action="{{ route('reports.index') }}" class="flex flex-wrap gap-4 w-full items-end">
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                    <input type="date" name="start_date" value="{{ $startDate }}" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                    <input type="date" name="end_date" value="{{ $endDate }}" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Department</label>
                    <select name="department" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="all" {{ $department === 'all' ? 'selected' : '' }}>All Departments</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept }}" {{ $department === $dept ? 'selected' : '' }}>{{ $dept }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" 
                        class="px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition font-medium">
                        <i class="fas fa-filter mr-2"></i>Filter
                    </button>
                    <a href="{{ route('reports.index') }}" 
                        class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium">
                        <i class="fas fa-redo mr-2"></i>Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Summary Cards -->
        <div class="flex flex-wrap gap-4 p-4">
            <div class="flex min-w-[158px] flex-1 flex-col gap-2 rounded-xl p-6 bg-[#f0f2f4]">
                <p class="text-dashboard text-base font-medium leading-normal">Total Present</p>
                <p class="text-dashboard tracking-light text-2xl font-bold leading-tight">{{ number_format($totalPresent) }}</p>
            </div>
            <div class="flex min-w-[158px] flex-1 flex-col gap-2 rounded-xl p-6 bg-[#f0f2f4]">
                <p class="text-dashboard text-base font-medium leading-normal">Total Absent</p>
                <p class="text-dashboard tracking-light text-2xl font-bold leading-tight">{{ number_format($totalAbsent) }}</p>
            </div>
            <div class="flex min-w-[158px] flex-1 flex-col gap-2 rounded-xl p-6 bg-[#f0f2f4]">
                <p class="text-dashboard text-base font-medium leading-normal">Late Arrivals</p>
                <p class="text-dashboard tracking-light text-2xl font-bold leading-tight">{{ number_format($totalLate) }}</p>
            </div>
            <div class="flex min-w-[158px] flex-1 flex-col gap-2 rounded-xl p-6 bg-[#f0f2f4]">
                <p class="text-dashboard text-base font-medium leading-normal">Attendance Rate</p>
                <p class="text-dashboard tracking-light text-2xl font-bold leading-tight">
                    {{ $totalPresent + $totalAbsent > 0 ? round(($totalPresent / ($totalPresent + $totalAbsent)) * 100, 1) : 0 }}%
                </p>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 p-4">
            <!-- Daily Trend Chart -->
            <div class="flex flex-col gap-2 rounded-xl border border-[#dbe0e6] p-6">
                <p class="text-dashboard text-base font-medium leading-normal mb-4">Daily Attendance Trend</p>
                <div class="chart-wrapper" style="height: 300px;">
                    <canvas id="dailyTrendChart"></canvas>
                </div>
            </div>

            <!-- Department Statistics -->
            <div class="flex flex-col gap-2 rounded-xl border border-[#dbe0e6] p-6">
                <p class="text-dashboard text-base font-medium leading-normal mb-4">Department-wise Attendance</p>
                <div class="chart-wrapper" style="height: 300px;">
                    <canvas id="departmentChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Department Statistics Table -->
        <div class="p-4">
            <h2 class="text-dashboard text-[22px] font-bold leading-tight tracking-[-0.015em] mb-4">
                Department Statistics
            </h2>
            <div class="rounded-xl border border-[#dbe0e6] overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Interns</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Present Days</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Attendance Rate</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($departmentStats as $stat)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $stat['department'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $stat['total'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $stat['present'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $stat['percentage'] }}%</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Attendance Records Table -->
        <div class="p-4">
            <h2 class="text-dashboard text-[22px] font-bold leading-tight tracking-[-0.015em] mb-4">
                Attendance Records
            </h2>
            <div class="rounded-xl border border-[#dbe0e6] overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Intern</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Department</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sign In</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sign Out</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($attendances as $attendance)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ \Carbon\Carbon::parse($attendance->date)->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $attendance->intern->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $attendance->intern->department }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $attendance->status === 'present' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($attendance->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $attendance->sign_in ? \Carbon\Carbon::parse($attendance->sign_in)->format('H:i') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $attendance->sign_out ? \Carbon\Carbon::parse($attendance->sign_out)->format('H:i') : '-' }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                No attendance records found for the selected period.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="mt-4">
                {{ $attendances->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Daily Trend Chart
    const dailyTrendCtx = document.getElementById('dailyTrendChart').getContext('2d');
    const dailyTrendData = {
        labels: {!! json_encode($dailyTrend->pluck('attendance_date')->map(function($date) { return \Carbon\Carbon::parse($date)->format('M d'); })) !!},
        data: {!! json_encode($dailyTrend->pluck('count')) !!}
    };
    
    new Chart(dailyTrendCtx, {
        type: 'line',
        data: {
            labels: dailyTrendData.labels,
            datasets: [{
                label: 'Daily Attendance',
                data: dailyTrendData.data,
                borderColor: '#6366f1',
                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Number of Interns'
                    }
                }
            }
        }
    });

    // Department Chart
    const deptCtx = document.getElementById('departmentChart').getContext('2d');
    const deptData = {
        labels: {!! json_encode($departmentStats->pluck('department')) !!},
        data: {!! json_encode($departmentStats->pluck('present')) !!}
    };
    
    new Chart(deptCtx, {
        type: 'bar',
        data: {
            labels: deptData.labels,
            datasets: [{
                label: 'Present Days',
                data: deptData.data,
                backgroundColor: '#10b981',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Days Present'
                    }
                }
            }
        }
    });
</script>

@endsection



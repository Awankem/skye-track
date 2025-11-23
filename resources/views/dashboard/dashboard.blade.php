@extends('layout.app')
@section('title', 'Dashboard')
@section('content')

<!-- Main container: centers content and ensures full width -->
<div class="flex flex-1 w-full justify-center py-5">
    <!-- Inner container: controls layout width -->
    <div class="layout-content-container flex flex-col w-full max-w-[1400px] flex-1">

        <!-- Header Section -->
        <div class="flex flex-wrap justify-between gap-3 p-4 mb-2">
            <div class="flex min-w-72 flex-col gap-3">
                <p class="text-dashboard tracking-light text-[32px] font-bold leading-tight">Attendance Overview</p>
                <p class="text-[#617589] text-sm font-normal leading-normal">
                    Track and analyze intern attendance patterns in real-time.
                </p>
            </div>
        </div>

        <!-- Summary Cards Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-4 mb-6">
            <!-- Total Interns -->
            <div class="flex items-center gap-4 rounded-xl p-6 bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-100 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex-shrink-0 w-14 h-14 bg-blue-500 rounded-xl flex items-center justify-center">
                    <i class="fas fa-users text-white text-xl"></i>
                </div>
                <div class="flex-1">
                    <p class="text-gray-600 text-sm font-medium mb-1">Total Interns</p>
                    <p class="text-gray-900 text-3xl font-bold">{{ countIntern() }}</p>
                </div>
            </div>

            <!-- Average Daily Attendance -->
            <div class="flex items-center gap-4 rounded-xl p-6 bg-gradient-to-br from-green-50 to-emerald-50 border border-green-100 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex-shrink-0 w-14 h-14 bg-green-500 rounded-xl flex items-center justify-center">
                    <i class="fas fa-chart-line text-white text-xl"></i>
                </div>
                <div class="flex-1">
                    <p class="text-gray-600 text-sm font-medium mb-1">Average Daily Attendance</p>
                    <p class="text-gray-900 text-3xl font-bold">{{ averageDailyAttendance() }}%</p>
                </div>
            </div>

            <!-- Departments Tracked -->
            <div class="flex items-center gap-4 rounded-xl p-6 bg-gradient-to-br from-purple-50 to-violet-50 border border-purple-100 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex-shrink-0 w-14 h-14 bg-purple-500 rounded-xl flex items-center justify-center">
                    <i class="fas fa-building text-white text-xl"></i>
                </div>
                <div class="flex-1">
                    <p class="text-gray-600 text-sm font-medium mb-1">Departments Tracked</p>
                    <p class="text-gray-900 text-3xl font-bold">{{ countDepartmentsTracked() }}</p>
                </div>
            </div>
        </div>

        <!-- Attendance Trend Header -->
        <div class="px-4 mb-4">
            <h2 class="text-dashboard text-[24px] font-bold leading-tight tracking-tight mb-1">Daily Attendance Trend</h2>
            <p class="text-[#617589] text-sm">Last 7 days attendance overview</p>
        </div>

        <!-- Attendance Trend Chart Section -->
        <div class="px-4 mb-8">
            <div class="flex min-w-72 flex-1 flex-col gap-4 rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <!-- Chart Header -->
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-gray-500 text-sm font-medium mb-1">Daily Attendance</h3>
                        <div class="text-gray-900 text-3xl font-bold">{{ averageDailyAttendance() }}%</div>
                        <p class="text-green-600 text-sm font-medium mt-1">
                            <i class="fas fa-arrow-up mr-1"></i>Last 2 Days {{getAttendanceIncrease()}}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-calendar-check text-blue-600 text-lg"></i>
                    </div>
                </div>
                <!-- Chart Canvas -->
                <div class="chart-wrapper mt-4">
                    <canvas id="attendanceChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Departmental Attendance Header -->
        <div class="px-4 mb-4">
            <h2 class="text-dashboard text-[24px] font-bold leading-tight tracking-tight mb-1">Department-wise Attendance</h2>
            <p class="text-[#617589] text-sm">Comprehensive department performance metrics</p>
        </div>

        <!-- Department Attendance Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 px-4 pb-6">
            <!-- Attendance by Department -->
            <div class="flex flex-col gap-4 rounded-xl border border-gray-200 bg-white p-6 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <p class="text-gray-900 text-lg font-semibold">Attendance by Department</p>
                    <i class="fas fa-chart-bar text-blue-500"></i>
                </div>
                @php
                    $deptData = getDepartmentalAttendanceData();
                    $currentWeekPercentage = count($deptData) > 0 ? round(collect($deptData)->avg('width')) : 0;
                @endphp
                <div class="flex items-baseline gap-2">
                    <p class="text-gray-900 text-4xl font-bold">{{ $currentWeekPercentage }}%</p>
                    <p class="text-green-600 text-sm font-medium">{{getAttendanceIncrease()}}</p>
                </div>
                <p class="text-gray-500 text-xs">Current Week Average</p>

                <!-- Progress bars per department -->
                <div class="grid gap-4 py-4">
                    @foreach ($deptData as $department)
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <p class="text-gray-700 text-sm font-semibold">{{ $department['name'] }}</p>
                            <p class="text-gray-600 text-xs">{{ round($department['width']) }}%</p>
                        </div>
                        <div class="relative h-3 bg-gray-100 rounded-full overflow-hidden group">
                            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-3 rounded-full transition-all duration-500" 
                                 style="width: {{ $department['width'] }}%;"></div>
                            <span class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-max px-3 py-1.5 bg-gray-900 text-white text-xs rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 shadow-lg z-10">
                                {{ $department['present'] }}/{{ $department['total'] }} interns ({{ round($department['width']) }}%)
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Today's Attendance by Department -->
            <div class="flex flex-col gap-4 rounded-xl border border-gray-200 bg-white p-6 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <p class="text-gray-900 text-lg font-semibold">Today's Attendance</p>
                    <i class="fas fa-calendar-day text-green-500"></i>
                </div>
                <div class="chart-wrapper" style="height: 300px;">
                    <canvas id="todayAttendanceChart"></canvas>
                </div>
            </div>

            <!-- Weekly Attendance Chart -->
            <div class="flex flex-col gap-4 rounded-xl border border-gray-200 bg-white p-6 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <p class="text-gray-900 text-lg font-semibold">Weekly Attendance</p>
                    <i class="fas fa-chart-area text-purple-500"></i>
                </div>
                <p class="text-gray-500 text-xs">Last 4 Weeks Trend</p>
                <div class="chart-wrapper" style="height: 300px;">
                    <canvas id="weeklyAttendanceChart"></canvas>
                </div>
            </div>

            <!-- Attendance Breakdown -->
            <div class="flex flex-col gap-4 rounded-xl border border-gray-200 bg-white p-6 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <p class="text-gray-900 text-lg font-semibold">Attendance Breakdown</p>
                    <i class="fas fa-chart-pie text-orange-500"></i>
                </div>
                <p class="text-gray-500 text-xs">Today's Status Distribution</p>
                <div class="chart-wrapper" style="height: 280px;">
                    <canvas id="attendanceBreakdownChart"></canvas>
                </div>
            </div>

            <!-- Late Comers by Department -->
            <div class="flex flex-col gap-4 rounded-xl border border-gray-200 bg-white p-6 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between">
                    <p class="text-gray-900 text-lg font-semibold">Late Arrivals</p>
                    <i class="fas fa-clock text-red-500"></i>
                </div>
                <p class="text-gray-500 text-xs">By Department Today</p>
                <div class="chart-wrapper" style="height: 280px;">
                    <canvas id="lateComersChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Script and Styles -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    .chart-header {
        margin-bottom: 20px;
    }

    .chart-title {
        font-size: 14px;
        color: #6b7280;
        margin: 0 0 8px 0;
        font-weight: 500;
    }

    .chart-value {
        font-size: 32px;
        font-weight: 700;
        color: #111827;
        margin: 0 0 4px 0;
    }

    .chart-subtitle {
        font-size: 12px;
        color: #10b981;
        margin: 0;
        font-weight: 500;
    }

    .chart-wrapper {
        position: relative;
        height: 300px;
    }
</style>
<script>
    // Chart.js configuration for Daily Attendance
    const attendanceCtx = document.getElementById('attendanceChart').getContext('2d');
    const trendData = {!! getDailyAttendanceTrendData() !!};
    new Chart(attendanceCtx, {
        type: 'line',
        data: {
            labels: trendData.labels,
            datasets: [{
                label: 'Daily Attendance',
                data: trendData.data,
                borderColor: '#6366f1',
                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                borderWidth: 3,
                fill: true,
                borderCapStyle: 'round',
                tension: 0.4,
                pointRadius: 5,
                pointHoverRadius: 7,
                pointBackgroundColor: '#6366f1',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleFont: {
                        size: 14,
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 13
                    },
                    cornerRadius: 8,
                    displayColors: false
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Day of the Week',
                        font: {
                            size: 12,
                            weight: '600'
                        },
                        color: '#6b7280'
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    title: {
                        display: true,
                        text: 'Number of Interns Present',
                        font: {
                            size: 12,
                            weight: '600'
                        },
                        color: '#6b7280'
                    }
                }
            }
        }
    });

    // Today's Attendance by Department (Bar Chart)
    const todayAttendanceCtx = document.getElementById('todayAttendanceChart').getContext('2d');
    const todayDeptData = {!! getTodayDepartmentalChartData() !!};
    new Chart(todayAttendanceCtx, {
        type: 'bar',
        data: {
            labels: todayDeptData.labels,
            datasets: todayDeptData.datasets.map(dataset => ({
                ...dataset,
                borderRadius: 8,
                borderSkipped: false,
            }))
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        font: {
                            size: 12
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    cornerRadius: 8
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Department',
                        font: {
                            size: 12,
                            weight: '600'
                        },
                        color: '#6b7280'
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    title: {
                        display: true,
                        text: 'Number of Interns',
                        font: {
                            size: 12,
                            weight: '600'
                        },
                        color: '#6b7280'
                    }
                }
            }
        }
    });

    // Weekly Attendance (Line Chart)
    const weeklyAttendanceCtx = document.getElementById('weeklyAttendanceChart').getContext('2d');
    const chartData = {!! getWeeklyAttendanceFor4Weeks() !!};
    const maxValue = Math.max(...chartData.data, 100);
    new Chart(weeklyAttendanceCtx, {
        type: 'line',
        data: {
            labels: chartData.labels,
            datasets: [{
                label: 'Weekly Avg. Attendance',
                data: chartData.data,
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointRadius: 5,
                pointHoverRadius: 7,
                pointBackgroundColor: '#10b981',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            return 'Attendance: ' + context.parsed.y + '%';
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Week',
                        font: {
                            size: 12,
                            weight: '600'
                        },
                        color: '#6b7280'
                    }
                },
                y: {
                    beginAtZero: true,
                    max: Math.max(100, Math.ceil(maxValue / 10) * 10),
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    title: {
                        display: true,
                        text: 'Average Attendance (%)',
                        font: {
                            size: 12,
                            weight: '600'
                        },
                        color: '#6b7280'
                    }
                }
            }
        }
    });

    // Attendance Breakdown (Doughnut Chart)
    const breakdownCtx = document.getElementById('attendanceBreakdownChart').getContext('2d');
    const breakdownData = {!! getPresentAbsentLateData() !!};
    new Chart(breakdownCtx, {
        type: 'doughnut',
        data: {
            labels: breakdownData.labels,
            datasets: [{
                data: breakdownData.data,
                backgroundColor: ['#10b981', '#ef4444', '#f97316'],
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        font: {
                            size: 12
                        },
                        usePointStyle: true
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    cornerRadius: 8
                }
            },
            cutout: '60%'
        }
    });

    // Late Comers by Department (Horizontal Bar Chart)
    const lateComersCtx = document.getElementById('lateComersChart').getContext('2d');
    const lateComersData = {!! getLateComersByDepartment() !!};
    new Chart(lateComersCtx, {
        type: 'bar',
        data: {
            labels: lateComersData.labels,
            datasets: [{
                label: 'Late Comers',
                data: lateComersData.data,
                backgroundColor: '#f97316',
                borderRadius: 6,
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    cornerRadius: 8
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    title: {
                        display: true,
                        text: 'Number of Late Comers',
                        font: {
                            size: 12,
                            weight: '600'
                        },
                        color: '#6b7280'
                    }
                },
                y: {
                    grid: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Department',
                        font: {
                            size: 12,
                            weight: '600'
                        },
                        color: '#6b7280'
                    }
                }
            }
        }
    });
</script>
@endsection

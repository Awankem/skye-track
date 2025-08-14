@extends('layout.app')
@section('title', 'Dashboard')
@section('content')

<!-- Main container: centers content and ensures full width -->
<div class="flex flex-1 w-full justify-center py-5">
    <!-- Inner container: controls layout width -->
    <div class="layout-content-container flex flex-col w-full max-w-[1200px] flex-1">

        <!-- Header Section -->
        <div class="flex flex-wrap justify-between gap-3 p-4">
            <div class="flex min-w-72 flex-col gap-3">
                <p class="text-dashboard tracking-light text-[32px] font-bold leading-tight"> Attendance Overview</p>
                <p class="text-[#617589] text-sm font-normal leading-normal">
                    Track and analyze intern attendance patterns.
                </p>
            </div>
        </div>

        <!-- Summary Cards Section -->
        <div class="flex flex-wrap gap-4 p-4">
            <!-- Total Interns -->
            <div class="flex min-w-[158px] flex-1 flex-col gap-2 rounded-xl p-6 bg-[#f0f2f4]">
                <p class="text-dashboard text-base font-medium leading-normal">Total Interns</p>
                <p class="text-dashboard tracking-light text-2xl font-bold leading-tight">{{ countIntern() }}</p>
            </div>

            <!-- Average Daily Attendance -->
            <div class="flex min-w-[158px] flex-1 flex-col gap-2 rounded-xl p-6 bg-[#f0f2f4]">
                <p class="text-dashboard text-base font-medium leading-normal">Average Daily Attendance</p>
                <p class="text-dashboard tracking-light text-2xl font-bold leading-tight">{{ averageDailyAttendance()
                    }}%</p>
            </div>

            <!-- Departments Tracked -->
            <div class="flex min-w-[158px] flex-1 flex-col gap-2 rounded-xl p-6 bg-[#f0f2f4]">
                <p class="text-dashboard text-base font-medium leading-normal">Departments Tracked</p>
                <p class="text-dashboard tracking-light text-2xl font-bold leading-tight">{{ countDepartmentsTracked()
                    }}</p>
            </div>
        </div>

        <!-- Attendance Trend Header -->
        <h2 class="text-dashboard text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">
            Daily Attendance Trend
        </h2>

        <!-- Attendance Trend Chart Section -->
        <div class="flex flex-wrap gap-4 px-4 py-6">
            <div class="flex min-w-72 flex-1 flex-col gap-2 rounded-xl border border-[#dbe0e6] p-6">
                <!-- Chart Header -->
                <div class="chart-header">
                    <h3 class="chart-title">Daily Attendance</h3>
                    <div class="chart-value">85%</div>
                    <p class="chart-subtitle">Last 2 Days {{getAttendanceIncrease()}}</p>
                </div>
                <!-- Chart Canvas -->
                <div class="chart-wrapper">
                    <canvas id="attendanceChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Departmental Attendance Header -->
        <h2 class="text-dashboard text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">
            Department-wise Attendance
        </h2>

        <!-- Department Attendance Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 px-4 py-6">
            <!-- Attendance by Department -->
            <div class="flex flex-col gap-2 rounded-xl border border-[#dbe0e6] p-6">
                <p class="text-dashboard text-base font-medium leading-normal">Attendance by Department</p>
                <p class="text-dashboard tracking-light text-[32px] font-bold leading-tight truncate">95%</p>
                <div class="flex gap-1">
                    <p class="text-[#617589] text-base font-normal">Current Week</p>
                    <p class="text-[#078838] text-base font-medium">+2%</p>
                </div>

                <!-- Progress bars per department -->
                <div class="grid min-h-[180px] gap-x-4 gap-y-6 grid-cols-[auto_1fr] items-center py-3">
                    @foreach (getDepartmentalAttendanceData() as $department)
                    <p class="text-[#617589] text-[13px] font-bold">{{ $department['name'] }}</p>
                    <div class="relative h-2 bg-[#f0f2f4] rounded-full group">
                        <div class="bg-[#6366f1] h-2 rounded-full" style="width: {{ $department['present'] }};"></div>
                        <span
                            class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-max px-2 py-1 bg-gray-800 text-white text-xs rounded-md opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            {{ $department['present'] }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Today's Attendance by Department -->
            <div class="flex flex-col gap-2 rounded-xl border border-[#dbe0e6] p-6">
                <p class="text-dashboard text-base font-medium leading-normal">Today's Attendance</p>
                <div class="chart-wrapper" style="height: 300px;">
                    <canvas id="todayAttendanceChart"></canvas>
                </div>
            </div>

            <!-- Weekly Attendance Chart -->
            <div class="flex flex-col gap-2 rounded-xl border border-[#dbe0e6] p-6">
                <p class="text-dashboard text-base font-medium leading-normal">Weekly Attendance (Last 4 Weeks)</p>
                <div class="chart-wrapper" style="height: 300px;">
                    <canvas id="weeklyAttendanceChart"></canvas>
                </div>
            </div>

            <!-- Attendance Breakdown -->
            <div class="flex flex-col gap-2 rounded-xl border border-[#dbe0e6] p-6">
                <p class="text-dashboard text-base font-medium leading-normal">Attendance Breakdown</p>
                <div class="chart-wrapper" style="height: 250px;">
                    <canvas id="attendanceBreakdownChart"></canvas>
                </div>
            </div>

            <!-- Late Comers by Department -->
            <div class="flex flex-col gap-2 rounded-xl border border-[#dbe0e6] p-6">
                <p class="text-dashboard text-base font-medium leading-normal">Late Comers by Department</p>
                <div class="chart-wrapper" style="height: 250px;">
                    <canvas id="lateComersChart"></canvas>
                </div>
            </div>

            <!-- Placeholder for another chart -->
            <div class="flex flex-col gap-2 rounded-xl border border-[#dbe0e6] p-6 justify-center items-center">
                <p class="text-dashboard text-base font-medium leading-normal">Future Chart</p>
                <p class="text-[#617589] text-sm">This is a placeholder for a future chart.</p>
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
                    borderColor: '#838388FF',
                    backgroundColor: 'rgba(99, 102, 241, 0.1)',
                    borderWidth: 4,
                    fill: true,
                    fillColor: 'rgba(99, 102, 241, 0.1)',
                    borderCapStyle: 'round',
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
                    x: {
                        title: {
                            display: true,
                            text: 'Day of the Week'
                        },
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Interns Present'
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
                datasets: todayDeptData.datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Department'
                        }
                    },
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

        // Weekly Attendance (Line Chart)
        const weeklyAttendanceCtx = document.getElementById('weeklyAttendanceChart').getContext('2d');
        new Chart(weeklyAttendanceCtx, {
            type: 'line',
            data: {
                labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                datasets: [{
                    label: 'Weekly Avg. Attendance',
                    data: [92, 94, 91, 95],
                    borderColor: '#10b981',
                    tension: 0.4,
                    fill: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Week'
                        }
                    },
                    y: {
                        min: 80,
                        max: 100,
                        title: {
                            display: true,
                            text: 'Average Attendance (%)'
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
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
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
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Late Comers'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Department'
                        }
                    }
                }
            }
        });
</script>
@endsection

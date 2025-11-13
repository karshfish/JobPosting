@extends('employer.layouts.app')

@section('content')
<div class="py-6 space-y-6">

    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Dashboard Analysis</h1>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

        {{-- Doughnut: Applications Status --}}
        <div class="bg-white dark:bg-slate-800 p-4 rounded-lg shadow max-h-80">
            <h2 class="text-sm font-semibold mb-2 text-gray-900 dark:text-white">Applications Status</h2>
            <canvas id="statusChart" class="w-full max-h-48"></canvas>
        </div>

        {{-- Line: Applications Trend --}}
        <div class="bg-white dark:bg-slate-800 p-4 rounded-lg shadow">
            <h2 class="text-sm font-semibold mb-2 text-gray-900 dark:text-white">Applications Trend</h2>
            <canvas id="trendChart" class="w-full h-40"></canvas>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

        {{-- Mini Sparkline: Users Trend --}}
        <div class="bg-white dark:bg-slate-800 p-4 rounded-lg shadow">
            <h2 class="text-sm font-semibold mb-2 text-gray-900 dark:text-white">New Users Trend</h2>
            <canvas id="usersChart" class="w-full h-40"></canvas>
        </div>

       {{-- Bar Chart: Top Jobs --}}
        <div class="bg-white dark:bg-slate-800 p-4 rounded-lg shadow">
            <h2 class="text-sm font-semibold mb-2 text-gray-900 dark:text-white">Top Jobs by Applications</h2>
            <canvas id="topJobsChart" class="w-full h-40"></canvas>
        </div>

    </div>
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // 1️⃣ Applications Status Doughnut
    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'accepted', 'Rejected'],
            datasets: [{
                data: [{{ $applicationsPending }}, {{ $applicationsaccepted }}, {{ $applicationsRejected }}],
                backgroundColor: ['#FBBF24', '#10B981', '#EF4444'],
                borderWidth: 1
            }]
        },
        options: { responsive: true, animation: { duration: 1200 }, plugins: { legend: { position: 'bottom' } } }
    });

    // 2️⃣ Applications Trend Line
    new Chart(document.getElementById('trendChart'), {
        type: 'line',
        data: {
            labels: @json($months),
            datasets: [{
                label: 'Applications',
                data: @json($applicationsPerMonth),
                fill: true,
                backgroundColor: 'rgba(59, 130, 246, 0.2)',
                borderColor: '#3B82F6',
                tension: 0.4
            }]
        },
        options: { responsive: true, animation: { duration: 1200 }, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
    });

    // 3️⃣ Users Trend Mini Sparkline
    new Chart(document.getElementById('usersChart'), {
        type: 'line',
        data: {
            labels: @json($months),
            datasets: [{
                data: @json($usersPerMonth),
                borderColor: '#F59E0B',
                fill: true,
                backgroundColor: 'rgba(245,158,11,0.2)',
                tension: 0.3,
                pointRadius: 3
            }]
        },
        options: { responsive: true, animation: { duration: 1000 }, plugins: { legend: { display: false } }, scales: { x: { display: true }, y: { beginAtZero: true } } }
    });

    new Chart(document.getElementById('topJobsChart'), {
        type: 'bar', // Vertical bar chart
        data: {
            labels: [
                @foreach($topJobs as $job)
                    "{{ $job->title }}",
                @endforeach
            ],
            datasets: [{
                label: 'Applications',
                data: [
                    @foreach($topJobs as $job)
                        {{ $job->applications_count }},
                    @endforeach
                ],
                backgroundColor: '#3B82F6'
            }]
        },
        options: {
            responsive: true,
            animation: { duration: 1000 },
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } },
                x: { ticks: { autoSkip: false } } // ensures all job titles show
            }
        }
    });
});
</script>
@endsection

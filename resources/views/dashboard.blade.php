@extends('layouts.my_app')

@section('title', 'DAMS | Attachment Dashboard')

@section('styles')
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    /* Custom scrollbar */
    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
    ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    
    /* Card hover effects */
    .stat-card { transition: all 0.3s ease; }
    .stat-card:hover { transform: translateY(-2px); box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1); }
    
    /* Map container */
    #studentMap { height: 320px; width: 100%; border-radius: 16px; z-index: 1; }
    
    /* Recent items hover */
    .recent-item { transition: all 0.2s ease; border-left: 3px solid transparent; }
    .recent-item:hover { background-color: #f8fafc; border-left-color: #3b82f6; transform: translateX(4px); }
    
    /* Chart container */
    .chart-container { position: relative; height: 200px; width: 100%; }
    
    /* Ensure all cards have the same height */
    .equal-height { display: flex; flex-direction: column; height: 100%; }
    .equal-height .card-content { flex: 1; }
</style>
@endsection

@section('content')
<div class="flex h-screen bg-slate-50">
    <!-- Main Content -->
    <div class="flex-1 overflow-y-auto">
        <!-- Header -->
        <div class="sticky top-0 z-10 bg-white border-b border-slate-200 px-8 py-4">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">Attachment Dashboard</h1>
                    <p class="text-sm text-slate-500 mt-1">Real-time supervision & placement metrics</p>
                </div>
               
            </div>
        </div>


        <!-- Main Content Area -->
        <div class="p-8">
            <!-- Stats Cards Row 1 -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="stat-card bg-gradient-to-br from-blue-600 to-blue-400 text-white rounded-2xl p-6 shadow-lg">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-blue-100">Total Students</p>
                            <h2 class="text-3xl font-bold mt-2">{{ number_format($totalStudents) }}</h2>
                            <p class="text-xs text-blue-100 mt-4 flex items-center gap-1">
                                <i class="fas fa-map-pin text-xs"></i>
                                {{ $studentLocations->count() }} placed in companies
                            </p>
                        </div>
                        <div class="bg-white/20 rounded-xl p-3">
                            <i class="fas fa-user-graduate text-2xl"></i>
                        </div>
                    </div>
                </div>

                <div class="stat-card bg-gradient-to-br from-emerald-600 to-emerald-400 text-white rounded-2xl p-6 shadow-lg">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-emerald-100">Daily Reports</p>
                            <h2 class="text-3xl font-bold mt-2">{{ number_format($totalDailyReports) }}</h2>
                            <p class="text-xs text-emerald-100 mt-4 flex items-center gap-1">
                                <i class="fas fa-chart-line text-xs"></i>
                                {{ $recentDailyReports->count() }} recent
                            </p>
                        </div>
                        <div class="bg-white/20 rounded-xl p-3">
                            <i class="fas fa-book-open text-2xl"></i>
                        </div>
                    </div>
                </div>

                <div class="stat-card bg-gradient-to-br from-amber-600 to-amber-400 text-white rounded-2xl p-6 shadow-lg">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-amber-100">Weekly Reports</p>
                            <h2 class="text-3xl font-bold mt-2">{{ number_format($totalWeeklyReports) }}</h2>
                            <p class="text-xs text-amber-100 mt-4 flex items-center gap-1">
                                <i class="fas fa-calendar-week text-xs"></i>
                                This week
                            </p>
                        </div>
                        <div class="bg-white/20 rounded-xl p-3">
                            <i class="fas fa-calendar-alt text-2xl"></i>
                        </div>
                    </div>
                </div>

                <div class="stat-card bg-gradient-to-br from-purple-600 to-purple-400 text-white rounded-2xl p-6 shadow-lg">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-purple-100">Industrial Supervisors</p>
                            <h2 class="text-3xl font-bold mt-2">{{ number_format($totalIndustrialSupervisors) }}</h2>
                            <p class="text-xs text-purple-100 mt-4 flex items-center gap-1">
                                <i class="fas fa-user-check text-xs"></i>
                                {{ $supervisorStats['active'] }} active in field
                            </p>
                        </div>
                        <div class="bg-white/20 rounded-xl p-3">
                            <i class="fas fa-hard-hat text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards Row 2 -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="stat-card bg-gradient-to-br from-rose-600 to-rose-400 text-white rounded-2xl p-6 shadow-lg">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-rose-100">Assessments</p>
                            <h2 class="text-3xl font-bold mt-2">{{ number_format($totalAssessments) }}</h2>
                            <p class="text-xs text-rose-100 mt-4 flex items-center gap-1">
                                <i class="fas fa-star text-xs"></i>
                                Completed evaluations
                            </p>
                        </div>
                        <div class="bg-white/20 rounded-xl p-3">
                            <i class="fas fa-clipboard-check text-2xl"></i>
                        </div>
                    </div>
                </div>

                <div class="stat-card bg-gradient-to-br from-cyan-600 to-cyan-400 text-white rounded-2xl p-6 shadow-lg">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-cyan-100">Total Users</p>
                            <h2 class="text-3xl font-bold mt-2">{{ number_format($totalUsers) }}</h2>
                            <p class="text-xs text-cyan-100 mt-4 flex items-center gap-1">
                                <i class="fas fa-users text-xs"></i>
                                System accounts
                            </p>
                        </div>
                        <div class="bg-white/20 rounded-xl p-3">
                            <i class="fas fa-users text-2xl"></i>
                        </div>
                    </div>
                </div>

                <div class="stat-card bg-gradient-to-br from-indigo-600 to-indigo-400 text-white rounded-2xl p-6 shadow-lg">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-indigo-100">Lecturers</p>
                            <h2 class="text-3xl font-bold mt-2">{{ number_format($totalLecturers) }}</h2>
                            <p class="text-xs text-indigo-100 mt-4 flex items-center gap-1">
                                <i class="fas fa-chalkboard-teacher text-xs"></i>
                                Academic supervisors
                            </p>
                        </div>
                        <div class="bg-white/20 rounded-xl p-3">
                            <i class="fas fa-chalkboard-teacher text-2xl"></i>
                        </div>
                    </div>
                </div>

                <div class="stat-card bg-gradient-to-br from-teal-600 to-teal-400 text-white rounded-2xl p-6 shadow-lg">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-teal-100">Companies</p>
                            <h2 class="text-3xl font-bold mt-2">{{ number_format($totalCompanies) }}</h2>
                            <p class="text-xs text-teal-100 mt-4 flex items-center gap-1">
                                <i class="fas fa-building text-xs"></i>
                                Partner organizations
                            </p>
                        </div>
                        <div class="bg-white/20 rounded-xl p-3">
                            <i class="fas fa-building text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards Row 3 - Final Reports -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="stat-card bg-gradient-to-br from-orange-600 to-orange-400 text-white rounded-2xl p-6 shadow-lg md:col-start-2">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-orange-100">Final Reports</p>
                            <h2 class="text-3xl font-bold mt-2">{{ number_format($totalFinalReports ?? 0) }}</h2>
                            <p class="text-xs text-orange-100 mt-4 flex items-center gap-1">
                                <i class="fas fa-file-alt text-xs"></i>
                                Completed submissions
                            </p>
                        </div>
                        <div class="bg-white/20 rounded-xl p-3">
                            <i class="fas fa-file-alt text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Grid - 4 columns for consistent card sizing -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                <!-- Activity Trends - Full Width (spans all 4 columns) -->
                <div class="lg:col-span-4 bg-white rounded-2xl shadow-sm p-6 border border-slate-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-semibold text-slate-700 flex items-center gap-2">
                            <i class="fas fa-chart-line text-emerald-500"></i>
                            Activity Trends {{ $currentYear }}
                        </h3>
                        <div class="flex gap-3">
                            <span class="flex items-center gap-1 text-xs px-3 py-1 bg-blue-50 text-blue-600 rounded-full">
                                <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                                Daily
                            </span>
                            <span class="flex items-center gap-1 text-xs px-3 py-1 bg-amber-50 text-amber-600 rounded-full">
                                <span class="w-2 h-2 bg-amber-500 rounded-full"></span>
                                Weekly
                            </span>
                            <span class="flex items-center gap-1 text-xs px-3 py-1 bg-orange-50 text-orange-600 rounded-full">
                                <span class="w-2 h-2 bg-orange-500 rounded-full"></span>
                                Final Reports
                            </span>
                        </div>
                    </div>
                    <div class="chart-container">
                        <canvas id="activityLineChart"></canvas>
                    </div>
                </div>

                <!-- Quick Stats - spans 2 columns -->
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm p-6 border border-slate-100">
                    <h3 class="font-semibold text-slate-700 flex items-center gap-2 mb-6">
                        <i class="fas fa-chart-bar text-blue-500"></i>
                        Quick Statistics
                    </h3>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between items-center p-3 bg-slate-50 rounded-xl">
                            <span class="text-sm text-slate-600 flex items-center gap-2">
                                <i class="fas fa-file-alt text-emerald-500"></i>
                                Final Reports
                            </span>
                            <span class="font-semibold text-emerald-600">{{ number_format($totalFinalReports ?? 0) }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center p-3 bg-slate-50 rounded-xl">
                            <span class="text-sm text-slate-600 flex items-center gap-2">
                                <i class="fas fa-tasks text-amber-500"></i>
                                Ongoing Attachments
                            </span>
                            <span class="font-semibold text-amber-600">{{ number_format($attachmentStats['ongoing']) }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center p-3 bg-slate-50 rounded-xl">
                            <span class="text-sm text-slate-600 flex items-center gap-2">
                                <i class="fas fa-check-circle text-green-500"></i>
                                Completed Attachments
                            </span>
                            <span class="font-semibold text-green-600">{{ number_format($attachmentStats['completed']) }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center p-3 bg-slate-50 rounded-xl">
                            <span class="text-sm text-slate-600 flex items-center gap-2">
                                <i class="fas fa-hourglass-half text-blue-500"></i>
                                Pending Assignment
                            </span>
                            <span class="font-semibold text-blue-600">{{ number_format($attachmentStats['pending']) }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center p-3 bg-slate-50 rounded-xl">
                            <span class="text-sm text-slate-600 flex items-center gap-2">
                                <i class="fas fa-map-marker-alt text-purple-500"></i>
                                Active Towns
                            </span>
                            <span class="font-semibold text-purple-600">{{ number_format($totalTowns) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Recent Daily Reports - 1 column -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-slate-100">
                    <h3 class="font-semibold text-slate-700 flex items-center gap-2 mb-4">
                        <i class="fas fa-clock text-blue-500"></i>
                        Recent Daily Reports
                        <span class="text-xs bg-blue-100 text-blue-600 px-2 py-1 rounded-full ml-2">
                            {{ $recentDailyReports->count() }}
                        </span>
                    </h3>
                    <div class="space-y-2 max-h-80 overflow-y-auto pr-2">
                        @forelse($recentDailyReports as $report)
                        <div class="recent-item p-3 bg-slate-50 rounded-xl">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <p class="font-medium text-sm">{{ $report->student_name }}</p>
                                    <p class="text-xs text-slate-500 mt-1 flex items-center gap-1">
                                        <i class="far fa-clock"></i>
                                        {{ $report->created_at->diffForHumans() }}
                                    </p>
                                </div>
                                <span class="text-xs bg-emerald-100 text-emerald-600 px-2 py-1 rounded-full">Daily</span>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8">
                            <i class="fas fa-file-alt text-slate-300 text-4xl mb-3"></i>
                            <p class="text-sm text-slate-500">No recent daily reports</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Weekly Reports - 1 column -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-slate-100">
                    <h3 class="font-semibold text-slate-700 flex items-center gap-2 mb-4">
                        <i class="fas fa-calendar-alt text-purple-500"></i>
                        Recent Weekly Reports
                        <span class="text-xs bg-purple-100 text-purple-600 px-2 py-1 rounded-full ml-2">
                            {{ $recentWeeklyReports->count() }}
                        </span>
                    </h3>
                    <div class="space-y-2 max-h-80 overflow-y-auto pr-2">
                        @forelse($recentWeeklyReports as $report)
                        <div class="recent-item p-3 bg-slate-50 rounded-xl">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <p class="font-medium text-sm">{{ $report->student_name }}</p>
                                    <p class="text-xs text-slate-500 mt-1 flex items-center gap-1">
                                        <i class="far fa-calendar"></i>
                                        {{ $report->created_at->format('M d, Y') }}
                                    </p>
                                </div>
                                <span class="text-xs bg-purple-100 text-purple-600 px-2 py-1 rounded-full">Weekly</span>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8">
                            <i class="fas fa-calendar-alt text-slate-300 text-4xl mb-3"></i>
                            <p class="text-sm text-slate-500">No recent weekly reports</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Final Reports - 1 column -->
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-slate-100">
                    <h3 class="font-semibold text-slate-700 flex items-center gap-2 mb-4">
                        <i class="fas fa-file-alt text-orange-500"></i>
                        Recent Final Reports
                        <span class="text-xs bg-orange-100 text-orange-600 px-2 py-1 rounded-full ml-2">
                            {{ $recentFinalReports->count() }}
                        </span>
                    </h3>
                    <div class="space-y-2 max-h-80 overflow-y-auto pr-2">
                        @forelse($recentFinalReports as $report)
                        <div class="recent-item p-3 bg-slate-50 rounded-xl">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <p class="font-medium text-sm">{{ $report->student_name }}</p>
                                    <p class="text-xs text-slate-500 mt-1 flex items-center gap-1">
                                        <i class="far fa-calendar"></i>
                                        {{ $report->created_at ? \Carbon\Carbon::parse($report->created_at)->format('M d, Y') : 'N/A' }}
                                    </p>
                                </div>
                                <span class="text-xs bg-orange-100 text-orange-600 px-2 py-1 rounded-full">Final</span>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8">
                            <i class="fas fa-file-alt text-slate-300 text-4xl mb-3"></i>
                            <p class="text-sm text-slate-500">No recent final reports</p>
                            <p class="text-xs text-slate-400 mt-1">Total: {{ number_format($totalFinalReports ?? 0) }}</p>
                        </div>
                        @endforelse
                    </div>
                </div>
<!-- Recent Assessments -->
<div class="bg-white rounded-2xl shadow-sm p-6 border border-slate-100">
    <h3 class="font-semibold text-slate-700 flex items-center gap-2 mb-4">
        <i class="fas fa-clipboard-check text-rose-500"></i>
        Recent Assessments
        <span class="text-xs bg-rose-100 text-rose-600 px-2 py-1 rounded-full ml-2">
            {{ $recentAssessments->count() }}
        </span>
    </h3>
    <div class="space-y-2 max-h-80 overflow-y-auto pr-2">
        @forelse($recentAssessments as $assessment)
        <div class="recent-item p-3 bg-slate-50 rounded-xl">
            <div class="flex justify-between items-start">
                <div class="flex-1">
                    <p class="font-medium text-sm">{{ $assessment->student_name }}</p>
                    <p class="text-xs text-slate-500 mt-1 flex items-center gap-1">
                        <i class="far fa-calendar"></i>
                        {{ $assessment->created_at ? \Carbon\Carbon::parse($assessment->created_at)->format('M d, Y') : 'N/A' }}
                    </p>
                    @if(isset($assessment->assessment_name) && $assessment->assessment_name)
                    <p class="text-xs text-slate-400 mt-1">{{ Str::limit($assessment->assessment_name, 25) }}</p>
                    @elseif(isset($assessment->score) && $assessment->score)
                    <p class="text-xs text-slate-400 mt-1">Score: {{ $assessment->score }}</p>
                    @else
                    <p class="text-xs text-slate-400 mt-1">Assessment #{{ $assessment->id }}</p>
                    @endif
                </div>
                <div class="flex flex-col items-end gap-1">
                    @if(isset($assessment->score) && $assessment->score)
                    <span class="text-xs bg-rose-100 text-rose-600 px-2 py-1 rounded-full">
                        {{ $assessment->score }}
                    </span>
                    @else
                    <span class="text-xs bg-rose-100 text-rose-600 px-2 py-1 rounded-full">
                        {{ $assessment->grade ?? 'Complete' }}
                    </span>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-8">
            <i class="fas fa-clipboard-check text-slate-300 text-4xl mb-3"></i>
            <p class="text-sm text-slate-500">No recent assessments</p>
            <p class="text-xs text-slate-400 mt-1">Total: {{ number_format($totalAssessments ?? 0) }}</p>
        </div>
        @endforelse
    </div>
</div>
<!-- Top Companies - Now spans 1 column like other cards -->
<div class="bg-white rounded-2xl shadow-sm p-6 border border-slate-100">
    <h3 class="font-semibold text-slate-700 flex items-center gap-2 mb-4">
                        <i class="fas fa-trophy text-amber-500"></i>
                        Top Companies
                        <span class="text-xs bg-amber-100 text-amber-600 px-2 py-1 rounded-full ml-2">
                            {{ $topCompanies->count() }} active
                        </span>
                    </h3>
    <div class="space-y-2 max-h-80 overflow-y-auto pr-2">
        @forelse($topCompanies as $company)
        <div class="recent-item p-3 bg-slate-50 rounded-xl hover:bg-slate-100 transition">
            <div class="flex justify-between items-start">
                <div class="flex-1 min-w-0">
                    <p class="font-medium text-sm truncate">{{ $company->name }}</p>
                    <p class="text-xs text-slate-500 mt-1 flex items-center gap-1">
                        <i class="fas fa-map-marker-alt text-xs flex-shrink-0"></i>
                        <span class="truncate">{{ $company->town_name }}</span>
                    </p>
                </div>
                <div class="flex items-center gap-2 ml-2 flex-shrink-0">
                    <span class="text-sm font-semibold text-emerald-600">{{ $company->students_count }}</span>
                    <span class="text-xs text-slate-400">students</span>
                </div>
            </div>
        </div>
        @empty
        <p class="text-sm text-slate-500 text-center py-8">No companies yet</p>
        @endforelse
    </div>
</div>
           

<script>
    function openReportModal() {
        document.getElementById('reportModal').classList.remove('hidden');
        document.getElementById('reportModal').classList.add('flex');
    }
    
    function closeReportModal() {
        document.getElementById('reportModal').classList.add('hidden');
        document.getElementById('reportModal').classList.remove('flex');
    }
    
    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        const modal = document.getElementById('reportModal');
        if (event.target === modal) {
            closeReportModal();
        }
    });
</script>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ==================== ACTIVITY TRENDS CHART ====================
        const activityCtx = document.getElementById('activityLineChart');
        if (activityCtx) {
            const activityData = JSON.parse('@json($monthlyTrends)');
            
            console.log('Activity Data:', activityData);
            
            // Find max value for y-axis scaling
            const allValues = [
                ...activityData.daily_reports,
                ...activityData.weekly_reports,
                ...(activityData.final_reports || [])
            ];
            const maxValue = Math.max(...allValues, 10);
            const yMax = Math.ceil(maxValue / 10) * 10;
            
            // Prepare datasets
            const datasets = [
                {
                    label: 'Daily Reports',
                    data: activityData.daily_reports,
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#3b82f6',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                },
                {
                    label: 'Weekly Reports',
                    data: activityData.weekly_reports,
                    borderColor: '#f59e0b',
                    backgroundColor: 'rgba(245, 158, 11, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#f59e0b',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }
            ];
            
            // Add final reports dataset if available
            if (activityData.final_reports) {
                datasets.push({
                    label: 'Final Reports',
                    data: activityData.final_reports,
                    borderColor: '#f97316',
                    backgroundColor: 'rgba(249, 115, 22, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#f97316',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                });
            }
            
            new Chart(activityCtx, {
                type: 'line',
                data: {
                    labels: activityData.labels,
                    datasets: datasets
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    plugins: { 
                        legend: { 
                            display: true,
                            position: 'top',
                            labels: {
                                boxWidth: 12,
                                font: { size: 11 },
                                usePointStyle: true,
                                pointStyle: 'circle'
                            }
                        },
                        tooltip: { 
                            enabled: true,
                            mode: 'index',
                            intersect: false
                        }
                    },
                    scales: { 
                        y: { 
                            beginAtZero: true,
                            max: yMax,
                            grid: { color: '#e2e8f0', drawBorder: false },
                            ticks: { 
                                stepSize: Math.ceil(yMax / 10),
                                callback: function(value) {
                                    return value;
                                }
                            }
                        },
                        x: { 
                            grid: { display: false },
                            ticks: { font: { size: 11 } }
                        }
                    },
                    elements: {
                        line: { borderWidth: 2 },
                        point: { hoverRadius: 6 }
                    }
                }
            });
            console.log('Activity chart initialized with max value:', yMax);
        } else {
            console.error('Activity chart canvas not found');
        }
    });

    // Handle window resize for charts
    window.addEventListener('resize', function() {
        setTimeout(() => {
            const chart = Chart.getChart('activityLineChart');
            if (chart) {
                chart.update();
            }
        }, 100);
    });
</script>
@endsection
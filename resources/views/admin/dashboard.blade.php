<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/style2.css') }}">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<div class="admin-container">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <img src="{{ asset('images/dost-logo.png') }}" alt="DOST CSF Logo" class="sidebar-logo">
            <span class="sidebar-title">DOST CSF</span>
        </div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('admin.dashboard') }}" class="active">Dashboard</a></li>
            <li><a href="{{ route('admin.respondents') }}">Respondents</a></li>
            <li><a href="#">Years</a></li>
            <li><a href="#">Manage Form</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="dashboard-header">
            <div class="welcome-text">
                <h1>👋 Welcome, Admin!</h1>
            </div>
            <button class="logout-btn" onclick="document.getElementById('logout-form').submit();">LOGOUT</button>
            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>

        <div class="dashboard-cards">
            <div class="card">
                <h3>Gender</h3>
                <canvas id="genderChart"></canvas>
            </div>
            <div class="card">
                <h3>Age</h3>
                <canvas id="ageChart"></canvas>
            </div>
            <div class="card">
                <h3>Client Classification</h3>
                <canvas id="classificationChart"></canvas>
            </div>
            <div class="card">
                <h3>Client Type</h3>
                <canvas id="clientTypeChart"></canvas>
            </div>
            <div class="card">
                <h3>Total Respondents</h3>
                <p>{{ $totalRespondents }}</p>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Gender Pie Chart
        new Chart(document.getElementById('genderChart').getContext('2d'), {
            type: 'pie',
            data: {
                labels: ['Male', 'Female'],
                datasets: [{
                    data: [{{ $malePercentage }}, {{ $femalePercentage }}],
                    backgroundColor: ['#3498db', '#e74c3c']
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'bottom' } }
            }
        });

        // Age Bar Chart
        new Chart(document.getElementById('ageChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_keys($ageDistribution)) !!},
                datasets: [{
                    label: 'Age Distribution',
                    data: {!! json_encode(array_values($ageDistribution)) !!},
                    backgroundColor: '#1abc9c'
                }]
            },
            options: {
                responsive: true,
                scales: { y: { beginAtZero: true } }
            }
        });

        // Classification Doughnut Chart
        new Chart(document.getElementById('classificationChart').getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: {!! json_encode(array_keys($classificationData)) !!},
                datasets: [{
                    data: {!! json_encode(array_values($classificationData)) !!},
                    backgroundColor: ['#f1c40f', '#e67e22', '#1abc9c', '#9b59b6']
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'bottom' } }
            }
        });

        // Client Type Pie Chart
        new Chart(document.getElementById('clientTypeChart').getContext('2d'), {
            type: 'pie',
            data: {
                labels: ['Internal', 'External'],
                datasets: [{
                    data: [{{ $internalCount }}, {{ $externalCount }}],
                    backgroundColor: ['#2ecc71', '#e74c3c']
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'bottom' } }
            }
        });
    });
</script>

</body>
</html>

@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="admin-dashboard">
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h2>Admin Panel</h2>
            <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
        </div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('admin.dashboard') }}" class="active">Dashboard</a></li>
            <li><a href="">Respondents</a></li>
            <li><a href="">Years</a></li>
            <li><a href="">Manage Form</a></li>
        </ul>
        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h1>Welcome, Admin</h1>
        <div class="dashboard-cards">
            <div class="card">
                <h3>Total Respondents</h3>
                <p>{{ $totalRespondents }}</p>
            </div>

            <!-- 📌 Replace Male/Female Respondents with a Pie Chart -->
            <div class="card chart-card">
                <h3>Gender Distribution</h3>
                <canvas id="genderChart"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function toggleSidebar() {
        let sidebar = document.getElementById("sidebar");
        sidebar.classList.toggle("hidden");
    }

    // 📌 Chart.js Pie Chart for Gender Distribution
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('genderChart').getContext('2d');

        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Male', 'Female'],
                datasets: [{
                    data: [{{ $malePercentage }}, {{ $femalePercentage }}],
                    backgroundColor: ['#3498db', '#e74c3c'],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    });
</script>
@endsection

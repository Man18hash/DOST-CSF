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
            {{-- <li><a href="{{ route('admin.respondents') }}">Respondents</a></li> --}}
            {{-- <li><a href="{{ route('admin.years') }}">Years</a></li>
            <li><a href="{{ route('admin.manage-form') }}">Manage Form</a></li>
            <li><a href="{{ route('admin.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li> --}}
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
            <div class="card">
                <h3>Male Respondents</h3>
                <p>{{ $maleRespondents }}</p>
            </div>
            <div class="card">
                <h3>Female Respondents</h3>
                <p>{{ $femaleRespondents }}</p>
            </div>
            <div class="card">
                <h3>Average Age</h3>
                <p>{{ $averageAge }}</p>
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
</script>
@endsection

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
            <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">Dashboard</a></li>
            <li><a href="{{ route('admin.respondents') }}" class="{{ request()->is('admin/respondents') ? 'active' : '' }}">Respondents</a></li>

            <!-- Years Dropdown -->
            <li class="dropdown">
                <a href="#" class="dropdown-btn" onclick="toggleDropdown('yearDropdownContainer')">Years ▼</a>
                <div class="dropdown-container" id="yearDropdownContainer">
                    <ul class="dropdown-content" id="yearDropdown">
                        <li><a href="{{ route('admin.respondents') }}">All Years</a></li>
                    </ul>
                </div>
            </li>

            <!-- Manage Units & Employees Dropdown -->
            <li class="dropdown">
                <a href="#" class="dropdown-btn" onclick="toggleDropdown('manageDropdownContainer')">Manage Units/Employees ▼</a>
                <div class="dropdown-container" id="manageDropdownContainer">
                    <ul class="dropdown-content">
                    <li><a href="{{ route('admin.offices') }}" class="{{ request()->is('admin/offices') ? 'active' : '' }}">office</a></li>
                        <li><a href="{{ route('admin.units') }}" class="{{ request()->is('admin/units') ? 'active' : '' }}">Units</a></li>
                        <li><a href="{{ route('admin.employees') }}" class="{{ request()->is('admin/employees') ? 'active' : '' }}">Employees</a></li>
                    </ul>
                </div>
            </li>
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
        let malePercentage = @json($malePercentage);
        let femalePercentage = @json($femalePercentage);
        let ageDistribution = @json(array_values($ageDistribution));
        let ageLabels = @json(array_keys($ageDistribution));
        let classificationLabels = @json(array_keys($classificationData));
        let classificationValues = @json(array_values($classificationData));
        let internalCount = @json($internalCount);
        let externalCount = @json($externalCount);

        if (document.getElementById('genderChart') && malePercentage !== null && femalePercentage !== null) {
            new Chart(document.getElementById('genderChart').getContext('2d'), {
                type: 'pie',
                data: {
                    labels: ['Male', 'Female'],
                    datasets: [{
                        data: [malePercentage, femalePercentage],
                        backgroundColor: ['#3498db', '#e74c3c']
                    }]
                },
                options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
            });
        }

        console.log("Age Labels:", @json(array_keys($ageDistribution)));
        console.log("Age Data:", @json(array_values($ageDistribution)));

        if (document.getElementById('ageChart') && ageDistribution.some(value => value > 0)) {
            new Chart(document.getElementById('ageChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: ageLabels,
                    datasets: [{
                        label: 'Age Distribution',
                        data: ageDistribution,
                        backgroundColor: '#1abc9c'
                    }]
                },
                options: { responsive: true, scales: { y: { beginAtZero: true } } }
            });
        } else {
            console.warn("Age Distribution data is empty. Chart not rendered.");
        }


        if (document.getElementById('classificationChart')) {
            new Chart(document.getElementById('classificationChart').getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: classificationLabels,
                    datasets: [{
                        data: classificationValues,
                        backgroundColor: ['#f1c40f', '#e67e22', '#1abc9c', '#9b59b6']
                    }]
                },
                options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
            });
        }

        if (document.getElementById('clientTypeChart')) {
            new Chart(document.getElementById('clientTypeChart').getContext('2d'), {
                type: 'pie',
                data: {
                    labels: ['Internal', 'External'],
                    datasets: [{
                        data: [internalCount, externalCount],
                        backgroundColor: ['#2ecc71', '#e74c3c']
                    }]
                },
                options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
            });
        }
    });
</script>


<script>
    function toggleDropdown(dropdownId) {
        // Close all dropdowns first
        document.querySelectorAll(".dropdown-container").forEach(container => {
            if (container.id !== dropdownId) {
                container.style.display = "none";
            }
        });

        // Toggle the selected dropdown
        let dropdown = document.getElementById(dropdownId);
        dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
    }


    document.addEventListener("DOMContentLoaded", function () {
        let dropdownContent = document.getElementById("yearDropdown");

        // Fetch years dynamically
        fetch("{{ route('admin.years') }}")
            .then(response => response.json())
            .then(data => {
                data.forEach(year => {
                    let listItem = document.createElement("li");
                    let link = document.createElement("a");
                    link.href = "{{ url('admin/respondents/filter') }}/" + year;
                    link.textContent = year;
                    listItem.appendChild(link);
                    dropdownContent.appendChild(listItem);
                });
            })
            .catch(error => console.error("Error fetching years:", error));
    });
</script>

</body>
</html>

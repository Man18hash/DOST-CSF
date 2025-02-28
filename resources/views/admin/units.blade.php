<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Units</title>
    <link rel="stylesheet" href="{{ asset('css/style2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <div class="admin-container">
        <!-- Sidebar (Insert this directly instead of including a separate Blade file) -->
        <div class="sidebar">
            <div class="sidebar-header">
                <img src="{{ asset('images/dost-logo.png') }}" alt="DOST CSF Logo" class="sidebar-logo">
                <span class="sidebar-title">DOST CSF</span>
            </div>
            <ul class="sidebar-menu">
                <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">Dashboard</a></li>
                <li><a href="{{ route('admin.respondents') }}" class="{{ request()->is('admin/respondents') ? 'active' : '' }}">Respondents</a></li>

                <li class="dropdown">
                    <a href="#" class="dropdown-btn" onclick="toggleDropdown('yearDropdownContainer')">Years ▼</a>
                    <div class="dropdown-container" id="yearDropdownContainer">
                        <ul class="dropdown-content" id="yearDropdown">
                            <li><a href="{{ route('admin.respondents') }}">All Years</a></li>
                        </ul>
                    </div>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-btn" onclick="toggleDropdown('manageDropdownContainer')">Manage Units/Employees ▼</a>
                    <div class="dropdown-container" id="manageDropdownContainer">
                        <ul class="dropdown-content">
                            <li><a href="{{ route('admin.units') }}" class="{{ request()->is('admin/units') ? 'active' : '' }}">Units</a></li>
                            <li><a href="{{ route('admin.employees') }}" class="{{ request()->is('admin/employees') ? 'active' : '' }}">Employees</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>

        <!-- Main content remains the same -->
        <div class="main-content">
            <div class="dashboard-header">
                <h1>🏢 Manage Units</h1>
            </div>

            <div class="table-container">
                <h3>Unit Providers</h3>
                <table class="respondents-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($unitProviders as $unit)
                        <tr>
                            <td>{{ $unit->unit_name }}</td>
                            <td id="unit-status-{{ $unit->id }}">{{ $unit->status }}</td>
                            <td>
                                <button class="btn-status {{ $unit->status === 'Active' ? 'btn-danger' : 'btn-success' }}"
                                        onclick="toggleStatus('{{ route('admin.toggle_unit_status', $unit->id) }}', 'unit-status-{{ $unit->id }}')">
                                    {{ $unit->status === 'Active' ? 'Deactivate' : 'Activate' }}
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

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
        let dropdownContainer = document.getElementById("yearDropdownContainer");
        let dropdownButton = document.querySelector(".dropdown-btn");
        let dropdownContent = document.getElementById("yearDropdown");

        let currentYear = "{{ $year ?? '' }}"; // Get selected year

        // Keep dropdown open if a year is selected
        if (currentYear) {
            dropdownContainer.style.display = "block";
            dropdownButton.classList.add("active");
        }

        // Ensure the selected year is highlighted
        document.querySelectorAll("#yearDropdown a").forEach(link => {
            if (link.textContent.trim() === currentYear) {
                link.classList.add("active-year");
            }
        });

        // Prevent dropdown from closing when clicking inside
        dropdownContainer.addEventListener("click", function (event) {
            event.stopPropagation();
        });

        // Close dropdown when clicking outside
        document.addEventListener("click", function () {
            dropdownContainer.classList.remove("active");
        });
    });
</script>

<script>
    function toggleStatus(url, statusElementId) {
        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                let statusElement = document.getElementById(statusElementId);
                let buttonElement = statusElement.closest('tr').querySelector('.btn-status');

                // Update status text
                statusElement.innerText = data.status;

                // Update button text and class
                if (data.status === 'Active') {
                    buttonElement.classList.remove('btn-success');
                    buttonElement.classList.add('btn-danger');
                    buttonElement.innerText = 'Deactivate';
                } else {
                    buttonElement.classList.remove('btn-danger');
                    buttonElement.classList.add('btn-success');
                    buttonElement.innerText = 'Activate';
                }
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>

</body>
</html>

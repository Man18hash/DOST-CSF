<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Respondents List - {{ $year }}</title>
    <link rel="stylesheet" href="{{ asset('css/style2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
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
            <li>
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">Dashboard</a>
            </li>
            <li>
                <a href="{{ route('admin.respondents') }}" class="{{ request()->is('admin/respondents') ? 'active' : '' }}">Respondents</a>
            </li>

            <!-- Years Dropdown -->
            <li class="dropdown">
                <a href="#" class="dropdown-btn" onclick="toggleDropdown()">Years ▼</a>
                <div class="dropdown-container" id="yearDropdownContainer">
                    <ul class="dropdown-content" id="yearDropdown">
                        <li>
                            <a href="{{ route('admin.respondents') }}">All Years</a>
                        </li>
                        @foreach($years->unique() as $availableYear)
                            <li>
                                <a href="{{ route('admin.respondents.filter', $availableYear) }}"
                                   class="{{ $year == $availableYear ? 'active' : '' }}">{{ $availableYear }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </li>

            <!-- Manage Units & Employees Dropdown -->
            <li class="dropdown">
                <a href="#" class="dropdown-btn" onclick="toggleDropdown('manageDropdownContainer')">Manage Offices/Units/Employees ▼</a>
                <div class="dropdown-container" id="manageDropdownContainer">
                    <ul class="dropdown-content">
                        <li>
                            <a href="{{ route('admin.offices') }}" class="{{ request()->is('admin/offices') ? 'active' : '' }}">Offices</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.units') }}" class="{{ request()->is('admin/units') ? 'active' : '' }}">Units</a>
                        </li>
                        <li>
                            <a href="{{ route('admin.employees') }}" class="{{ request()->is('admin/employees') ? 'active' : '' }}">Employees</a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="dashboard-header" style="display: flex; align-items: center; justify-content: space-between;">
            <h1 style="margin: 0;">📋 Respondents List for Year {{ $year }}</h1>
            <a href="javascript:void(0);" onclick="resetFilters()" style="
                background-color: #3498db;
                color: white;
                padding: 8px 16px;
                border-radius: 5px;
                text-decoration: none;
                font-weight: bold;">
                ← Back to All Respondents
            </a>
            <script>
                function resetFilters() {
                    let year = "{{ $year }}";
                    let url = "{{ route('admin.respondents.filter', '') }}/" + year;
                    window.location.href = url;
                }
            </script>
        </div>

        <!-- Filters: Month, Age, Gender -->
        <div class="filter-container" style="margin-top: 15px; display: flex; gap: 10px; align-items: center;">

            <!-- Month Filter -->
            <div>
                <label for="month">Filter by Month:</label>
                <select id="month" name="month" onchange="applyFilters()">
                    <option value="">All Months</option>
                    <option value="1" {{ request('month') == '1' ? 'selected' : '' }}>January</option>
                    <option value="2" {{ request('month') == '2' ? 'selected' : '' }}>February</option>
                    <option value="3" {{ request('month') == '3' ? 'selected' : '' }}>March</option>
                    <option value="4" {{ request('month') == '4' ? 'selected' : '' }}>April</option>
                    <option value="5" {{ request('month') == '5' ? 'selected' : '' }}>May</option>
                    <option value="6" {{ request('month') == '6' ? 'selected' : '' }}>June</option>
                    <option value="7" {{ request('month') == '7' ? 'selected' : '' }}>July</option>
                    <option value="8" {{ request('month') == '8' ? 'selected' : '' }}>August</option>
                    <option value="9" {{ request('month') == '9' ? 'selected' : '' }}>September</option>
                    <option value="10" {{ request('month') == '10' ? 'selected' : '' }}>October</option>
                    <option value="11" {{ request('month') == '11' ? 'selected' : '' }}>November</option>
                    <option value="12" {{ request('month') == '12' ? 'selected' : '' }}>December</option>
                </select>
            </div>

            <!-- Age Filter -->
            <div>
                <label for="age">Filter by Age:</label>
                <select id="age" name="age" onchange="applyFilters()">
                    <option value="">All Ages</option>
                    @foreach($ages as $availableAge)
                        <option value="{{ $availableAge }}" {{ request('age') == $availableAge ? 'selected' : '' }}>
                            {{ $availableAge }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Gender Filter -->
            <div>
                <label for="gender">Filter by Gender:</label>
                <select id="gender" name="gender" onchange="applyFilters()">
                    <option value="">All Genders</option>
                    <option value="Male" {{ request('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ request('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>

            <!-- Export Buttons -->
            <div class="export-buttons" style="margin-left: auto; display: flex; gap: 10px;">
                <a id="exportPdfBtn" href="{{ route('admin.respondents.export.pdf', ['year' => $year, 'month' => request('month')]) }}"
                    class="btn btn-danger export-btn">
                     📄 Export PDF
                </a>
                <a id="exportCsvBtn" href="{{ route('admin.respondents.export.csv', ['year' => $year, 'month' => request('month')]) }}"
                    class="btn btn-success export-btn">
                     📊 Export CSV
                </a>
            </div>

            <script>
                function updateExportLinks() {
                    let month = document.getElementById("month").value;
                    let basePdfUrl = "{{ route('admin.respondents.export.pdf', ['year' => $year]) }}";
                    let baseCsvUrl = "{{ route('admin.respondents.export.csv', ['year' => $year]) }}";
                    if (month) {
                        basePdfUrl += `?month=${month}`;
                        baseCsvUrl += `?month=${month}`;
                    }
                    document.getElementById("exportPdfBtn").href = basePdfUrl;
                    document.getElementById("exportCsvBtn").href = baseCsvUrl;
                }
                document.getElementById("month").addEventListener("change", updateExportLinks);
            </script>
        </div>

        <!-- Table for Filtered Respondents -->
        <div class="table-container" style="margin-top: 20px; overflow-y: auto;">
            <table class="respondents-table" style="table-layout: fixed; width: 100%;">
                <thead>
                    <tr>
                        <th style="width: 10%;">Name</th>
                        <th style="width: 12%;">Unit Provider</th>
                        <th style="width: 12%;">Service Availed</th>
                        <th style="width: 12%;">DOST Employee</th>
                        <th style="width: 5%;">SQD0</th>
                        <th style="width: 5%;">SQD1</th>
                        <th style="width: 5%;">SQD2</th>
                        <th style="width: 5%;">SQD3</th>
                        <th style="width: 5%;">SQD4</th>
                        <th style="width: 5%;">SQD5</th>
                        <th style="width: 5%;">SQD6</th>
                        <th style="width: 5%;">SQD7</th>
                        <th style="width: 5%;">SQD8</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($respondents as $respondent)
                        <tr>
                            <td>{{ $respondent->name }}</td>
                            <td>{{ $respondent->unit_provider }}</td>
                            <td>{{ $respondent->assistance_availed }}</td>
                            <td>{{ $respondent->DOST_employee }}</td>
                            <td>{{ $respondent->SQD0 }}</td>
                            <td>{{ $respondent->SQD1 }}</td>
                            <td>{{ $respondent->SQD2 }}</td>
                            <td>{{ $respondent->SQD3 }}</td>
                            <td>{{ $respondent->SQD4 }}</td>
                            <td>{{ $respondent->SQD5 }}</td>
                            <td>{{ $respondent->SQD6 }}</td>
                            <td>{{ $respondent->SQD7 }}</td>
                            <td>{{ $respondent->SQD8 }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- JavaScript for Filtering -->
<script>
    function applyFilters() {
        let month = document.getElementById("month").value;
        let age = document.getElementById("age").value;
        let gender = document.getElementById("gender").value;
        let year = "{{ $year }}";
        let url = "{{ route('admin.respondents.filter', '') }}/" + year;

        let params = [];
        if (month) params.push("month=" + month);
        if (age) params.push("age=" + age);
        if (gender) params.push("gender=" + gender);

        if (params.length > 0) {
            url += "?" + params.join("&");
        }

        window.location.href = url;
    }
</script>

<script>
    function toggleDropdown(dropdownId) {
        let dropdown = document.getElementById(dropdownId);

        // Close other dropdowns first
        document.querySelectorAll(".dropdown-container").forEach(container => {
            if (container.id !== dropdownId) {
                container.style.display = "none";
            }
        });

        // Toggle the selected dropdown
        dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";

        // Store open state in session storage (so it remains open after page reload)
        sessionStorage.setItem(dropdownId, dropdown.style.display);
    }

    document.addEventListener("DOMContentLoaded", function () {
        let dropdownContainer = document.getElementById("yearDropdownContainer");
        let dropdownButton = document.querySelector(".dropdown-btn");
        let currentYear = "{{ $year ?? '' }}";

        // Keep dropdown open if a year is selected
        if (currentYear) {
            dropdownContainer.style.display = "block";
            dropdownButton.classList.add("active");
        }

        // Highlight the selected year
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
    function resetFilters() {
        let year = "{{ $year }}";
        let url = "{{ route('admin.respondents.filter', '') }}/" + year;
        window.location.href = url;
    }
</script>
</body>
</html>

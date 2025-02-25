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
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li>
                <a href="{{ route('admin.respondents') }}" class="{{ request()->routeIs('admin.respondents') ? 'active' : '' }}">
                    Respondents
                </a>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-btn" onclick="toggleDropdown()">Years ▼</a>
                <div class="dropdown-container" id="yearDropdownContainer">
                    <ul class="dropdown-content" id="yearDropdown">
                        <li><a href="{{ route('admin.respondents') }}">All Years</a></li>
                        @foreach($years->unique() as $availableYear)
                            <li><a href="{{ route('admin.respondents.filter', $availableYear) }}"
                                class="{{ $year == $availableYear ? 'active' : '' }}">{{ $availableYear }}</a></li>
                        @endforeach
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
                    let year = "{{ $year }}"; // Get the selected year
                    let url = "{{ route('admin.respondents.filter', '') }}/" + year;
                    window.location.href = url; // Redirect to year without quarter filter
                }
            </script>
        </div>

        <!-- Filters: Quarter, Age, Gender -->
        <div class="filter-container" style="margin-top: 15px; display: flex; gap: 10px; align-items: center;">

            <!-- Quarter Filter -->
            <div>
                <label for="quarter">Filter by Quarter:</label>
                <select id="quarter" name="quarter" onchange="applyFilters()">
                    <option value="">All Quarters</option>
                    <option value="1" {{ request('quarter') == '1' ? 'selected' : '' }}>Q1 (Jan - Mar)</option>
                    <option value="2" {{ request('quarter') == '2' ? 'selected' : '' }}>Q2 (Apr - Jun)</option>
                    <option value="3" {{ request('quarter') == '3' ? 'selected' : '' }}>Q3 (Jul - Sep)</option>
                    <option value="4" {{ request('quarter') == '4' ? 'selected' : '' }}>Q4 (Oct - Dec)</option>
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

            <!-- Export Buttons - Now Aligned Properly -->
            <div class="export-buttons" style="margin-left: auto; display: flex; gap: 10px;">
                <a href="{{ route('admin.respondents.export.pdf', ['year' => $year, 'quarter' => request('quarter'), 'age' => request('age'), 'gender' => request('gender')]) }}"
                class="btn btn-danger export-btn">
                    📄 Export PDF
                </a>

                <a href="{{ route('admin.respondents.export.csv', ['year' => $year, 'quarter' => request('quarter'), 'age' => request('age'), 'gender' => request('gender')]) }}"
                class="btn btn-success export-btn">
                    📊 Export CSV
                </a>
            </div>

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

<!-- JavaScript for Quarterly, age, gender Filtering -->
<script>
    function applyFilters() {
        let quarter = document.getElementById("quarter").value;
        let age = document.getElementById("age").value;
        let gender = document.getElementById("gender").value;
        let year = "{{ $year }}";
        let url = "{{ route('admin.respondents.filter', '') }}/" + year;

        let params = [];
        if (quarter) params.push("quarter=" + quarter);
        if (age) params.push("age=" + age);
        if (gender) params.push("gender=" + gender);

        if (params.length > 0) {
            url += "?" + params.join("&");
        }

        window.location.href = url;
    }
</script>

<script>
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
    function resetFilters() {
        let year = "{{ $year }}"; // Get the selected year
        let url = "{{ route('admin.respondents.filter', '') }}/" + year;
        window.location.href = url; // Redirect to year without quarter filter
    }
</script>

<script>
    function applyFilters() {
        let quarter = document.getElementById("quarter").value;
        let age = document.getElementById("age").value;
        let gender = document.getElementById("gender").value;
        let year = "{{ $year }}";
        let url = "{{ route('admin.respondents.filter', '') }}/" + year;

        let params = [];
        if (quarter) params.push("quarter=" + quarter);
        if (age) params.push("age=" + age);
        if (gender) params.push("gender=" + gender);

        if (params.length > 0) {
            url += "?" + params.join("&");
        }

        window.location.href = url;
    }
</script>

</body>
</html>

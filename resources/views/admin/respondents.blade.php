@php
    // Ensure $ages is defined.
    $ages = $ages ?? collect([]);
    // Base URL for filtering (if year is set, use the respondents.filter route)
    $baseFilterUrl = isset($year)
        ? url('admin/respondents/filter/' . $year)
        : route('admin.respondents');
    // Base URLs for exports (only valid if a year is set)
    $baseExportPdfUrl = isset($year) ? url('admin/respondents/export/pdf/' . $year) : '';
    $baseExportCsvUrl = isset($year) ? url('admin/respondents/export/csv/' . $year) : '';
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Respondents for Year {{ $year ?? 'All Years' }}</title>
  <link rel="stylesheet" href="{{ asset('css/style2.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="admin-container">
  <!-- Sidebar -->
  <div class="sidebar">
    <div class="sidebar-header">
      <img src="{{ asset('images/dost-logo.png') }}" alt="DOST CSF Logo" class="sidebar-logo" />
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
        <a href="#" class="dropdown-btn" onclick="toggleDropdown('yearDropdownContainer', event)">Years ▼</a>
        <div class="dropdown-container" id="yearDropdownContainer">
          <ul class="dropdown-content" id="yearDropdown">
            <li>
              <a href="{{ route('admin.respondents') }}">All Years</a>
            </li>
            @isset($years)
              @foreach($years->unique() as $availableYear)
                <li>
                  <a href="{{ route('admin.respondents.filter', $availableYear) }}"
                     class="{{ (isset($year) && $year == $availableYear) ? 'active' : '' }}">
                    {{ $availableYear }}
                  </a>
                </li>
              @endforeach
            @endisset
          </ul>
        </div>
      </li>
      <!-- Manage Units & Employees Dropdown -->
      <li class="dropdown">
        <a href="#" class="dropdown-btn" onclick="toggleDropdown('manageDropdownContainer', event)">Manage Office/Units/Employees ▼</a>
        <div class="dropdown-container" id="manageDropdownContainer">
          <ul class="dropdown-content">
          <li>
              <a href="{{ route('admin.offices') }}" class="{{ request()->is('admin/offcies') ? 'active' : '' }}">Offices</a>
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
      <h1 style="margin: 0;">📋 Respondents List for Year {{ $year ?? 'All Years' }}</h1>
      <a href="javascript:void(0);" onclick="resetFilters()" style="
          background-color: #3498db;
          color: white;
          padding: 8px 16px;
          border-radius: 5px;
          text-decoration: none;
          font-weight: bold;">
        ← Back to All Respondents
      </a>
    </div>

    <!-- Filtering Options -->
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

      <!-- Export Buttons (display only if a year is set) -->
      @if(isset($year))
      <div class="export-buttons" style="margin-left: auto; display: flex; gap: 10px;">
        <a id="exportPdfBtn" href="{{ $baseExportPdfUrl }}?{{ http_build_query(request()->except('page')) }}"
           class="btn btn-danger export-btn">
          📄 Export PDF
        </a>
        <a id="exportCsvBtn" href="{{ $baseExportCsvUrl }}?{{ http_build_query(request()->except('page')) }}"
           class="btn btn-success export-btn">
          📊 Export CSV
        </a>
      </div>
      @else
      <div class="export-buttons" style="margin-left: auto;">
        <span>Please select a year to export.</span>
      </div>
      @endif
    </div>

    <!-- Table for Filtered Respondents -->
    <div class="table-container" style="margin-top: 20px; overflow-y: auto;">
      <table class="respondents-table" style="table-layout: fixed; width: 100%;">
        <thead>
          <tr>
            <th>Name</th>
            <th>Age</th>
            <th>Sex</th>
            <th>Address</th>
            <th>Client Classification</th>
            <th>Client Type</th>
            <th>Date</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($respondents as $respondent)
            <tr>
              <td>{{ $respondent->name ?? 'N/A' }}</td>
              <td>{{ $respondent->age }}</td>
              <td>{{ $respondent->sex }}</td>
              <td>{{ $respondent->address }}</td>
              <td>
                @php
                  // Safely decode into an array (even if stored as a string)
                  $classifications = json_decode($respondent->client_classification, true);
                  if (! is_array($classifications)) {
                    $classifications = [$classifications];
                  }
                @endphp

                @foreach($classifications as $classification)
                  <span class="badge">{{ $classification }}</span>
                @endforeach
              </td>
              <td>{{ $respondent->client_type }}</td>
              <td>{{ $respondent->date }}</td>
              <td>
                <button class="btn-preview" onclick="event.preventDefault(); showFeedback({{ $respondent->id }})">Preview</button>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <!-- Feedback Modal -->
    <div id="feedbackModal" class="modal">
      <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <div class="form-container1">
          <h1 class="title-text">FEEDBACK DETAILS</h1>
        </div>
        <div class="form-container2">
          <table class="feedback-table">
            <tr>
              <td><strong>Name:</strong></td>
              <td><input type="text" id="name" readonly></td>
            </tr>
            <tr>
              <td><strong>Age:</strong></td>
              <!-- Changed input id from "age" to "feedback_age" -->
              <td><input type="text" id="feedback_age" readonly></td>
            </tr>
            <tr>
              <td><strong>Sex:</strong></td>
              <td><input type="text" id="sex" readonly></td>
            </tr>
            <tr>
              <td><strong>Address:</strong></td>
              <td><input type="text" id="address" readonly></td>
            </tr>
            <tr>
              <td><strong>Client Classification:</strong></td>
              <td><input type="text" id="client_classification" readonly></td>
            </tr>
            <tr>
              <td><strong>Client Type:</strong></td>
              <td><input type="text" id="client_type" readonly></td>
            </tr>
            <tr>
              <td><strong>Date:</strong></td>
              <td><input type="text" id="date" readonly></td>
            </tr>
            <tr>
              <td><strong>CC1 (Awareness):</strong></td>
              <td><input type="text" id="CC1" readonly></td>
            </tr>
            <tr>
              <td><strong>CC2 (Visibility):</strong></td>
              <td><input type="text" id="CC2" readonly></td>
            </tr>
            <tr>
              <td><strong>CC3 (Helpfulness):</strong></td>
              <td><input type="text" id="CC3" readonly></td>
            </tr>
            <tr>
              <td><strong>Unit Provider:</strong></td>
              <td><input type="text" id="unit_provider" readonly></td>
            </tr>
            <tr>
              <td><strong>Service Availed:</strong></td>
              <td><input type="text" id="assistance_availed" readonly></td>
            </tr>
            <tr>
              <td><strong>Name of Employee:</strong></td>
              <td><input type="text" id="DOST_employee" readonly></td>
            </tr>
          </table>

          <h3 style="text-align: center; margin-top: 20px;">Rating Questions</h3>
          <table class="criteria-table">
            <tr>
              <th>Question</th>
              <th>Answer</th>
            </tr>
            <tr>
              <td>SQD0: I am satisfied with the service.</td>
              <td><input type="text" id="SQD0" readonly></td>
            </tr>
            <tr>
              <td>SQD1: I spent a reasonable amount of time.</td>
              <td><input type="text" id="SQD1" readonly></td>
            </tr>
            <tr>
              <td>SQD2: The office followed proper steps.</td>
              <td><input type="text" id="SQD2" readonly></td>
            </tr>
            <tr>
              <td>SQD3: The process was simple.</td>
              <td><input type="text" id="SQD3" readonly></td>
            </tr>
            <tr>
              <td>SQD4: I easily found information.</td>
              <td><input type="text" id="SQD4" readonly></td>
            </tr>
            <tr>
              <td>SQD5: I paid a reasonable amount for fees.</td>
              <td><input type="text" id="SQD5" readonly></td>
            </tr>
            <tr>
              <td>SQD6: The office was fair to everyone.</td>
              <td><input type="text" id="SQD6" readonly></td>
            </tr>
            <tr>
              <td>SQD7: The staff was courteous and helpful.</td>
              <td><input type="text" id="SQD7" readonly></td>
            </tr>
            <tr>
              <td>SQD8: My request was clearly explained.</td>
              <td><input type="text" id="SQD8" readonly></td>
            </tr>
          </table>

          <table class="feedback-table">
            <tr>
              <td><strong>Suggestions:</strong></td>
              <td><textarea id="suggestions" readonly></textarea></td>
            </tr>
            <tr>
              <td><strong>Recommendation:</strong></td>
              <td><input type="text" id="recommendation" readonly></td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- JavaScript Section -->
<script>
  // Base URLs defined in PHP
  const baseFilterUrl = @json($baseFilterUrl);
  const baseExportPdfUrl = @json($baseExportPdfUrl);
  const baseExportCsvUrl = @json($baseExportCsvUrl);

  // Build URL with query parameters and redirect
  function applyFilters() {
    const month = document.getElementById("month").value;
    const age = document.getElementById("age").value;
    const gender = document.getElementById("gender").value;
    const params = new URLSearchParams();
    if(month) params.append('month', month);
    if(age) params.append('age', age);
    if(gender) params.append('gender', gender);
    window.location.href = baseFilterUrl + (params.toString() ? '?' + params.toString() : '');
  }

  // Reset filters by redirecting to the base URL
  function resetFilters() {
    window.location.href = baseFilterUrl;
  }

  // Update export links to include filters
  function updateExportLinks() {
    const month = document.getElementById("month").value;
    const age = document.getElementById("age").value;
    const gender = document.getElementById("gender").value;
    const params = new URLSearchParams();
    if(month) params.append('month', month);
    if(age) params.append('age', age);
    if(gender) params.append('gender', gender);
    if(baseExportPdfUrl && baseExportCsvUrl) {
      document.getElementById("exportPdfBtn").href = baseExportPdfUrl + (params.toString() ? '?' + params.toString() : '');
      document.getElementById("exportCsvBtn").href = baseExportCsvUrl + (params.toString() ? '?' + params.toString() : '');
    }
  }
  document.getElementById("month").addEventListener("change", updateExportLinks);
  document.getElementById("age").addEventListener("change", updateExportLinks);
  document.getElementById("gender").addEventListener("change", updateExportLinks);

  // Show feedback modal with fetched respondent details
  function showFeedback(id) {
    fetch(`/admin/respondents/${id}/preview`)
      .then(response => response.json())
      .then(data => {
        document.getElementById("name").value = data.name || "N/A";
        // Update the modal's age field (feedback_age) instead of "age"
        document.getElementById("feedback_age").value = data.age;
        document.getElementById("sex").value = data.sex;
        document.getElementById("address").value = data.address;
        try {
          let classifications = JSON.parse(data.client_classification);
          document.getElementById("client_classification").value = classifications.join(", ");
        } catch (error) {
          document.getElementById("client_classification").value = "N/A";
        }
        document.getElementById("client_type").value = data.client_type;
        document.getElementById("date").value = data.date;
        document.getElementById("CC1").value = data.CC1 || "N/A";
        document.getElementById("CC2").value = data.CC2 || "N/A";
        document.getElementById("CC3").value = data.CC3 || "N/A";
        document.getElementById("unit_provider").value = data.unit_provider || "N/A";
        document.getElementById("assistance_availed").value = data.assistance_availed;
        document.getElementById("DOST_employee").value = data.DOST_employee;
        document.getElementById("SQD0").value = data.SQD0;
        document.getElementById("SQD1").value = data.SQD1;
        document.getElementById("SQD2").value = data.SQD2;
        document.getElementById("SQD3").value = data.SQD3;
        document.getElementById("SQD4").value = data.SQD4;
        document.getElementById("SQD5").value = data.SQD5;
        document.getElementById("SQD6").value = data.SQD6;
        document.getElementById("SQD7").value = data.SQD7;
        document.getElementById("SQD8").value = data.SQD8;
        document.getElementById("suggestions").value = data.suggestions || "No suggestions provided";
        document.getElementById("recommendation").value = data.recommendation;
        document.getElementById("feedbackModal").style.display = "flex";
      })
      .catch(error => console.error("Error fetching respondent data:", error));
  }

  // Close the feedback modal
  function closeModal() {
    document.getElementById("feedbackModal").style.display = "none";
  }

  // Close modal if clicking outside the modal content
  window.onclick = function(event) {
    const modal = document.getElementById("feedbackModal");
    if (event.target === modal) {
      closeModal();
    }
  };

  // Dropdown toggle functionality
  function toggleDropdown(dropdownId, event) {
    event.stopPropagation();
    const dropdown = document.getElementById(dropdownId);
    dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
  }

  // Hide all dropdowns when clicking outside
  document.addEventListener("click", function() {
    document.querySelectorAll(".dropdown-container").forEach(container => {
      container.style.display = "none";
    });
  });

  // Setup dropdown and modal on DOMContentLoaded
  document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("feedbackModal").style.display = "none";
    // Highlight the active year in the dropdown if set
    const currentYear = @json($year ?? '');
    if(currentYear) {
      document.querySelectorAll("#yearDropdown a").forEach(link => {
        if(link.textContent.trim() === currentYear) {
          link.classList.add("active-year");
        }
      });
    }
    // Dynamically fetch years for the dropdown (if needed)
    const dropdownContent = document.getElementById("yearDropdown");
    fetch("{{ route('admin.years') }}")
      .then(response => response.json())
      .then(data => {
        data.forEach(year => {
          const listItem = document.createElement("li");
          const link = document.createElement("a");
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

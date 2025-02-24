<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Respondents List</title>
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
            <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">Dashboard</a></li>
            <li><a href="{{ route('admin.respondents') }}" class="{{ request()->is('admin/respondents') ? 'active' : '' }}">Respondents</a></li>
            <li class="dropdown">
                <a href="#" class="dropdown-btn" onclick="toggleDropdown()">Years ▼</a>
                <div class="dropdown-container" id="yearDropdownContainer">
                    <ul class="dropdown-content" id="yearDropdown">
                        <li><a href="{{ route('admin.respondents') }}">All Years</a></li>
                    </ul>
                </div>
            </li>
            <li><a href="{{ route('admin.manage_form') }}" class="{{ request()->is('admin/manage_form') ? 'active' : '' }}">Manage Form</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="dashboard-header">
            <div class="welcome-text">
                <h1>📋 Respondents List</h1>
            </div>
        </div>

        <div class="filter-container">
            <label for="sortYear">Sort by Year:</label>
            <select id="sortYear" onchange="applyFilters()">
                <option value="">All Years</option>
                @foreach($years as $year)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endforeach
            </select>

            <label for="sortClientType">Sort by Client Type:</label>
            <select id="sortClientType" onchange="applyFilters()">
                <option value="">All Types</option>
                <option value="Internal">Internal</option>
                <option value="External">External</option>
            </select>

            <label for="sortClientClassification">Sort by Client Classification:</label>
            <select id="sortClientClassification" onchange="applyFilters()">
                <option value="">All Classifications</option>
                <option value="General Public">General Public</option>
                <option value="Business">Business</option>
                <option value="Government">Government</option>
                <option value="Student">Student</option>
            </select>
        </div>

        <!-- Respondents Table -->
        <div class="table-container">
            <table class="respondents-table">
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
                            @foreach(json_decode($respondent->client_classification) ?? [] as $classification)
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
        <div id="feedbackModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>

                <!-- Feedback Form Title -->
                <div class="form-container1">
                    <h1 class="title-text">FEEDBACK DETAILS</h1>
                </div>

                <!-- Feedback Details Form -->
                <div class="form-container2">
                    <table class="feedback-table">
                        <tr><td><strong>Name:</strong></td><td><input type="text" id="name" readonly></td></tr>
                        <tr><td><strong>Age:</strong></td><td><input type="text" id="age" readonly></td></tr>
                        <tr><td><strong>Sex:</strong></td><td><input type="text" id="sex" readonly></td></tr>
                        <tr><td><strong>Address:</strong></td><td><input type="text" id="address" readonly></td></tr>
                        <tr><td><strong>Client Classification:</strong></td><td><input type="text" id="client_classification" readonly></td></tr>
                        <tr><td><strong>Client Type:</strong></td><td><input type="text" id="client_type" readonly></td></tr>
                        <tr><td><strong>Date:</strong></td><td><input type="text" id="date" readonly></td></tr>
                        <tr><td><strong>CC1 (Awareness of CC):</strong></td><td><input type="text" id="CC1" readonly></td></tr>
                        <tr><td><strong>CC2 (Visibility of CC):</strong></td><td><input type="text" id="CC2" readonly></td></tr>
                        <tr><td><strong>CC3 (Helpfulness of CC):</strong></td><td><input type="text" id="CC3" readonly></td></tr>
                        <tr><td><strong>Unit Provider:</strong></td><td><input type="text" id="unit_provider" readonly></td></tr>
                        <tr><td><strong>Service Availed:</strong></td><td><input type="text" id="assistance_availed" readonly></td></tr>
                        <tr><td><strong>Name of Employee:</strong></td><td><input type="text" id="DOST_employee" readonly></td></tr>
                    </table>

                    <!-- Display Rating Questions -->
                    <h3 style="text-align: center; margin-top: 20px;">Rating Questions</h3>
                    <table class="criteria-table">
                        <tr><th>Question</th><th>Answer</th></tr>
                        <tr><td>SQD0: I am satisfied with the service.</td><td><input type="text" id="SQD0" readonly></td></tr>
                        <tr><td>SQD1: I spent a reasonable amount of time.</td><td><input type="text" id="SQD1" readonly></td></tr>
                        <tr><td>SQD2: The office followed proper steps.</td><td><input type="text" id="SQD2" readonly></td></tr>
                        <tr><td>SQD3: The process was simple.</td><td><input type="text" id="SQD3" readonly></td></tr>
                        <tr><td>SQD4: I easily found information.</td><td><input type="text" id="SQD4" readonly></td></tr>
                        <tr><td>SQD5: I paid a reasonable amount of fees for my transaction. (Cost).</td><td><input type="text" id="SQD5" readonly></td></tr>
                        <tr><td>SQD6: I feel the office was fair to everyone, or "walang palakasan", during my transaction.</td><td><input type="text" id="SQD6" readonly></td></tr>
                        <tr><td>SQD7: I was treated courteously by the staff, and (if asked for help) the staff was helpful.</td><td><input type="text" id="SQD7" readonly></td></tr>
                        <tr><td>SQD8: I got what i needed from the government office, or (if denied) denial of request was sufficiently explained to me.</td><td><input type="text" id="SQD8" readonly></td></tr>
                    </table>

                    <table class="feedback-table">
                        <tr><td></td><td></td></tr>
                        <tr><td><strong>Suggestions:</strong></td><td><textarea id="suggestions" readonly></textarea></td></tr>
                        <tr><td><strong>Recommend Programs & Services Rate:</strong></td><td><input type="text" id="recommendation" readonly></td></tr>
                    </table>
                </div>
            </div>
        </div> <!-- End of Modal -->
    </div>
</div>

<script>
    function showFeedback(id) {
        fetch(`/admin/respondents/${id}/preview`)
            .then(response => response.json())
            .then(data => {
                console.log("Fetched Data:", data);

                // Fill modal fields
                document.getElementById("name").value = data.name ?? "N/A";
                document.getElementById("age").value = data.age;
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
                // **Fill the missing fields**
                document.getElementById("CC1").value = data.CC1 ?? "N/A";
                document.getElementById("CC2").value = data.CC2 ?? "N/A";
                document.getElementById("CC3").value = data.CC3 ?? "N/A";
                document.getElementById("unit_provider").value = data.unit_provider ?? "N/A";
                document.getElementById("assistance_availed").value = data.assistance_availed;
                document.getElementById("DOST_employee").value = data.DOST_employee;

                // Fill rating questions
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

                // Show modal
                let modal = document.getElementById("feedbackModal");
                modal.style.display = "flex"; // Ensure it is centered
            })
            .catch(error => console.error("Error fetching respondent data:", error));
    }

    function closeModal() {
        document.getElementById("feedbackModal").style.display = "none";
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        let modal = document.getElementById("feedbackModal");
        if (event.target === modal) {
            closeModal();
        }
    };

    // 🔥 **Ensure modal does NOT show automatically when page loads**
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("feedbackModal").style.display = "none";
    });

</script>

<script>
    function toggleDropdown() {
        document.querySelector('.dropdown').classList.toggle('active');
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

<script>
    function applyFilters() {
        let year = document.getElementById("sortYear").value;
        let clientType = document.getElementById("sortClientType").value;
        let clientClassification = document.getElementById("sortClientClassification").value;

        let queryParams = [];

        if (year) queryParams.push(`year=${year}`);
        if (clientType) queryParams.push(`client_type=${clientType}`);
        if (clientClassification) queryParams.push(`client_classification=${clientClassification}`);

        let queryString = queryParams.length > 0 ? "?" + queryParams.join("&") : "";
        window.location.href = "{{ route('admin.respondents') }}" + queryString;
    }
</script>


</body>
</html>

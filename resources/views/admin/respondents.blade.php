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
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('admin.respondents') }}" class="active">Respondents</a></li>
            <li><a href="#">Years</a></li>
            <li><a href="#">Manage Form</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="dashboard-header">
            <div class="welcome-text">
                <h1>📋 Respondents List</h1>
            </div>
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
                        <tr><td><strong>Service Availed:</strong></td><td><input type="text" id="assistance_availed" readonly></td></tr>
                        <tr><td><strong>Name of Employee:</strong></td><td><input type="text" id="DOST_employee" readonly></td></tr>
                        <tr><td><strong>Suggestions:</strong></td><td><textarea id="suggestions" readonly></textarea></td></tr>
                        <tr><td><strong>Recommendation:</strong></td><td><input type="text" id="recommendation" readonly></td></tr>
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
                document.getElementById("assistance_availed").value = data.assistance_availed;
                document.getElementById("DOST_employee").value = data.DOST_employee;
                document.getElementById("suggestions").value = data.suggestions || "No suggestions provided";
                document.getElementById("recommendation").value = data.recommendation;

                // Fill rating questions
                document.getElementById("SQD0").value = data.SQD0;
                document.getElementById("SQD1").value = data.SQD1;
                document.getElementById("SQD2").value = data.SQD2;
                document.getElementById("SQD3").value = data.SQD3;
                document.getElementById("SQD4").value = data.SQD4;

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

</body>
</html>

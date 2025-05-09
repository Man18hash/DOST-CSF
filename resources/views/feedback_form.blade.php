@extends('layouts.app')

@section('title', 'DOST02 CSF Form')

@section('content')

@if ($errors->any() && request()->isMethod('post'))
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="content-wrapper">
    <!-- Title Section -->
    <div class="form-container1">
        <h1 style="font-size: 50px" class="title-text">CUSTOMER SATISFACTION FEEDBACK</h1>
        <h1 style="text-transform: capitalize; letter-spacing: 1px; font-weight:normal" class="title-text">Pagkuntento ng Pagsilbihan</h1>
        </br>
        <h3 style="letter-spacing: 1px" class="title-text"><i>HELP US SERVE YOU BETTER!</i></h3>
        <h3 style="text-transform: capitalize; letter-spacing: 1px; font-weight:normal" class="title-text"><i>Tulungan mo kaming mas mapabuti and aming mga proseso at serbisyo!</i></h3>
    </div>

    <!-- Form Section -->
    <div class="form-container2">
        <form method="POST" action="{{ route('feedback.store') }}">
            @csrf
            <table class="feedback-table">
                <tr>
                    <td colspan="2" style="text-align: center; font-weight: bold; padding: 15px; background: rgba(38, 58, 156, 0.1);">
                        The Client Satisfaction Measurement (CSM) tracks the customer experience of government offices.
                        Your feedback on your recently concluded transaction will help this office provide a better service.
                        Personal information shared will be kept strictly confidential.
                        <p style="font-weight:normal">[Ang Client Satisfaction Measurement (CSM) ay naglalayong masubaybayan ang
                            karanasan ng taumbayan hinggil sa kanilang pakikitransaksyon sa mga tanggapan ng gobyerno. Makakatulong
                            ang inyong kasagutan ukol sa inyong naging karanasan sa katatapos lamang na transaksyon, upang mas mapabuti
                            at lalong mapahusay ang aming serbisyo publiko. Ang personal na impormasyson na iyong ibabahagi ay mananatiling
                            kumpidensyal.]</p>
                    </td>
                </tr>
                <tr>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: left; font-weight: bold; padding: 15px; background: rgba(38, 58, 156, 0.1);">
                        INSTRUCTIONS: Write legibly or check mark (✔) on the following basic information.
                        <span style="font-weight:normal">[Sumulat ng malinaw o lagyan ng tsek (✔) sa sumusunod na pangunahing impormasyon.]</span>
                    </td>
                </tr>
                <tr>
                    <td><strong>Name:</strong></td>
                    <td><input type="text" name="name" placeholder="Optional"></td>
                </tr>
                <tr>
                    <td><strong>Age:</strong></td>
                    <td><input type="number" name="age" required></td>
                </tr>
                <tr>
                    <td><strong>Sex:</strong></td>
                    <td class="checkbox-group">
                        <label><input type="radio" name="sex" value="Male" required> Male</label>
                        <label><input type="radio" name="sex" value="Female" required> Female</label>
                    </td>
                </tr>
                <tr>
                    <td><strong>Address:</strong></td>
                    <td><input type="text" name="address" required></td>
                </tr>
                <tr>
                    <td><strong>Client Classification:</strong></td>
                    <td class="checkbox-group">
                        <label>
                            <input type="radio" name="client_classification" value="General Public" required>
                            General Public
                        </label>
                        <label>
                            <input type="radio" name="client_classification" value="Business" required>
                            Business
                        </label>
                        <label>
                            <input type="radio" name="client_classification" value="Government" required>
                            Government
                        </label>
                        <label>
                            <input type="radio" name="client_classification" value="Student" required>
                            Student
                        </label>
                        <label>
                            <!-- “Others” radio + a disabled text field by default -->
                            <input type="radio" name="client_classification" value="Others" id="othersRadio">
                            Others:
                            <input type="text" name="client_other" placeholder="Specify" id="clientOtherInput" disabled>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td><strong>Client Type:</strong></td>
                    <td class="checkbox-group">
                        <label><input type="radio" name="client_type" value="Internal" required> Internal</label>
                        <label><input type="radio" name="client_type" value="External" required> External</label>
                    </td>
                </tr>
                <!-- Updated Date Row with id for automatic date setting -->
                <tr>
                    <td><strong>Date:</strong></td>
                    <td><input type="date" name="date" id="dateInput" required></td>
                </tr>
                <tr>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: left; font-weight: bold; padding: 15px; background: rgba(38, 58, 156, 0.1);">
                        INSTRUCTIONS: Check mark (✔)
                        <span style="font-weight:normal">on your answers to the question on the Citizen's Charter (CC).
                            It is a document detailing a government agency's services, requirements, fees, and processing times.</span>
                    </td>
                </tr>

                <!-- CC1 Selection -->
                <tr>
                    <td><strong>CC1: Which of the following best describes your awareness of a CC?</strong></td>
                    <td class="checkbox-group">
                        <label><input type="radio" name="CC1" value="I know what a CC is and I saw this office's CC." required onclick="toggleCC(false)"> I know what a CC is and I saw this office's CC.</label>
                        <label><input type="radio" name="CC1" value="I know what a CC is but I did not see the office's CC." required onclick="toggleCC(false)"> I know what a CC is but I did not see the office's CC.</label>
                        <label><input type="radio" name="CC1" value="I learned of the CC only when I saw this office's CC." required onclick="toggleCC(false)"> I learned of the CC only when I saw this office's CC.</label>
                        <label>
                            <input type="radio" name="CC1" id="cc1-no-knowledge" value="I do not know what a CC is and I did not see one in this office." required onclick="toggleCC(true)">
                            I do not know what a CC is and I did not see one in this office.
                        </label>
                    </td>
                </tr>

                <!-- CC2 and CC3 (Proper Table Rows) -->
                <tr id="cc-extra-questions">
                    <td><strong>CC2: If aware of CC (answered 1-3 in CC1), would you say that the CC of this office was ...?</strong></td>
                    <td class="checkbox-group">
                        <label><input type="radio" name="CC2" value="Easy to see" required> Easy to see</label>
                        <label><input type="radio" name="CC2" value="Somewhat easy to see" required> Somewhat easy to see</label>
                        <label><input type="radio" name="CC2" value="Difficult to see" required> Difficult to see</label>
                        <label><input type="radio" name="CC2" value="Not visible at all" required> Not visible at all</label>
                        <label><input type="radio" name="CC2" value="Not applicable" required> Not applicable</label>
                    </td>
                </tr>
                <tr id="cc-extra-questions-2">
                    <td><strong>CC3: If aware of CC (answered 1-3 in CC1), how much did the CC help you in your transaction?</strong></td>
                    <td class="checkbox-group">
                        <label><input type="radio" name="CC3" value="Helped very much" required> Helped very much</label>
                        <label><input type="radio" name="CC3" value="Somewhat helped" required> Somewhat helped</label>
                        <label><input type="radio" name="CC3" value="Did not help" required> Did not help</label>
                        <label><input type="radio" name="CC3" value="Not applicable" required> Not applicable</label>
                    </td>
                </tr>

                <script>
                    function toggleCC(hide) {
                        var ccExtra1 = document.getElementById("cc-extra-questions");
                        var ccExtra2 = document.getElementById("cc-extra-questions-2");

                        if (hide) {
                            ccExtra1.style.display = "none";
                            ccExtra2.style.display = "none";
                        } else {
                            ccExtra1.style.display = "table-row";
                            ccExtra2.style.display = "table-row";
                        }
                    }
                </script>

                <tr>
                    <td colspan="2" style="text-align: left; font-weight: bold; padding: 15px; background: rgba(38, 58, 156, 0.1);">
                    </td>
                </tr>
                <!-- Office Dropdown -->
                <tr>
                <td><strong>DOST 02 Office:</strong></td>
                        <td>
                        <select name="office_id" id="office_id" required>
                        <option value="" disabled selected>Select an Office</option>
                        @foreach($offices as $office)
                        <option value="{{ $office->id }}">{{ $office->name }}</option>
                        @endforeach
                </select>
                </td>
                </tr>

                <!-- Unit Provider D  ropdown -->   
                <tr>
                        <td><strong>DOST 02 Office/Unit Provider:</strong></td>
                    <td>
                        <select name="unit_provider" id="unit_provider" required>
                        <option value="" disabled selected>Select a Unit</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td><strong>Service/Transaction/Assistance Availed:</strong></td>
                    <td><input type="text" name="assistance_availed" required></td>
                </tr>

                <!-- Employee Dropdown -->
                <tr>
                    <td><strong>Name of DOST 02 Employee:</strong></td>
                    <td>
                <select name="DOST_employee" id="DOST_employee" required>
                    <option value="" disabled selected>Select an Employee</option>
                {{-- ⚠️ This section must stay empty. Employee list will be loaded via JavaScript only. --}}
                </select>
                </td>
                </tr>

                <tr>
                    <td></td>
                </tr>

                <tr>
                    <td colspan="2" style="text-align: left; font-weight: bold; padding: 15px; background: rgba(38, 58, 156, 0.1);">
                        INSTRUCTIONS:<span style="font-weight:normal"> For SQD 0-8, please put a</span>
                        <span style="font-weight: bold"> check mark (✔)</span>
                        <span style="font-weight:normal"> on the column that best corresponds to your answer.</span>
                        <div style="margin-top: 5px;">
                            <p style="font-weight: bold">❌ - STRONGLY DISAGREE (SD)</p>
                            <p style="font-weight: bold">😕 - DISAGREE (D)</p>
                            <p style="font-weight: bold">😐 - NEITHER AGREE NOR DISAGREE (NAD)</p>
                            <p style="font-weight: bold">🙂 - AGREE (A)</p>
                            <p style="font-weight: bold">😍 - STRONGLY AGREE (SA)</p>
                        </div>
                    </td>
                </tr>
                <table class="criteria-table">
                    <tr>
                        <th colspan="7" class="table-header">CRITERIA</th>
                    </tr>
                    <tr>
                        <th class="question-header">Questions</th>
                        <th class="rating-header">❌<br><span>1</span></th>
                        <th class="rating-header">😕<br><span>2</span></th>
                        <th class="rating-header">😐<br><span>3</span></th>
                        <th class="rating-header">🙂<br><span>4</span></th>
                        <th class="rating-header">😍<br><span>5</span></th>
                        <th class="rating-header">❓<br><span>N/A</span></th>
                    </tr>

                    <tr>
                        <td><strong>SQD0.</strong> <span style="font-weight: normal">I am satisfied with the service that I availed.</span></td>
                        <td><input type="radio" name="SQD0" value="1" required></td>
                        <td><input type="radio" name="SQD0" value="2" required></td>
                        <td><input type="radio" name="SQD0" value="3" required></td>
                        <td><input type="radio" name="SQD0" value="4" required></td>
                        <td><input type="radio" name="SQD0" value="5" required></td>
                        <td><input type="radio" name="SQD0" value="N/A" required></td>
                    </tr>
                    <tr>
                        <td><strong>SQD1.</strong> <span style="font-weight: normal">I spent a reasonable amount of time for my transaction.</span></td>
                        <td><input type="radio" name="SQD1" value="1" required></td>
                        <td><input type="radio" name="SQD1" value="2" required></td>
                        <td><input type="radio" name="SQD1" value="3" required></td>
                        <td><input type="radio" name="SQD1" value="4" required></td>
                        <td><input type="radio" name="SQD1" value="5" required></td>
                        <td><input type="radio" name="SQD1" value="N/A" required></td>
                    </tr>
                    <tr>
                        <td><strong>SQD2.</strong> <span style="font-weight: normal">The office followed the transaction's requirements and steps based on the information provided.</span></td>
                        <td><input type="radio" name="SQD2" value="1" required></td>
                        <td><input type="radio" name="SQD2" value="2" required></td>
                        <td><input type="radio" name="SQD2" value="3" required></td>
                        <td><input type="radio" name="SQD2" value="4" required></td>
                        <td><input type="radio" name="SQD2" value="5" required></td>
                        <td><input type="radio" name="SQD2" value="N/A" required></td>
                    </tr>
                    <tr>
                        <td><strong>SQD3.</strong> <span style="font-weight: normal">The steps (including payment) I needed to do for my transaction were easy and simple.</span></td>
                        <td><input type="radio" name="SQD3" value="1" required></td>
                        <td><input type="radio" name="SQD3" value="2" required></td>
                        <td><input type="radio" name="SQD3" value="3" required></td>
                        <td><input type="radio" name="SQD3" value="4" required></td>
                        <td><input type="radio" name="SQD3" value="5" required></td>
                        <td><input type="radio" name="SQD3" value="N/A" required></td>
                    </tr>
                    <tr>
                        <td><strong>SQD4.</strong> <span style="font-weight: normal">I easily found information about my transaction from the office or its website.</span></td>
                        <td><input type="radio" name="SQD4" value="1" required></td>
                        <td><input type="radio" name="SQD4" value="2" required></td>
                        <td><input type="radio" name="SQD4" value="3" required></td>
                        <td><input type="radio" name="SQD4" value="4" required></td>
                        <td><input type="radio" name="SQD4" value="5" required></td>
                        <td><input type="radio" name="SQD4" value="N/A" required></td>
                    </tr>
                    <tr>
                        <td><strong>SQD5.</strong> <span style="font-weight: normal">I paid a reasonable amount of fees for my transaction. (Cost)</span></td>
                        <td><input type="radio" name="SQD5" value="1" required></td>
                        <td><input type="radio" name="SQD5" value="2" required></td>
                        <td><input type="radio" name="SQD5" value="3" required></td>
                        <td><input type="radio" name="SQD5" value="4" required></td>
                        <td><input type="radio" name="SQD5" value="5" required></td>
                        <td><input type="radio" name="SQD5" value="N/A" required></td>
                    </tr>
                    <tr>
                        <td><strong>SQD6.</strong> <span style="font-weight: normal">I feel the office was fair to everyone, or "walang palakasan", during my transaction.</span></td>
                        <td><input type="radio" name="SQD6" value="1" required></td>
                        <td><input type="radio" name="SQD6" value="2" required></td>
                        <td><input type="radio" name="SQD6" value="3" required></td>
                        <td><input type="radio" name="SQD6" value="4" required></td>
                        <td><input type="radio" name="SQD6" value="5" required></td>
                        <td><input type="radio" name="SQD6" value="N/A" required></td>
                    </tr>
                    <tr>
                        <td><strong>SQD7.</strong> <span style="font-weight: normal">I was treated courteously by the staff, and (if asked for help) the staff was helpful.</span></td>
                        <td><input type="radio" name="SQD7" value="1" required></td>
                        <td><input type="radio" name="SQD7" value="2" required></td>
                        <td><input type="radio" name="SQD7" value="3" required></td>
                        <td><input type="radio" name="SQD7" value="4" required></td>
                        <td><input type="radio" name="SQD7" value="5" required></td>
                        <td><input type="radio" name="SQD7" value="N/A" required></td>
                    </tr>
                    <tr>
                        <td><strong>SQD8.</strong> <span style="font-weight: normal">I got what i needed from the government office, or (if denied) denial of request was sufficiently explained to me.</span></td>
                        <td><input type="radio" name="SQD8" value="1" required></td>
                        <td><input type="radio" name="SQD8" value="2" required></td>
                        <td><input type="radio" name="SQD8" value="3" required></td>
                        <td><input type="radio" name="SQD8" value="4" required></td>
                        <td><input type="radio" name="SQD8" value="5" required></td>
                        <td><input type="radio" name="SQD8" value="N/A" required></td>
                    </tr>
                </table>
                </br>
                <!-- Suggestions/Comments Section -->
                <tr>
                    <td colspan="7" style="text-align: left; padding: 15px;"><strong>
                        Suggestions/Comments on how we can further improve our services (optional):</strong>
                    </td>
                </tr>
                <tr>
                    <td colspan="7">
                        <textarea name="suggestions" rows="4" style="width: 100%; border: 1px solid #ccc; border-radius: 5px; margin-top: 10px;"></textarea>
                    </td>
                </tr>

                <!-- Likert Scale Rating -->
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px;"><strong>
                        Please put a check mark (✔), on a scale of 1 to 10,
                        with 10 being the highest and 1 being the lowest,
                        how likely you are to recommend our programs and services.</strong>
                    </td>
                </tr>

                <!-- Rating Scale Row -->
                <div style="margin-top: 10px;">
                    <tr style="text-align: center; font-weight: bold; font-size: 18px;">
                        <td colspan="7">
                            <label style="color: red; padding: 10px;">
                                <input type="radio" name="recommendation" value="1" required>
                                <span style="border: 2px solid red; padding: 5px 10px; display: inline-block;">01</span>
                            </label>
                            <label style="color: red; padding: 10px;">
                                <input type="radio" name="recommendation" value="2" required>
                                <span style="border: 2px solid red; padding: 5px 10px; display: inline-block;">02</span>
                            </label>
                            <label style="color: orange; padding: 10px;">
                                <input type="radio" name="recommendation" value="3" required>
                                <span style="border: 2px solid orange; padding: 5px 10px; display: inline-block;">03</span>
                            </label>
                            <label style="color: orange; padding: 10px;">
                                <input type="radio" name="recommendation" value="4" required>
                                <span style="border: 2px solid orange; padding: 5px 10px; display: inline-block;">04</span>
                            </label>
                            <label style="color: gold; padding: 10px;">
                                <input type="radio" name="recommendation" value="5" required>
                                <span style="border: 2px solid gold; padding: 5px 10px; display: inline-block;">05</span>
                            </label>
                            <label style="color: gold; padding: 10px;">
                                <input type="radio" name="recommendation" value="6" required>
                                <span style="border: 2px solid gold; padding: 5px 10px; display: inline-block;">06</span>
                            </label>
                            <label style="color: blue; padding: 10px;">
                                <input type="radio" name="recommendation" value="7" required>
                                <span style="border: 2px solid blue; padding: 5px 10px; display: inline-block;">07</span>
                            </label>
                            <label style="color: blue; padding: 10px;">
                                <input type="radio" name="recommendation" value="8" required>
                                <span style="border: 2px solid blue; padding: 5px 10px; display: inline-block;">08</span>
                            </label>
                            <label style="color: green; padding: 10px;">
                                <input type="radio" name="recommendation" value="9" required>
                                <span style="border: 2px solid green; padding: 5px 10px; display: inline-block;">09</span>
                            </label>
                            <label style="color: green; padding: 10px;">
                                <input type="radio" name="recommendation" value="10" required>
                                <span style="border: 2px solid green; padding: 5px 10px; display: inline-block;">10</span>
                            </label>
                        </td>
                    </tr>
                </div>
            </table>
            <button type="submit" class="btn-submit">Submit</button>
        </form>
    </div>
</div>

<!-- JavaScript to auto-set the current date in the date input -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const today = new Date();
    const dd = String(today.getDate()).padStart(2, '0');
    const mm = String(today.getMonth() + 1).padStart(2, '0'); // Months are zero-based
    const yyyy = today.getFullYear();
    const currentDate = `${yyyy}-${mm}-${dd}`;
    document.getElementById("dateInput").value = currentDate;
});

document.addEventListener("DOMContentLoaded", function() {
    const othersRadio = document.getElementById('othersRadio');
    const clientOtherInput = document.getElementById('clientOtherInput');

    function toggleOthers() {
        // Enable textbox only if "Others" is checked
        clientOtherInput.disabled = !othersRadio.checked;
        if (!othersRadio.checked) {
            clientOtherInput.value = ''; // Clear out if not used
        }
    }

    // On page load
    toggleOthers();

    // Listen for any change in the “Client Classification” radios
    document.querySelectorAll('input[name="client_classification"]').forEach(radio => {
        radio.addEventListener('change', toggleOthers);
    });
});
</script>
@endsection
<script>
document.addEventListener('DOMContentLoaded', function () {
    const officeSelect = document.getElementById('office_id');
    const unitSelect = document.getElementById('unit_provider');
    const employeeSelect = document.getElementById('DOST_employee');

    // Load Units based on Office
    officeSelect.addEventListener('change', function () {
        const officeId = this.value;
        unitSelect.innerHTML = '<option value="" disabled selected>Select a Unit</option>';
        employeeSelect.innerHTML = '<option value="" disabled selected>Select an Employee</option>';

        if (officeId) {
            fetch(`/units/by-office/${officeId}`, { cache: 'no-store' })
                .then(res => res.json())
                .then(units => {
                    for (const [id, name] of Object.entries(units)) {
                        unitSelect.insertAdjacentHTML('beforeend', `<option value="${id}">${name}</option>`);
                    }
                });
        }
    });

    // Load Employees based on Unit
    unitSelect.addEventListener('change', function () {
        const unitId = this.value;
        employeeSelect.innerHTML = '<option value="" disabled selected>Select an Employee</option>';

        if (unitId) {
            fetch(`/employees/by-unit/${unitId}`, { cache: 'no-store' })
                .then(res => res.json())
                .then(employees => {
                    const seen = new Set();
                    for (const [id, name] of Object.entries(employees)) {
                        if (!seen.has(name)) {
                            employeeSelect.insertAdjacentHTML('beforeend', `<option value="${id}">${name}</option>`);
                            seen.add(name);
                        }
                    }
                });
        }
    });
});
</script>
@if (session('success'))
    <div id="thankYouPopup" style="
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #4BB543;
        color: white;
        padding: 25px 40px;
        border-radius: 12px;
        font-size: 20px;
        font-weight: bold;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        z-index: 9999;
        display: none;
        text-align: center;
    ">
        {{ session('success') }}
    </div>

    <script>
        window.onload = function () {
            const popup = document.getElementById('thankYouPopup');
            popup.style.display = 'block';

            setTimeout(function () {
                popup.style.display = 'none';
            }, 2000);
        }
    </script>
@endif

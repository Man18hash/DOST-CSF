@extends('layouts.app')

@section('title', 'DOST02 CSF Form')

@section('content')

@if ($errors->any())
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
                            <label><input type="radio" name="sex" value="Male"> Male</label>
                            <label><input type="radio" name="sex" value="Female"> Female</label>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Address:</strong></td>
                        <td><input type="text" name="address" required></td>
                    </tr>
                    <tr>
                        <td><strong>Client Classification:</strong></td>
                        <td class="checkbox-group">
                            <label><input type="checkbox" name="client_classification[]" value="General Public"> General Public</label>
                            <label><input type="checkbox" name="client_classification[]" value="Business"> Business</label>
                            <label><input type="checkbox" name="client_classification[]" value="Government"> Government</label>
                            <label><input type="checkbox" name="client_classification[]" value="Student"> Student</label>
                            <label>
                                <input type="checkbox" name="client_classification[]" value="Others"> Others:
                                <input type="text" name="client_other" placeholder="Specify">
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Client Type:</strong></td>
                        <td class="checkbox-group">
                            <label><input type="radio" name="client_type" value="Internal"> Internal</label>
                            <label><input type="radio" name="client_type" value="External"> External</label>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Date:</strong></td>
                        <td><input type="date" name="date" required></td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: left; font-weight: bold; padding: 15px; background: rgba(38, 58, 156, 0.1);">
                            INSTRUCTIONS: Check mark (✔) <span style="font-weight:normal">on your answers to the question on the Citizen's Charter (CC). It is a document
                                detailing a government agency's services, requirements, fees, and processing times.</span>
                        </td>
                    </tr>

                    <!-- CC1 Selection -->
                    <tr>
                        <td><strong>CC1: Which of the following best describes your awareness of a CC?</strong></td>
                        <td class="checkbox-group">
                            <label><input type="radio" name="CC1" value="I know what a CC is and I saw this office's CC." onclick="toggleCC(false)"> I know what a CC is and I saw this office's CC.</label>
                            <label><input type="radio" name="CC1" value="I know what a CC is but I did not see the office's CC." onclick="toggleCC(false)"> I know what a CC is but I did not see the office's CC.</label>
                            <label><input type="radio" name="CC1" value="I learned of the CC only when I saw this office's CC." onclick="toggleCC(false)"> I learned of the CC only when I saw this office's CC.</label>
                            <label>
                                <input type="radio" name="CC1" id="cc1-no-knowledge" value="I do not know what a CC is and I did not see one in this office." onclick="toggleCC(true)">
                                I do not know what a CC is and I did not see one in this office.
                            </label>
                        </td>
                    </tr>

                    <!-- CC2 and CC3 (Proper Table Rows) -->
                    <tr id="cc-extra-questions">
                        <td><strong>CC2: If aware of CC (answered 1-3 in CC1), would you say that the CC of this office was ...?</strong></td>
                        <td class="checkbox-group">
                            <label><input type="radio" name="CC2" value="Easy to see"> Easy to see</label>
                            <label><input type="radio" name="CC2" value="Somewhat easy to see"> Somewhat easy to see</label>
                            <label><input type="radio" name="CC2" value="Difficult to see"> Difficult to see</label>
                            <label><input type="radio" name="CC2" value="Not visible at all"> Not visible at all</label>
                            <label><input type="radio" name="CC2" value="Not applicable"> Not applicable</label>
                        </td>
                    </tr>
                    <tr id="cc-extra-questions-2">
                        <td><strong>CC3: If aware of CC (answered 1-3 in CC1), how much did the CC help you in your transaction?</strong></td>
                        <td class="checkbox-group">
                            <label><input type="radio" name="CC3" value="Helped very much"> Helped very much</label>
                            <label><input type="radio" name="CC3" value="Somewhat helped"> Somewhat helped</label>
                            <label><input type="radio" name="CC3" value="Did not help"> Did not help</label>
                            <label><input type="radio" name="CC3" value="Not applicable"> Not applicable</label>
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

                    <tr>
                        <td><strong>DOST 02 Office/Unit Provider:</strong></td>
                        <td>
                            <select name="unit_provider" id="unit_provider" required>
                                <option value="" disabled selected>Select an Office/Unit</option>
                                @foreach($unitProviders as $provider)
                                    <option value="{{ $provider->id }}"
                                            {{ $provider->status === 'Inactive' ? 'disabled style=background:#ccc;color:#666' : '' }}>
                                        {{ $provider->unit_name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td><strong>Service/Transaction/Assistance Availed:</strong></td>
                        <td><input type="text" name="assistance_availed" required></td>
                    </tr>

                    <tr>
                        <td><strong>Name of DOST 02 Employee:</strong></td>
                        <td>
                            <select name="DOST_employee" id="DOST_employee" required>
                                <option value="" disabled selected>Select an Employee</option>
                                @foreach($employees as $employee)
                                    @if($employee->status === 'Active')
                                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                    </tr>

                    <script>
                        document.getElementById('unit_provider').addEventListener('change', function() {
                            let unitProviderId = this.value;
                            let employeeDropdown = document.getElementById('DOST_employee');

                            fetch(`/get-employees/${unitProviderId}`)
                                .then(response => response.json())
                                .then(data => {
                                    employeeDropdown.innerHTML = '<option value="" disabled selected>Select an Employee</option>';
                                    for (const [id, name] of Object.entries(data)) {
                                        let option = document.createElement('option');
                                        option.value = id;
                                        option.textContent = name;
                                        employeeDropdown.appendChild(option);
                                    }
                                })
                                .catch(error => console.error('Error fetching employees:', error));
                        });
                    </script>

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
                            <td><input type="radio" name="SQD0" value="1"></td>
                            <td><input type="radio" name="SQD0" value="2"></td>
                            <td><input type="radio" name="SQD0" value="3"></td>
                            <td><input type="radio" name="SQD0" value="4"></td>
                            <td><input type="radio" name="SQD0" value="5"></td>
                            <td><input type="radio" name="SQD0" value="N/A"></td>
                        </tr>
                        <tr>
                            <td><strong>SQD1.</strong> <span style="font-weight: normal">I spent a reasonable amount of time for my transaction.</span></td>
                            <td><input type="radio" name="SQD1" value="1"></td>
                            <td><input type="radio" name="SQD1" value="2"></td>
                            <td><input type="radio" name="SQD1" value="3"></td>
                            <td><input type="radio" name="SQD1" value="4"></td>
                            <td><input type="radio" name="SQD1" value="5"></td>
                            <td><input type="radio" name="SQD1" value="N/A"></td>
                        </tr>
                        <tr>
                            <td><strong>SQD2.</strong> <span style="font-weight: normal">The office followed the transaction's requirements and steps based on the information provided.</span></td>
                            <td><input type="radio" name="SQD2" value="1"></td>
                            <td><input type="radio" name="SQD2" value="2"></td>
                            <td><input type="radio" name="SQD2" value="3"></td>
                            <td><input type="radio" name="SQD2" value="4"></td>
                            <td><input type="radio" name="SQD2" value="5"></td>
                            <td><input type="radio" name="SQD2" value="N/A"></td>
                        </tr>
                        <tr>
                            <td><strong>SQD3.</strong> <span style="font-weight: normal">The steps (including payment) I needed to do for my transaction were easy and simple.</span></td>
                            <td><input type="radio" name="SQD3" value="1"></td>
                            <td><input type="radio" name="SQD3" value="2"></td>
                            <td><input type="radio" name="SQD3" value="3"></td>
                            <td><input type="radio" name="SQD3" value="4"></td>
                            <td><input type="radio" name="SQD3" value="5"></td>
                            <td><input type="radio" name="SQD3" value="N/A"></td>
                        </tr>
                        <tr>
                            <td><strong>SQD4.</strong> <span style="font-weight: normal">I easily found information about my transaction from the office or its website.</span></td>
                            <td><input type="radio" name="SQD4" value="1"></td>
                            <td><input type="radio" name="SQD4" value="2"></td>
                            <td><input type="radio" name="SQD4" value="3"></td>
                            <td><input type="radio" name="SQD4" value="4"></td>
                            <td><input type="radio" name="SQD4" value="5"></td>
                            <td><input type="radio" name="SQD4" value="N/A"></td>
                        </tr>
                        <tr>
                            <td><strong>SQD5.</strong> <span style="font-weight: normal">I paid a reasonable amount of fees for my transaction. (Cost)</span></td>
                            <td><input type="radio" name="SQD5" value="1"></td>
                            <td><input type="radio" name="SQD5" value="2"></td>
                            <td><input type="radio" name="SQD5" value="3"></td>
                            <td><input type="radio" name="SQD5" value="4"></td>
                            <td><input type="radio" name="SQD5" value="5"></td>
                            <td><input type="radio" name="SQD5" value="N/A"></td>
                        </tr>
                        <tr>
                            <td><strong>SQD6.</strong> <span style="font-weight: normal">I feel the office was fair to everyone, or "walang palakasan", during my transaction.</span></td>
                            <td><input type="radio" name="SQD6" value="1"></td>
                            <td><input type="radio" name="SQD6" value="2"></td>
                            <td><input type="radio" name="SQD6" value="3"></td>
                            <td><input type="radio" name="SQD6" value="4"></td>
                            <td><input type="radio" name="SQD6" value="5"></td>
                            <td><input type="radio" name="SQD6" value="N/A"></td>
                        </tr>
                        <tr>
                            <td><strong>SQD7.</strong> <span style="font-weight: normal">I was treated courteously by the staff, and (if asked for help) the staff was helpful.</span></td>
                            <td><input type="radio" name="SQD7" value="1"></td>
                            <td><input type="radio" name="SQD7" value="2"></td>
                            <td><input type="radio" name="SQD7" value="3"></td>
                            <td><input type="radio" name="SQD7" value="4"></td>
                            <td><input type="radio" name="SQD7" value="5"></td>
                            <td><input type="radio" name="SQD7" value="N/A"></td>
                        </tr>
                        <tr>
                            <td><strong>SQD8.</strong> <span style="font-weight: normal">I got what i needed from the government office, or (if denied) denial of request was sufficiently explained to me.</span></td>
                            <td><input type="radio" name="SQD8" value="1"></td>
                            <td><input type="radio" name="SQD8" value="2"></td>
                            <td><input type="radio" name="SQD8" value="3"></td>
                            <td><input type="radio" name="SQD8" value="4"></td>
                            <td><input type="radio" name="SQD8" value="5"></td>
                            <td><input type="radio" name="SQD8" value="N/A"></td>
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
                        <tr style="text-align: center; font-weight: bold; font-size: 18px; ">
                            <td colspan="7">
                                <label style="color: red; padding: 10px;">
                                    <input type="radio" name="recommendation" value="1">
                                    <span style="border: 2px solid red; padding: 5px 10px; display: inline-block;">01</span>
                                </label>
                                <label style="color: red; padding: 10px;">
                                    <input type="radio" name="recommendation" value="2">
                                    <span style="border: 2px solid red; padding: 5px 10px; display: inline-block;">02</span>
                                </label>
                                <label style="color: orange; padding: 10px;">
                                    <input type="radio" name="recommendation" value="3">
                                    <span style="border: 2px solid orange; padding: 5px 10px; display: inline-block;">03</span>
                                </label>
                                <label style="color: orange; padding: 10px;">
                                    <input type="radio" name="recommendation" value="4">
                                    <span style="border: 2px solid orange; padding: 5px 10px; display: inline-block;">04</span>
                                </label>
                                <label style="color: gold; padding: 10px;">
                                    <input type="radio" name="recommendation" value="5">
                                    <span style="border: 2px solid gold; padding: 5px 10px; display: inline-block;">05</span>
                                </label>
                                <label style="color: gold; padding: 10px;">
                                    <input type="radio" name="recommendation" value="6">
                                    <span style="border: 2px solid gold; padding: 5px 10px; display: inline-block;">06</span>
                                </label>
                                <label style="color: blue; padding: 10px;">
                                    <input type="radio" name="recommendation" value="7">
                                    <span style="border: 2px solid blue; padding: 5px 10px; display: inline-block;">07</span>
                                </label>
                                <label style="color: blue; padding: 10px;">
                                    <input type="radio" name="recommendation" value="8">
                                    <span style="border: 2px solid blue; padding: 5px 10px; display: inline-block;">08</span>
                                </label>
                                <label style="color: green; padding: 10px;">
                                    <input type="radio" name="recommendation" value="9">
                                    <span style="border: 2px solid green; padding: 5px 10px; display: inline-block;">09</span>
                                </label>
                                <label style="color: green; padding: 10px;">
                                    <input type="radio" name="recommendation" value="10">
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
@endsection

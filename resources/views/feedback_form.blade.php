@extends('layouts.app')

@section('title', 'DOST02 CSF Form')

@section('content')
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
            <form method="POST" action="{{ route('feedback.store') }}" class="feedback-form">
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
                            INSTRUCTIONS: Write legibly or check mark (✔) on the following basic information. <p style="font-weight:normal">[Sumulat ng malinaw o lagyan ng tsek (✔) sa sumusunod na pangunahing impormasyon.]</p>
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
                </table>
                <button type="submit" class="btn-submit">Submit</button>
            </form>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('title', 'DOST02 CSF Form')

@section('content')
    <div class="content-wrapper">
        <!-- Title Section -->
        <div class="form-container1">
            <h1 class="title-text">CUSTOMER SATISFACTION FEEDBACK</h1>
        </div>

        <!-- Form Section -->
        <div class="form-container2">
            <form method="POST" action="{{ route('feedback.store') }}" class="feedback-form">
                @csrf
                <table class="feedback-table">
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

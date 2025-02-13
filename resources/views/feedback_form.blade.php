@extends('layouts.app')

@section('title', 'Feedback Form')

@section('content')
    <div class="form-container">
        <form method="POST" action="{{ route('feedback.store') }}">
            @csrf

            <table id="formTable">
                <thead>
                    <tr>
                        <th>Field Name</th>
                        <th>Input Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="formBody">
                    <tr>
                        <td><input type="text" name="field_name[]" placeholder="Enter field name"></td>
                        <td>
                            <select name="field_type[]">
                                <option value="text">Text</option>
                                <option value="email">Email</option>
                                <option value="number">Number</option>
                                <option value="textarea">Textarea</option>
                            </select>
                        </td>
                        <td>
                            <button type="button" class="btn btn-delete" onclick="deleteRow(this)">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <button type="button" class="btn btn-add" onclick="addRow()">+ Add Field</button>
            <br><br>
            <button type="submit" class="btn btn-submit">Submit</button>
        </form>
    </div>

    <script>
        function addRow() {
            let table = document.getElementById("formBody");
            let newRow = document.createElement("tr");

            newRow.innerHTML = `
                <td><input type="text" name="field_name[]" placeholder="Enter field name"></td>
                <td>
                    <select name="field_type[]">
                        <option value="text">Text</option>
                        <option value="email">Email</option>
                        <option value="number">Number</option>
                        <option value="textarea">Textarea</option>
                    </select>
                </td>
                <td>
                    <button type="button" class="btn btn-delete" onclick="deleteRow(this)">Delete</button>
                </td>
            `;

            table.appendChild(newRow);
        }

        function deleteRow(button) {
            let row = button.parentElement.parentElement;
            row.remove();
        }
    </script>
@endsection

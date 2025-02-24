<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Form</title>
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
            <li><a href="{{ route('admin.manage_form') }}" class="{{ request()->is('admin/manage-form') ? 'active' : '' }}">Manage Form</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="dashboard-header">
            <div class="welcome-text">
                <h1>📋 Manage Form</h1>
            </div>
        </div>

        <div class="content-wrapper">
            <!-- Title Section -->
            <div class="form-container1">
                <h1 style="font-size: 30px" class="title-text">MANAGE FEEDBACK FORM</h1>
                <h4 style="letter-spacing: 1px" class="title-text"><i>Edit, add, or remove fields dynamically.</i></h4>
            </div>

            <!-- Form Section -->
            <div class="form-container2">
                <form method="POST" action="{{ route('admin.manage_form.update') }}">
                    @csrf

                    <table class="feedback-table">
                        <tr>
                            <td colspan="2" style="text-align: center; font-weight: bold; padding: 15px; background: rgba(38, 58, 156, 0.1);">
                                Modify the fields below. Changes will be reflected in the feedback form.
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" style="text-align: left; font-weight: bold; padding: 15px; background: rgba(38, 58, 156, 0.1);">
                                Editable Fields:
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <div id="form-fields">
                                    @php
                                        $fields = $formSetting->fields ?? [];
                                    @endphp
                                    @foreach($fields as $index => $field)
                                        <div class="form-group">
                                            <input type="text" name="fields[{{ $index }}]" value="{{ $field }}" required style="width: 70%; padding: 10px; margin: 5px;" readonly>
                                            <button type="button" class="edit-btn" onclick="editField(this)">Edit</button>
                                            <button type="button" class="remove-btn" onclick="removeField(this)">Remove</button>
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2">
                                <button type="button" class="btn-add" onclick="addField()">+ Add Field</button>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" style="text-align: center; padding: 10px;">
                                <button type="submit" class="btn-submit">Save Changes</button>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>

    <script>
        function addField() {
            let container = document.getElementById('form-fields');
            let index = container.children.length;
            let div = document.createElement('div');
            div.classList.add('form-group');
            div.innerHTML = `
                <input type="text" name="fields[${index}]" required style="width: 70%; padding: 10px; margin: 5px;">
                <button type="button" class="edit-btn" onclick="editField(this)">Edit</button>
                <button type="button" class="remove-btn" onclick="removeField(this)">Remove</button>`;
            container.appendChild(div);
        }

        function removeField(button) {
            button.parentElement.remove();
        }

        function editField(button) {
            let inputField = button.previousElementSibling;
            if (inputField.readOnly) {
                inputField.readOnly = false;
                inputField.focus();
                button.innerText = "Save";
            } else {
                inputField.readOnly = true;
                button.innerText = "Edit";
            }
        }
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


    <style>
        .btn-add {
            background-color: #2ecc71;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            margin-top: 10px;
            border-radius: 5px;
        }

        .btn-add:hover {
            background-color: #27ae60;
        }

        .remove-btn {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            margin-left: 10px;
            border-radius: 5px;
        }

        .remove-btn:hover {
            background-color: #c0392b;
        }

        .edit-btn {
            background-color: #f39c12;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            margin-left: 10px;
            border-radius: 5px;
        }

        .edit-btn:hover {
            background-color: #e67e22;
        }

        .btn-submit {
            background-color: #3498db;
            color: white;
            padding: 10px 30px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
        }

        .btn-submit:hover {
            background-color: #2980b9;
        }
    </style>

</body>
</html>

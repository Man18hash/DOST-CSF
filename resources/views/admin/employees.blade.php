<!-- resources/views/admin/employees.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Manage Employees</title>
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
      <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard')?'active':'' }}">Dashboard</a></li>
      <li><a href="{{ route('admin.respondents') }}" class="{{ request()->routeIs('admin.respondents')?'active':'' }}">Respondents</a></li>
      <li class="dropdown">
        <a href="#" class="dropdown-btn" onclick="toggleDropdown('yearDropdown', event)">Years ▼</a>
        <div class="dropdown-container" id="yearDropdown">
          <ul class="dropdown-content">
            <li><a href="{{ route('admin.respondents') }}">All Years</a></li>
          </ul>
        </div>
      </li>
      <li class="dropdown">
        <a href="#" class="dropdown-btn" onclick="toggleDropdown('manageDropdown', event)">Manage Offices/Units/Employees ▼</a>
        <div class="dropdown-container" id="manageDropdown">
          <ul class="dropdown-content">
            <li><a href="{{ route('admin.offices') }}" class="{{ request()->routeIs('admin.offices')?'active':'' }}">Offices</a></li>
            <li><a href="{{ route('admin.units') }}" class="{{ request()->routeIs('admin.units')?'active':'' }}">Units</a></li>
            <li><a href="{{ route('admin.employees') }}" class="{{ request()->routeIs('admin.employees')?'active':'' }}">Employees</a></li>
          </ul>
        </div>
      </li>
    </ul>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <div class="dashboard-header" style="display:flex; align-items:center;">
      <h1>👥 Manage Employees</h1>
      <!-- Create Employee Button -->
      <button type="button"
              class="btn btn-primary"
              style="margin-left:auto; background-color:#1abc9c; color:white; padding:10px 20px; border:none; border-radius:5px;"
              onclick="openCreateEmployeeModal()">
        Create Employee
      </button>
    </div>

    <div class="table-container">
      <h3>DOST Employees</h3>
      <table class="respondents-table">
        <thead>
          <tr>
            <th>Name</th>
            <th>Employee ID</th>
            <th>Unit</th>
            <th>Status</th>
            <th style="min-width:200px;">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($employees as $emp)
          <tr>
            <td>{{ $emp->name }}</td>
            <td>{{ $emp->employee_id }}</td>
            <td>{{ $emp->unitProvider->unit_name ?? '—' }}</td>
            <td id="emp-status-{{ $emp->id }}">{{ $emp->status }}</td>
            <td>
              <button class="btn-status {{ $emp->status==='Active'?'btn-danger':'btn-success' }}"
                      onclick="toggleStatus('{{ route('admin.toggle_employee_status', $emp->id) }}','emp-status-{{ $emp->id }}')">
                {{ $emp->status==='Active'?'Deactivate':'Activate' }}
              </button>
              <button type="button"
                      class="btn"
                      style="background-color:#3498db;color:white;padding:6px 12px;border:none;border-radius:4px;margin-left:8px;"
                      onclick="openEditEmployeeModal(
                        {{ $emp->id }}, 
                        {{ optional(optional($emp->unitProvider)->office)->id ?? 'null' }}, 
                        {{ $emp->unitProvider->id ?? 'null' }}, 
                        '{{ addslashes($emp->name) }}',
                        '{{ addslashes($emp->employee_id) }}'
                      )">
                Edit
              </button>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

{{-- Modals Styles --}}
<style>
  .modal { display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); align-items:center; justify-content:center; z-index:999; }
  .modal-content { background:#fff; padding:20px; border-radius:6px; width:360px; }
  .modal-content h3 { margin-top:0; }
  .modal-content input, .modal-content select { width:100%; padding:8px; margin:10px 0; box-sizing:border-box; }
  .modal-content .buttons { text-align:right; }
  .modal-content .buttons button { margin-left:8px; padding:6px 12px; border:none; border-radius:4px; cursor:pointer; }
</style>

{{-- Create Employee Modal --}}
<div id="create-employee-modal" class="modal">
  <div class="modal-content">
    <h3>Create Employee</h3>
    <form method="POST" action="{{ route('admin.employees.store') }}">
      @csrf
      <label>Office</label>
      <select name="office_id" id="create-office-select" required onchange="filterEmployeeUnits('create')">
        <option value="">-- Select Office --</option>
        @foreach($offices as $office)
          <option value="{{ $office->id }}">{{ $office->name }}</option>
        @endforeach
      </select>

      <label>Unit</label>
      <select name="unit_provider_id" id="create-unit-select" required disabled>
        <option value="">-- Select Unit --</option>
        @foreach($unitProviders as $unit)
          <option value="{{ $unit->id }}" data-office="{{ $unit->office->id }}">{{ $unit->unit_name }}</option>
        @endforeach
      </select>

      <label>Name</label>
      <input type="text" name="name" placeholder="Enter name" required>

      <label>Employee ID</label>
      <input type="text" name="employee_id" placeholder="Enter employee ID" required>

      <div class="buttons">
        <button type="button" onclick="closeModal('create-employee-modal')">Cancel</button>
        <button type="submit">Save</button>
      </div>
    </form>
  </div>
</div>

{{-- Edit Employee Modal --}}
<div id="edit-employee-modal" class="modal">
  <div class="modal-content">
    <h3>Edit Employee</h3>
    <form id="edit-employee-form" method="POST" action="">
      @csrf
      @method('PUT')

      <label>Office</label>
      <select name="office_id" id="edit-office-select" required onchange="filterEmployeeUnits('edit')">
        <option value="">-- Select Office --</option>
        @foreach($offices as $office)
          <option value="{{ $office->id }}">{{ $office->name }}</option>
        @endforeach
      </select>

      <label>Unit</label>
      <select name="unit_provider_id" id="edit-unit-select" required disabled>
        <option value="">-- Select Unit --</option>
        @foreach($unitProviders as $unit)
          <option value="{{ $unit->id }}" data-office="{{ $unit->office->id }}">{{ $unit->unit_name }}</option>
        @endforeach
      </select>

      <label>Name</label>
      <input type="text" name="name" id="edit-name" placeholder="Enter name" required>

      <label>Employee ID</label>
      <input type="text" name="employee_id" id="edit-emp-id" placeholder="Enter employee ID" required>

      <div class="buttons">
        <button type="button" onclick="closeModal('edit-employee-modal')">Cancel</button>
        <button type="submit">Update</button>
      </div>
    </form>
  </div>
</div>

<script>
  // Dropdown handling
  function toggleDropdown(id, evt) {
    evt.stopPropagation();
    document.querySelectorAll('.dropdown-container').forEach(c=>c.style.display='none');
    let el = document.getElementById(id);
    el.style.display = el.style.display==='block'?'none':'block';
  }
  document.addEventListener('click', ()=>{ document.querySelectorAll('.dropdown-container').forEach(c=>c.style.display='none'); });

  // Toggle status via AJAX
  function toggleStatus(url, statusId) {
    fetch(url, {
      method:'POST',
      headers:{
        'X-CSRF-TOKEN':'{{ csrf_token() }}',
        'Content-Type':'application/json'
      }
    })
    .then(r=>r.json())
    .then(data=>{
      if(data.success) {
        let cell = document.getElementById(statusId);
        let btn  = cell.closest('tr').querySelector('.btn-status');
        cell.innerText = data.status;
        if(data.status==='Active') {
          btn.classList.replace('btn-success','btn-danger');
          btn.innerText='Deactivate';
        } else {
          btn.classList.replace('btn-danger','btn-success');
          btn.innerText='Activate';
        }
      }
    })
    .catch(console.error);
  }

  // Filter units based on office
  function filterEmployeeUnits(type) {
    let officeSel = document.getElementById(type+'-office-select');
    let unitSel   = document.getElementById(type+'-unit-select');
    let selOffice = officeSel.value;
    unitSel.disabled = !selOffice;
    Array.from(unitSel.options).forEach(opt => {
      if(!opt.dataset.office) return;
      opt.style.display = (opt.dataset.office==selOffice)?'':'none';
    });
    unitSel.value = '';
  }

  // Modal controls
  function openCreateEmployeeModal() {
    document.getElementById('create-office-select').value = '';
    filterEmployeeUnits('create');
    document.getElementById('create-employee-modal').style.display = 'flex';
  }
  function openEditEmployeeModal(id, officeId, unitId, name, empId) {
    let form = document.getElementById('edit-employee-form');
    form.action = `{{ route("admin.employees.update", ["employee"=>":id"]) }}`.replace(':id', id);
    document.getElementById('edit-office-select').value = officeId || '';
    filterEmployeeUnits('edit');
    document.getElementById('edit-unit-select').value = unitId || '';
    document.getElementById('edit-name').value = name;
    document.getElementById('edit-emp-id').value = empId;
    document.getElementById('edit-employee-modal').style.display = 'flex';
  }
  function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
  }
  window.onclick = e => { if(e.target.classList.contains('modal')) e.target.style.display='none'; };
</script>
</body>
</html>

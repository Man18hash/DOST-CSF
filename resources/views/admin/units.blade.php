<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Manage Units</title>
  <link rel="stylesheet" href="{{ asset('css/style2.css') }}">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>

<div class="admin-container">
  <!-- Sidebar -->
  <div class="sidebar">
    <div class="sidebar-header">
      <img src="{{ asset('images/dost-logo.png') }}" alt="DOST Logo" class="sidebar-logo">
      <span class="sidebar-title">DOST CSF</span>
    </div>
    <ul class="sidebar-menu">
      
      <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->is('admin/dashboard')?'active':'' }}">Dashboard</a></li>
      <li><a href="{{ route('admin.respondents') }}" class="{{ request()->is('admin/respondents')?'active':'' }}">Respondents</a></li>

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
          <li><a href="{{ route('admin.offices') }}" class="{{ request()->is('admin/offices')?'active':'' }}">Offices</a></li>
            <li><a href="{{ route('admin.units') }}" class="{{ request()->is('admin/units')?'active':'' }}">Units</a></li>
            <li><a href="{{ route('admin.employees') }}" class="{{ request()->is('admin/employees')?'active':'' }}">Employees</a></li>
          </ul>
        </div>
      </li>
    </ul>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <div class="dashboard-header" style="display:flex; align-items:center;">
      <h1>🏢 Manage Units</h1>
      <button type="button"
              class="btn btn-primary"
              style="margin-left:auto; background-color:#1abc9c; color:white; padding:10px 20px; border:none; border-radius:5px;"
              onclick="openCreateModal()">
        Create Unit
      </button>
    </div>

    <div class="table-container">
      <h3>Unit Providers</h3>
      <table class="respondents-table">
        <thead>
          <tr>
            <th>Office</th>
            <th>Unit Name</th>
            <th>Status</th>
            <th style="min-width:200px;">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($unitProviders as $unit)
          <tr>
            <td>{{ $unit->office->name ?? '—' }}</td>
            <td>{{ $unit->unit_name }}</td>
            <td id="unit-status-{{ $unit->id }}">{{ $unit->status }}</td>
            <td>
              <button class="btn-status {{ $unit->status==='Active'?'btn-danger':'btn-success' }}"
                      onclick="toggleStatus('{{ route('admin.toggle_unit_status',$unit->id) }}','unit-status-{{ $unit->id }}')">
                {{ $unit->status==='Active'?'Deactivate':'Activate' }}
              </button>

              <button type="button"
                      class="btn"
                      style="background-color:#3498db;color:white;padding:6px 12px;border:none;border-radius:4px;margin-left:8px;"
                      onclick="openEditModal({{ $unit->id }}, {{ $unit->office->id ?? 'null' }}, '{{ addslashes($unit->unit_name) }}')">
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

{{-- Create & Edit Modals --}}
<style>
  .modal {
    display: none;
    position: fixed;
    top:0; left:0;
    width:100%; height:100%;
    background: rgba(0,0,0,0.5);
    align-items:center;
    justify-content:center;
    z-index:999;
  }
  .modal-content {
    background:#fff;
    padding:20px;
    border-radius:6px;
    width:350px;
  }
  .modal-content h3 { margin-top:0; }
  .modal-content input, .modal-content select {
    width:100%; padding:8px; margin:10px 0; box-sizing:border-box;
  }
  .modal-content .buttons { text-align:right; }
  .modal-content .buttons button {
    margin-left:8px; padding:6px 12px;border:none;border-radius:4px;cursor:pointer;
  }
</style>

{{-- Create Unit Modal --}}
<div id="create-unit-modal" class="modal">
  <div class="modal-content">
    <h3>Create Unit</h3>
    <form method="POST" action="{{ route('admin.units.store') }}">
      @csrf
      <label>Office</label>
      <select name="office_id" required>
        <option value="">-- Select Office --</option>
        @foreach($offices as $office)
          <option value="{{ $office->id }}">{{ $office->name }}</option>
        @endforeach
      </select>

      <label>Unit Name</label>
      <input type="text" name="unit_name" placeholder="Enter unit name" required>

      <div class="buttons">
        <button type="button" onclick="closeModal('create-unit-modal')">Cancel</button>
        <button type="submit">Save</button>
      </div>
    </form>
  </div>
</div>

{{-- Edit Unit Modal --}}
<div id="edit-unit-modal" class="modal">
  <div class="modal-content">
    <h3>Edit Unit</h3>
    <form id="edit-unit-form" method="POST" action="">
      @csrf
      @method('PUT')

      <label>Office</label>
      <select name="office_id" id="edit-office-select" required>
        <option value="">-- Select Office --</option>
        @foreach($offices as $office)
          <option value="{{ $office->id }}">{{ $office->name }}</option>
        @endforeach
      </select>

      <label>Unit Name</label>
      <input type="text" name="unit_name" id="edit-unit-name" placeholder="Enter unit name" required>

      <div class="buttons">
        <button type="button" onclick="closeModal('edit-unit-modal')">Cancel</button>
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
  document.addEventListener('click', ()=> {
    document.querySelectorAll('.dropdown-container').forEach(c=>c.style.display='none');
  });

  // Status toggle via AJAX
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
          btn.innerText = 'Deactivate';
        } else {
          btn.classList.replace('btn-danger','btn-success');
          btn.innerText = 'Activate';
        }
      }
    })
    .catch(console.error);
  }

  // Modal controls
  function openCreateModal() {
    document.getElementById('create-unit-modal').style.display = 'flex';
  }
  function openEditModal(id, officeId, unitName) {
    let form = document.getElementById('edit-unit-form');
    form.action = '{{ url("admin/units") }}/' + id;
    document.getElementById('edit-office-select').value = officeId;
    document.getElementById('edit-unit-name').value = unitName;
    document.getElementById('edit-unit-modal').style.display = 'flex';
  }
  function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
  }

  // Close when clicking outside modal
  window.onclick = (e) => {
    if (e.target.classList.contains('modal')) {
      e.target.style.display = 'none';
    }
  };
</script>

</body>
</html>

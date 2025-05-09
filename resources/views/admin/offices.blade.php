<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Offices</title>
  <link rel="stylesheet" href="{{ asset('css/style2.css') }}">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    /* Modal overlay */
    .modal {
      display: none;
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.5);
      align-items: center;
      justify-content: center;
      z-index: 999;
    }
    .modal-content {
      background: #fff;
      padding: 20px;
      border-radius: 6px;
      width: 320px;
    }
    .modal-content h3 { margin-top: 0; }
    .modal-content input[type="text"] {
      width: 100%; padding: 8px; margin: 12px 0; box-sizing: border-box;
    }
    .modal-content .buttons {
      text-align: right;
    }
    .modal-content .buttons button {
      margin-left: 8px; padding: 6px 12px;
      border: none; border-radius: 4px; cursor: pointer;
    }
  </style>
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
      <li>
        <a href="{{ route('admin.dashboard') }}"
           class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
          Dashboard
        </a>
      </li>
      <li>
        <a href="{{ route('admin.respondents') }}"
           class="{{ request()->is('admin/respondents') ? 'active' : '' }}">
          Respondents
        </a>
      </li>

      <!-- Years Dropdown -->
      <li class="dropdown">
        <a href="javascript:void(0)"
           class="dropdown-btn"
           onclick="toggleDropdown('yearDropdownContainer', event)">
          Years ▼
        </a>
        <div class="dropdown-container" id="yearDropdownContainer">
          <ul class="dropdown-content" id="yearDropdown">
            <li><a href="{{ route('admin.respondents') }}">All Years</a></li>
          </ul>
        </div>
      </li>

      <!-- Manage Units & Employees Dropdown -->
      <li class="dropdown">
        <a href="javascript:void(0)"
           class="dropdown-btn"
           onclick="toggleDropdown('manageDropdownContainer', event)">
          Manage Units/Employees ▼
        </a>
        <div class="dropdown-container" id="manageDropdownContainer">
          <ul class="dropdown-content">
            <li>
              <a href="{{ route('admin.offices') }}"
                 class="{{ request()->is('admin/offices') ? 'active' : '' }}">
                office
              </a>
            </li>
            <li>
              <a href="{{ route('admin.units') }}"
                 class="{{ request()->is('admin/units') ? 'active' : '' }}">
                Units
              </a>
            </li>
            <li>
              <a href="{{ route('admin.employees') }}"
                 class="{{ request()->is('admin/employees') ? 'active' : '' }}">
                Employees
              </a>
            </li>
          </ul>
        </div>
      </li>
    </ul>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <div class="dashboard-header" style="display:flex; align-items:center;">
      <h1>🏢 Manage Offices</h1>
      <button type="button"
              class="btn btn-primary"
              style="margin-left:auto; background-color:#1abc9c; color:white; padding:10px 20px; border:none; border-radius:5px;"
              onclick="openCreateModal()">
        Create Office
      </button>
    </div>

    <div class="table-container">
      <h3>Office List</h3>
      <table class="respondents-table">
        <thead>
          <tr>
            <th>Name</th>
            <th>Status</th>
            <th style="min-width:200px;">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($offices as $office)
            <tr>
              <td>{{ $office->name }}</td>
              <td id="office-status-{{ $office->id }}">{{ $office->status }}</td>
              <td>
                <!-- Toggle Active/Inactive -->
                <button
                  class="btn-status {{ $office->status==='Active'?'btn-danger':'btn-success' }}"
                  onclick="toggleStatus(
                    '{{ route('admin.offices.toggle_status',$office->id) }}',
                    'office-status-{{ $office->id }}'
                  )">
                  {{ $office->status==='Active'?'Deactivate':'Activate' }}
                </button>

                <!-- Edit -->
                <button type="button"
                        class="btn"
                        style="background-color:#3498db;color:white;padding:6px 12px;border:none;border-radius:4px;margin-left:8px;"
                        onclick="openEditModal({{ $office->id }}, '{{ addslashes($office->name) }}')">
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

<!-- Shared Create/Edit Modal -->
<div id="office-modal" class="modal">
  <div class="modal-content">
    <h3 id="modal-title">Modal</h3>
    <form id="office-form" method="POST" action="">
      @csrf
      <input type="text" name="name" id="office-name" placeholder="Office name" required>
      <div class="buttons">
        <button type="button" onclick="closeModal()">Cancel</button>
        <button type="submit">Save</button>
      </div>
    </form>
  </div>
</div>

<script>
  // Prevent dropdown from immediately closing
  function toggleDropdown(id, evt) {
    evt.stopPropagation();
    document.querySelectorAll('.dropdown-container').forEach(dc => {
      if (dc.id !== id) dc.style.display = 'none';
    });
    let el = document.getElementById(id);
    el.style.display = (el.style.display === 'block' ? 'none' : 'block');
  }
  document.addEventListener('click', () => {
    document.querySelectorAll('.dropdown-container')
            .forEach(dc => dc.style.display = 'none');
  });

  // Office modal logic
  const indexRoute = "{{ route('admin.offices') }}";

  function openCreateModal() {
    document.getElementById('modal-title').innerText = 'Create Office';
    document.getElementById('office-form').action = indexRoute;
    let old = document.querySelector('#office-form input[name="_method"]');
    if (old) old.remove();
    document.getElementById('office-name').value = '';
    document.getElementById('office-modal').style.display = 'flex';
  }

  function openEditModal(id, name) {
    document.getElementById('modal-title').innerText = 'Edit Office';
    document.getElementById('office-form').action = indexRoute + '/' + id;
    let methodInput = document.querySelector('#office-form input[name="_method"]');
    if (!methodInput) {
      methodInput = document.createElement('input');
      methodInput.type = 'hidden';
      methodInput.name = '_method';
      document.getElementById('office-form').appendChild(methodInput);
    }
    methodInput.value = 'PUT';
    document.getElementById('office-name').value = name;
    document.getElementById('office-modal').style.display = 'flex';
  }

  function closeModal() {
    document.getElementById('office-modal').style.display = 'none';
  }

  // AJAX toggle status
  function toggleStatus(url, statusElId) {
    fetch(url, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Content-Type':'application/json'
      }
    })
    .then(r => r.json())
    .then(data => {
      if (data.success) {
        let statusEl = document.getElementById(statusElId);
        let btn      = statusEl.closest('tr').querySelector('.btn-status');
        statusEl.innerText = data.status;
        if (data.status==='Active') {
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

  // Populate years dropdown dynamically
  document.addEventListener('DOMContentLoaded', () => {
    fetch("{{ route('admin.years') }}")
      .then(r => r.json())
      .then(years => {
        let list = document.getElementById('yearDropdown');
        years.forEach(y => {
          let li = document.createElement('li');
          li.innerHTML = `<a href="{{ url('admin/respondents/filter') }}/${y}">${y}</a>`;
          list.appendChild(li);
        });
      });
  });
</script>

</body>
</html>

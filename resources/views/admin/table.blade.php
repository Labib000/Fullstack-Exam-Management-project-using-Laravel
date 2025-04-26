@extends('layout.sidebar')
@section('content')
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: url('{{ asset('images/bg-wave.svg') }}') no-repeat top center;
        background-size: cover;
        position: relative;
    }

    .container {
        max-width: 100%;
        overflow-x: auto;
        background-color: #f9f9f9;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    h2 {
        text-align: center;
        color: #003366;
        margin-bottom: 20px;
    }

    .status-buttons {
        text-align: center;
        margin-bottom: 20px;
    }

    .status-buttons button {
        padding: 10px 20px;
        margin: 0 5px;
        background-color: #004b91;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
    }

    .status-buttons button:hover {
        background-color: #0061c2;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 1200px;
        margin-top: 10px;
    }

    thead {
        background-color: #003366;
        color: #fff;
    }

    th, td {
        padding: 12px 15px;
        border: 1px solid #ccc;
        text-align: left;
    }

    tr:nth-child(even) {
        background-color: #eef2f5;
    }

    tr:hover {
        background-color: #e0efff;
    }

    .action-btn {
        padding: 6px 10px;
        border-radius: 5px;
        margin: 2px;
        font-size: 13px;
        cursor: pointer;
        border: none;
    }

    .edit-btn {
        background-color: #007bff;
        color: white;
    }

    .edit-btn:hover {
        background-color: #0056b3;
    }

    .delete-btn {
        background-color: #dc3545;
        color: white;
    }

    .delete-btn:hover {
        background-color: #a71d2a;
    }

    .approve-btn {
        background-color: #28a745;
        color: white;
    }

    .approve-btn:hover {
        background-color: #1e7e34;
    }

    @media screen and (max-width: 768px) {
        table, thead, tbody, th, td, tr {
            display: block;
        }

        thead tr {
            display: none;
        }

        tr {
            margin-bottom: 15px;
            background: #fff;
            padding: 10px;
            border: 1px solid #ddd;
        }

        td {
            padding-left: 50%;
            position: relative;
            text-align: left;
            border: none;
            border-bottom: 1px solid #eee;
        }

        td::before {
            content: attr(data-label);
            position: absolute;
            left: 10px;
            top: 12px;
            display: block;
            color: #555;
            font-weight: bold;
        }
    }
</style>

<div class="container">
    <h2>Registered Students</h2>

    <div class="status-buttons">
        <button onclick="loadStudents('approved')">Approved</button>
        <button onclick="loadStudents('pending')">Pending</button>
    </div>

    <!-- Search Bar -->
    <div style="text-align: center; margin-bottom: 20px;">
        <input oninput="applySearch()" type="text" id="searchInput" placeholder="Search by name, email..." style="padding: 10px; width: 300px; border-radius: 5px; border: 1px solid #ccc;">
        <button onclick="applySearch()" style="padding: 10px 20px; margin-left: 10px; background-color: #004b91; color: white; border: none; border-radius: 6px;">Search</button>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th><th>Name</th><th>Email</th><th>Password</th><th>Phone</th><th>Alt Phone</th>
                <th>WhatsApp</th><th>DOB</th><th>Birth Place</th><th>Region</th><th>Caste</th>
                <th>Blood Group</th><th>Identity</th><th>Current Address</th><th>Permanent Address</th>
                <th>Qualification</th><th>Year</th><th>%</th><th>Institution</th><th>Actions</th>
            </tr>
        </thead>
        <tbody id="studentTableBody"></tbody>
    </table>

    <!-- Pagination Controls -->
    <div id="paginationControls" style="text-align: center; margin-top: 20px;">
        <button onclick="previousPage()" class="status-buttons button">Previous</button>
        <span id="pageIndicator" style="margin: 0 20px; font-weight: bold;">1/1</span>
        <button onclick="nextPage()" class="status-buttons button">Next</button>
    </div>
</div>

<script>
let allStudents = [];   // full list fetched from API
let filteredStudents = []; // after search
let currentPage = 1;
const studentsPerPage = 10;
let currentStatus = 'approved';  // default status

function loadStudents(status = 'approved') {
    currentStatus = status;
    currentPage = 1;
    document.getElementById('studentTableBody').innerHTML = '';
    document.getElementById('searchInput').value = '';

    fetch(`/api/students?status=${status}`, {
        headers: {
            'Authorization': 'Bearer ' + localStorage.getItem('admin_token'),
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 200) {
            allStudents = data.students;
            filteredStudents = allStudents;
            renderStudents();
        } else {
            alert("No students found.");
        }
    });
}

function renderStudents() {
    const tbody = document.getElementById('studentTableBody');
    tbody.innerHTML = '';

    const start = (currentPage - 1) * studentsPerPage;
    const end = start + studentsPerPage;
    const studentsToShow = filteredStudents.slice(start, end);

    studentsToShow.forEach(student => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td data-label="ID">${student.id}</td>
            <td data-label="Name">${student.name}</td>
            <td data-label="Email">${student.email}</td>
            <td data-label="Password">${student.password || '-'}</td>
            <td data-label="Phone">${student.phone}</td>
            <td data-label="Alt Phone">${student.alt_phone || '-'}</td>
            <td data-label="WhatsApp">${student.whatsapp || '-'}</td>
            <td data-label="DOB">${student.dob || '-'}</td>
            <td data-label="Birth Place">${student.birth_place || '-'}</td>
            <td data-label="Region">${student.region || '-'}</td>
            <td data-label="Caste">${student.caste || '-'}</td>
            <td data-label="Blood Group">${student.blood_group || '-'}</td>
            <td data-label="Identity">${student.identity_details || '-'}</td>
            <td data-label="Current Address">${student.current_address || '-'}</td>
            <td data-label="Permanent Address">${student.permanent_address || '-'}</td>
            <td data-label="Qualification">${student.qualification || '-'}</td>
            <td data-label="Passing Year">${student.passing_year || '-'}</td>
            <td data-label="Percentage">${student.percentage || '-'}</td>
            <td data-label="Institution">${student.institution || '-'}</td>
            <td data-label="Actions">
                ${currentStatus === 'pending' 
                    ? `<button class="action-btn approve-btn" onclick="approveStudent(${student.id}, '${student.name}', '${student.email}', '${student.password}')">Approve</button>
                       <button class="action-btn delete-btn" onclick="deleteStudent(${student.id})">Delete</button>`
                    : `<button class="action-btn edit-btn" onclick="editStudent(${student.id})">Edit</button>
                       <button class="action-btn delete-btn" onclick="deleteStudent(${student.id})">Delete</button>`}
            </td>
        `;
        tbody.appendChild(row);
    });

    updatePageIndicator();
}

function updatePageIndicator() {
    const totalPages = Math.ceil(filteredStudents.length / studentsPerPage) || 1;
    document.getElementById('pageIndicator').innerText = `${currentPage}/${totalPages}`;
}

function previousPage() {
    if (currentPage > 1) {
        currentPage--;
        renderStudents();
    }
}

function nextPage() {
    const totalPages = Math.ceil(filteredStudents.length / studentsPerPage);
    if (currentPage < totalPages) {
        currentPage++;
        renderStudents();
    }
}

function applySearch() {
    const query = document.getElementById('searchInput').value.trim().toLowerCase();
    filteredStudents = allStudents.filter(student => 
        student.name.toLowerCase().includes(query) ||
        student.email.toLowerCase().includes(query)
    );
    currentPage = 1;
    renderStudents();
}

function approveStudent(id, name, email, password) {
    fetch(`/api/students/edit/${id}`, {
        method: 'PUT',
        headers: {
            'Authorization': 'Bearer ' + localStorage.getItem('admin_token'),
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            name: name,
            email: email,
            password: password,
            status: 'approved'
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 200) {
            alert("Student approved!");
            loadStudents('pending');
        } else {
            alert("Approval failed.");
        }
    });
}

function deleteStudent(id) {
    if (confirm("Delete this student?")) {
        fetch(`/api/students/${id}/delete`, {
            method: 'DELETE',
            headers: {
                'Authorization': 'Bearer ' + localStorage.getItem('admin_token'),
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 200) {
                alert("Deleted successfully.");
                loadStudents(currentStatus);
            } else {
                alert("Deletion failed.");
            }
        });
    }
}

function editStudent(id) {
    window.location.href = `/student/edit/${id}`;
}

document.addEventListener('DOMContentLoaded', function () {
    loadStudents();
});
</script>

@endsection

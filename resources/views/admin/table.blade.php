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
        transition: background-color 0.3s;
    }

    .status-buttons button:hover {
        background-color: #0061c2;
    }

    .refresh-icon {
        color: #004b91;
        font-size: 20px;
        cursor: pointer;
        margin-left: 10px;
        vertical-align: middle;
        transition: transform 0.5s;
    }

    .refresh-icon:hover {
        transform: rotate(180deg);
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
        transition: background-color 0.2s;
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

    .print-btn {
        background-color: #6c757d;
        color: white;
    }

    .print-btn:hover {
        background-color: #5a6268;
    }

    .header-container {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 20px;
    }

    .action-buttons {
        text-align: center; 
        margin-bottom: 20px; 
        margin-top: 20px;
        display: flex;
        justify-content: center;
        gap: 15px;
    }

    .utility-btn {
        padding: 10px 20px;
        background-color: #004b91;
        color: white;
        border: 2px solid #003366;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .utility-btn i {
        margin-right: 8px;
    }

    .utility-btn:hover {
        background-color: #0061c2;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }

    .export-btn {
        background-color: #28a745;
    }

    .export-btn:hover {
        background-color: #218838;
    }

    .reload-btn {
        background-color: #17a2b8;
    }

    .reload-btn:hover {
        background-color: #138496;
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
        
        .action-buttons {
            flex-direction: column;
            align-items: center;
        }
    }
</style>

<!-- Include Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="container">
    <div class="header-container">
        <h2>Registered Students</h2>
    </div>

    <div class="status-buttons">
        <button onclick="loadStudents('approved')">Approved</button>
        <button onclick="loadStudents('pending')">Pending</button>
    </div>

    <!-- Search Bar -->
    <div style="text-align: center; margin-bottom: 20px;">
        <div style="display: inline-flex; width: 100%; max-width: 400px; align-items: center;">
            <input oninput="applySearch()" type="text" id="searchInput" placeholder="Search by name, email..." style="padding: 10px; flex-grow: 1; border-radius: 5px 0 0 5px; border: 1px solid #ccc; border-right: none;">
            <button onclick="applySearch()" style="padding: 10px 15px; background-color: #004b91; color: white; border: none; border-radius: 0 5px 5px 0;">
                <i class="fas fa-search"></i>
            </button>
        </div>
        <div class="action-buttons">
            <button type="button" onclick="refreshData()" class="utility-btn reload-btn">
                <i class="fas fa-sync-alt"></i> Reload Data
            </button>
            <button type="button" onclick="exportStudentsAsCSV()" class="utility-btn export-btn">
                <i class="fas fa-file-csv"></i> Export Students as CSV
            </button>
        </div>
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
        <button onclick="previousPage()" class="action-btn" style="background-color: #004b91; color: white;">
            <i class="fas fa-chevron-left"></i> Previous
        </button>
        <span id="pageIndicator" style="margin: 0 20px; font-weight: bold;">1/1</span>
        <button onclick="nextPage()" class="action-btn" style="background-color: #004b91; color: white;">
            Next <i class="fas fa-chevron-right"></i>
        </button>
    </div>
</div>

<script>
let allStudents = [];   // full list fetched from API
let filteredStudents = []; // after search
let currentPage = 1;
const studentsPerPage = 5;
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

function refreshData() {
    // Add visual feedback for reload button
    const reloadBtn = document.querySelector('.reload-btn');
    if (reloadBtn) {
        const originalText = reloadBtn.innerHTML;
        reloadBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
        
        setTimeout(() => {
            loadStudents(currentStatus);
            reloadBtn.innerHTML = originalText;
        }, 500);
    } else {
        // If using the icon in the header
        const refreshIcon = document.querySelector('.refresh-icon');
        refreshIcon.style.transform = 'rotate(360deg)';
        loadStudents(currentStatus);
        setTimeout(() => {
            refreshIcon.style.transform = 'rotate(0deg)';
        }, 500);
    }
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
                    ? `<button class="action-btn approve-btn" onclick="approveStudent(${student.id}, '${student.name}', '${student.email}', '${student.password}')">
                          <i class="fas fa-check"></i> Approve
                       </button>
                       <button class="action-btn delete-btn" onclick="deleteStudent(${student.id})">
                          <i class="fas fa-trash"></i> Delete
                       </button>`
                    : `<button class="action-btn edit-btn" onclick="editStudent(${student.id})">
                          <i class="fas fa-edit"></i> Edit
                       </button>
                       <button class="action-btn print-btn" onclick="printStudentDetails(${student.id})">
                          <i class="fas fa-print"></i> Print
                       </button>
                       <button class="action-btn delete-btn" onclick="deleteStudent(${student.id})">
                          <i class="fas fa-trash"></i> Delete
                       </button>`}
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

function printStudentDetails(id) {
    // Find the student by ID
    const student = allStudents.find(s => s.id === id);
    if (!student) {
        alert("Student not found!");
        return;
    }

    // Create the content for the PDF
    const content = `
        <html>
        <head>
            <title>Student Details - ${student.name}</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 20px;
                    color: #333;
                }
                h1 {
                    text-align: center;
                    color: #003366;
                    margin-bottom: 20px;
                }
                .details {
                    border: 1px solid #ccc;
                    padding: 20px;
                    border-radius: 5px;
                }
                .detail-row {
                    display: flex;
                    margin-bottom: 10px;
                    border-bottom: 1px solid #eee;
                    padding-bottom: 5px;
                }
                .label {
                    width: 200px;
                    font-weight: bold;
                }
                .value {
                    flex: 1;
                }
                @media print {
                    .no-print {
                        display: none;
                    }
                }
            </style>
        </head>
        <body>
            <div class="no-print" style="text-align: right;">
                <button onclick="window.print();" style="padding: 10px; background: #004b91; color: white; border: none; border-radius: 5px; cursor: pointer;">
                    <i class="fas fa-print"></i> Print
                </button>
            </div>
            <h1>Student Details</h1>
            <div class="details">
                <div class="detail-row">
                    <div class="label">ID:</div>
                    <div class="value">${student.id}</div>
                </div>
                <div class="detail-row">
                    <div class="label">Name:</div>
                    <div class="value">${student.name}</div>
                </div>
                <div class="detail-row">
                    <div class="label">Email:</div>
                    <div class="value">${student.email}</div>
                </div>
                <div class="detail-row">
                    <div class="label">Phone:</div>
                    <div class="value">${student.phone}</div>
                </div>
                <div class="detail-row">
                    <div class="label">Alternative Phone:</div>
                    <div class="value">${student.alt_phone || '-'}</div>
                </div>
                <div class="detail-row">
                    <div class="label">WhatsApp:</div>
                    <div class="value">${student.whatsapp || '-'}</div>
                </div>
                <div class="detail-row">
                    <div class="label">Date of Birth:</div>
                    <div class="value">${student.dob || '-'}</div>
                </div>
                <div class="detail-row">
                    <div class="label">Birth Place:</div>
                    <div class="value">${student.birth_place || '-'}</div>
                </div>
                <div class="detail-row">
                    <div class="label">Region:</div>
                    <div class="value">${student.region || '-'}</div>
                </div>
                <div class="detail-row">
                    <div class="label">Caste:</div>
                    <div class="value">${student.caste || '-'}</div>
                </div>
                <div class="detail-row">
                    <div class="label">Blood Group:</div>
                    <div class="value">${student.blood_group || '-'}</div>
                </div>
                <div class="detail-row">
                    <div class="label">Identity Details:</div>
                    <div class="value">${student.identity_details || '-'}</div>
                </div>
                <div class="detail-row">
                    <div class="label">Current Address:</div>
                    <div class="value">${student.current_address || '-'}</div>
                </div>
                <div class="detail-row">
                    <div class="label">Permanent Address:</div>
                    <div class="value">${student.permanent_address || '-'}</div>
                </div>
                <div class="detail-row">
                    <div class="label">Qualification:</div>
                    <div class="value">${student.qualification || '-'}</div>
                </div>
                <div class="detail-row">
                    <div class="label">Passing Year:</div>
                    <div class="value">${student.passing_year || '-'}</div>
                </div>
                <div class="detail-row">
                    <div class="label">Percentage:</div>
                    <div class="value">${student.percentage || '-'}</div>
                </div>
                <div class="detail-row">
                    <div class="label">Institution:</div>
                    <div class="value">${student.institution || '-'}</div>
                </div>
            </div>
        </body>
        </html>
    `;

    // Open a new window and print
    const printWindow = window.open('', '_blank');
    printWindow.document.write(content);
    printWindow.document.close();
    printWindow.addEventListener('load', function() {
        // Auto print is optional - user can use the button instead
        // printWindow.print();
    });
}

function exportStudentsAsCSV() {
    let csvContent = "data:text/csv;charset=utf-8,";
    csvContent += "ID,Name,Email,Phone,Alt Phone,WhatsApp,DOB,Birth Place,Region,Caste,Blood Group,Qualification,Passing Year,Percentage,Institution,Status\n";

    allStudents.forEach(student => {
        csvContent += `${student.id},${student.name},${student.email},${student.phone},${student.alt_phone || ''},${student.whatsapp || ''},${student.dob || ''},${student.birth_place || ''},${student.region || ''},${student.caste || ''},${student.blood_group || ''},${student.qualification || ''},${student.passing_year || ''},${student.percentage || ''},${student.institution || ''},${student.status}\n`;
    });

    const encodedUri = encodeURI(csvContent);
    const link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", "students.csv");
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

document.addEventListener('DOMContentLoaded', function () {
    loadStudents();
});
</script>

@endsection
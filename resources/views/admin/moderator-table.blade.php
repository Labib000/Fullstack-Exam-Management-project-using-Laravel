@extends('layout.sidebar')
@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    h2 {
        color: #003366;
        margin: 0;
        font-weight: 600;
    }

    .refresh-btn {
        background: #eef7ff;
        border: none;
        width: 42px;
        height: 42px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: #004b91;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .refresh-btn:hover {
        background: #d1e7ff;
        transform: rotate(30deg);
    }

    .refresh-btn i {
        font-size: 18px;
    }

    .search-export-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .search-box {
        display: flex;
        align-items: center;
        background: white;
        border-radius: 30px;
        padding: 0 5px 0 15px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        border: 1px solid #e0e0e0;
    }

    .search-box input {
        padding: 12px 10px;
        width: 250px;
        border: none;
        outline: none;
        border-radius: 30px;
        font-size: 14px;
    }

    .search-btn {
        padding: 10px 20px;
        background-color: #004b91;
        color: white;
        border: none;
        border-radius: 30px;
        cursor: pointer;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
    }

    .search-btn:hover {
        background-color: #0061c2;
        box-shadow: 0 4px 8px rgba(0, 75, 145, 0.2);
    }

    .export-btn {
        padding: 10px 20px;
        background-color: #28a745;
        color: white;
        border: none;
        border-radius: 30px;
        cursor: pointer;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    }

    .export-btn:hover {
        background-color: #218838;
        box-shadow: 0 4px 8px rgba(40, 167, 69, 0.2);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 1200px;
        margin-top: 15px;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
    }

    thead {
        background-color: #003366;
        color: #fff;
    }

    th, td {
        padding: 15px;
        border: 1px solid #e0e0e0;
        text-align: left;
    }

    th {
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    tr:nth-child(even) {
        background-color: #f2f7fc;
    }

    tr:hover {
        background-color: #e0efff;
    }

    .action-column {
        display: flex;
        gap: 8px;
    }

    .action-btn {
        padding: 8px 12px;
        border-radius: 5px;
        font-size: 13px;
        cursor: pointer;
        border: none;
        display: flex;
        align-items: center;
        gap: 5px;
        transition: all 0.2s ease;
    }

    .edit-btn {
        background-color: #f0f8ff;
        color: #007bff;
        border: 1px solid #007bff;
    }

    .edit-btn:hover {
        background-color: #007bff;
        color: white;
    }

    .print-btn {
        background-color: #f0f9ff;
        color: #17a2b8;
        border: 1px solid #17a2b8;
    }

    .print-btn:hover {
        background-color: #17a2b8;
        color: white;
    }

    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 25px;
        gap: 15px;
    }

    .pagination-btn {
        padding: 10px 15px;
        background-color: #f0f2f5;
        border: 1px solid #dadde1;
        border-radius: 8px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 5px;
        transition: all 0.2s ease;
        font-weight: 500;
    }

    .pagination-btn:hover {
        background-color: #e4e6eb;
    }

    .page-info {
        font-weight: 500;
        color: #555;
    }

    /* Modal Styles */
    .modal-backdrop {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
        z-index: 9999;
        backdrop-filter: blur(3px);
    }

    .modal-content {
        background: #fff;
        padding: 30px;
        border-radius: 15px;
        width: 400px;
        position: relative;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        animation: slideIn 0.3s ease-out;
    }

    @keyframes slideIn {
        from {
            transform: translateY(-20px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .modal-header {
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }

    .modal-header h3 {
        margin: 0;
        color: #003366;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #555;
    }

    .form-control {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 14px;
        transition: border-color 0.2s ease;
    }

    .form-control:focus {
        border-color: #007bff;
        outline: none;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
    }

    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 25px;
    }

    .modal-btn {
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        border: none;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .save-btn {
        background-color: #28a745;
        color: white;
    }

    .save-btn:hover {
        background-color: #218838;
    }

    .cancel-btn {
        background-color: #f8f9fa;
        color: #343a40;
        border: 1px solid #ddd;
    }

    .cancel-btn:hover {
        background-color: #e9ecef;
    }

    @media screen and (max-width: 768px) {
        .search-export-container {
            flex-direction: column;
            align-items: stretch;
            gap: 15px;
        }

        .export-btn {
            margin-top: 10px;
        }

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
            border-radius: 8px;
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

        .action-column {
            display: flex;
            justify-content: flex-end;
            width: 100%;
            padding-left: 0 !important;
        }

        .modal-content {
            width: 90%;
            max-width: 400px;
        }
    }
</style>

<div class="container">
    <div class="page-header">
        <h2>Registered Moderators</h2>
        <button onclick="refreshModerators()" class="refresh-btn" title="Refresh Table">
            <i class="fas fa-sync-alt"></i>
        </button>
    </div>
    
    <div class="search-export-container">
        <div class="search-box">
            <input type="text" id="moderatorSearchInput" placeholder="Search by name or email" oninput="applyModeratorSearch()">
            <button type="button" onclick="applyModeratorSearch()" class="search-btn">
                <i class="fas fa-search"></i> Search
            </button>
        </div>
        
        <button type="button" onclick="exportModeratorsAsCSV()" class="export-btn">
            <i class="fas fa-file-export"></i> Export CSV
        </button>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Designation</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="moderatorTableBody"></tbody>
    </table>

    <!-- Edit Moderator Modal -->
    <div id="editModeratorModal" class="modal-backdrop">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-user-edit"></i> Edit Moderator</h3>
            </div>
            
            <input type="hidden" id="editModeratorId">

            <div class="form-group">
                <label for="editName"><i class="fas fa-user"></i> Name</label>
                <input type="text" id="editName" class="form-control">
            </div>

            <div class="form-group">
                <label for="editPhone"><i class="fas fa-phone"></i> Phone</label>
                <input type="text" id="editPhone" class="form-control">
            </div>

            <div class="form-group">
                <label for="editDesignation"><i class="fas fa-id-badge"></i> Designation</label>
                <input type="text" id="editDesignation" class="form-control">
            </div>

            <div class="form-group">
                <label for="editPassword"><i class="fas fa-lock"></i> New Password (optional)</label>
                <input type="password" id="editPassword" class="form-control">
            </div>

            <div class="modal-footer">
                <button onclick="submitEditModerator()" class="modal-btn save-btn">
                    <i class="fas fa-save"></i> Save Changes
                </button>
                <button onclick="closeEditModal()" class="modal-btn cancel-btn">
                    <i class="fas fa-times"></i> Cancel
                </button>
            </div>
        </div>
    </div>

    <div class="pagination">
        <button onclick="previousModeratorPage()" class="pagination-btn">
            <i class="fas fa-chevron-left"></i> Previous
        </button>
        <span id="moderatorPageInfo" class="page-info"></span>
        <button onclick="nextModeratorPage()" class="pagination-btn">
            Next <i class="fas fa-chevron-right"></i>
        </button>
    </div>
</div>

<script>
let allModerators = [];
let filteredModerators = [];
let currentModeratorPage = 1;
const moderatorsPerPage = 5;

function loadModerators() {
    fetch('/api/moderators', {
        headers: {
            'Authorization': 'Bearer ' + localStorage.getItem('admin_token'),
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data) {
            allModerators = data.moderators;
            filteredModerators = allModerators;
            renderModerators();
        } else {
            alert("No moderators found.");
        }
    });
}

function renderModerators() {
    const tbody = document.getElementById('moderatorTableBody');
    tbody.innerHTML = '';

    const start = (currentModeratorPage - 1) * moderatorsPerPage;
    const end = start + moderatorsPerPage;
    const moderatorsToShow = filteredModerators.slice(start, end);

    moderatorsToShow.forEach(moderator => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td data-label="ID">${moderator.id}</td>
            <td data-label="Name">${moderator.name}</td>
            <td data-label="Email">${moderator.email}</td>
            <td data-label="Phone">${moderator.phone}</td>
            <td data-label="Designation">${moderator.designation}</td>
            <td data-label="Actions" class="action-column">
                <button class="action-btn edit-btn" onclick="openEditModerator(${moderator.id})">
                    <i class="fas fa-edit"></i> Edit
                </button>
                <button class="action-btn print-btn" onclick="printModerator(${moderator.id})">
                    <i class="fas fa-print"></i> Print
                </button>
            </td>
        `;
        tbody.appendChild(row);
    });

    document.getElementById('moderatorPageInfo').innerText = `Page ${currentModeratorPage} of ${Math.ceil(filteredModerators.length / moderatorsPerPage)}`;
}

function applyModeratorSearch() {
    const query = document.getElementById('moderatorSearchInput').value.trim().toLowerCase();
    filteredModerators = allModerators.filter(moderator =>
        moderator.name.toLowerCase().includes(query) ||
        moderator.email.toLowerCase().includes(query)
    );
    currentModeratorPage = 1;
    renderModerators();
}

function nextModeratorPage() {
    if (currentModeratorPage < Math.ceil(filteredModerators.length / moderatorsPerPage)) {
        currentModeratorPage++;
        renderModerators();
    }
}

function previousModeratorPage() {
    if (currentModeratorPage > 1) {
        currentModeratorPage--;
        renderModerators();
    }
}

function printModerator(id) {
    fetch(`/api/moderators/show/${id}`, {
        headers: {
            'Authorization': 'Bearer ' + localStorage.getItem('admin_token'),
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data && data.moderator) {
            const moderator = data.moderator;
            const printWindow = window.open('', '', 'height=700,width=900');
            printWindow.document.write(`
                <html>
                <head>
                    <title>Moderator Details</title>
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
                    <style>
                        body {
                            font-family: 'Arial', sans-serif;
                            margin: 40px;
                            background-color: #f4f6f8;
                        }
                        .header {
                            text-align: center;
                            margin-bottom: 40px;
                        }
                        .header h1 {
                            margin: 0;
                            font-size: 28px;
                            color: #003366;
                        }
                        .details-box {
                            background: #ffffff;
                            padding: 30px;
                            border: 2px solid #003366;
                            border-radius: 10px;
                            width: 80%;
                            margin: 0 auto;
                            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
                        }
                        .details-box h2 {
                            text-align: center;
                            margin-bottom: 30px;
                            color: #004b91;
                            padding-bottom: 15px;
                            border-bottom: 1px solid #eaeaea;
                        }
                        .detail-item {
                            margin: 15px 0;
                            font-size: 18px;
                            display: flex;
                            align-items: center;
                        }
                        .label {
                            font-weight: bold;
                            color: #333;
                            width: 120px;
                        }
                        .icon {
                            color: #004b91;
                            margin-right: 10px;
                            width: 20px;
                            text-align: center;
                        }
                    </style>
                </head>
                <body>
                    <div class="header">
                        <h1>Techno International Batanagar</h1>
                    </div>
                    <div class="details-box">
                        <h2><i class="fas fa-user-shield"></i> Moderator Details</h2>
                        <div class="detail-item"><i class="fas fa-hashtag icon"></i><span class="label">ID:</span> ${moderator.id}</div>
                        <div class="detail-item"><i class="fas fa-user icon"></i><span class="label">Name:</span> ${moderator.name}</div>
                        <div class="detail-item"><i class="fas fa-envelope icon"></i><span class="label">Email:</span> ${moderator.email}</div>
                        <div class="detail-item"><i class="fas fa-phone icon"></i><span class="label">Phone:</span> ${moderator.phone}</div>
                        <div class="detail-item"><i class="fas fa-id-badge icon"></i><span class="label">Designation:</span> ${moderator.designation}</div>
                        <div class="detail-item"><i class="fas fa-calendar-plus icon"></i><span class="label">Created At:</span> ${new Date(moderator.created_at).toLocaleString()}</div>
                        <div class="detail-item"><i class="fas fa-calendar-check icon"></i><span class="label">Updated At:</span> ${new Date(moderator.updated_at).toLocaleString()}</div>
                    </div>
                </body>
                </html>
            `);
            printWindow.document.close();
            printWindow.print();
        } else {
            alert("Moderator details not found.");
        }
    })
    .catch(error => {
        console.error('Error fetching moderator details:', error);
        alert('Failed to fetch moderator details.');
    });
}

function exportModeratorsAsCSV() {
    if (filteredModerators.length === 0) {
        alert('No moderators to export.');
        return;
    }

    let csvContent = "data:text/csv;charset=utf-8,";
    csvContent += "ID,Name,Email,Phone,Designation,Created At,Updated At\n";

    filteredModerators.forEach(moderator => {
        const row = [
            moderator.id,
            `"${moderator.name}"`,
            `"${moderator.email}"`,
            `"${moderator.phone}"`,
            `"${moderator.designation}"`,
            `"${new Date(moderator.created_at).toLocaleString()}"`,
            `"${new Date(moderator.updated_at).toLocaleString()}"`
        ].join(",");
        csvContent += row + "\n";
    });

    const encodedUri = encodeURI(csvContent);
    const link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", "moderators_list.csv");
    document.body.appendChild(link);

    link.click();
    document.body.removeChild(link);
}

function openEditModerator(id) {
    const moderator = allModerators.find(m => m.id === id);
    if (!moderator) return;

    document.getElementById('editModeratorId').value = moderator.id;
    document.getElementById('editName').value = moderator.name;
    document.getElementById('editPhone').value = moderator.phone;
    document.getElementById('editDesignation').value = moderator.designation;
    document.getElementById('editPassword').value = '';

    document.getElementById('editModeratorModal').style.display = 'flex';
}

function closeEditModal() {
    document.getElementById('editModeratorModal').style.display = 'none';
}

function submitEditModerator() {
    const id = document.getElementById('editModeratorId').value;
    const name = document.getElementById('editName').value;
    const phone = document.getElementById('editPhone').value;
    const designation = document.getElementById('editDesignation').value;
    const password = document.getElementById('editPassword').value;

    const payload = {
        name,
        phone,
        designation
    };

    if (password.trim() !== '') {
        payload.password = password;
    }

    fetch(`/api/moderators/edit/${id}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + localStorage.getItem('admin_token'),
            'Accept': 'application/json'
        },
        body: JSON.stringify(payload)
    })
    .then(res => res.json())
    .then(data => {
        alert('Moderator updated successfully!');
        closeEditModal();
        loadModerators(); // Refresh table
    })
    .catch(error => {
        console.error('Error updating moderator:', error);
        alert('Failed to update moderator.');
    });
}

function refreshModerators() {
    const icon = document.querySelector('.fa-sync-alt');
    icon.classList.add('fa-spin');

    loadModerators();

    setTimeout(() => {
        icon.classList.remove('fa-spin');
    }, 1000);
}

document.addEventListener('DOMContentLoaded', function () {
    loadModerators();
});
</script>

@endsection
@extends('layout.sidebar')
@section('content')


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
    /* (reuse your student table styles here or keep them similar) */
    /* You can copy your previous CSS */
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
    <h2>Registered Moderators</h2>
    
    <div style="text-align: center; margin-bottom: 20px;">
        <input type="text" id="moderatorSearchInput" placeholder="Search Moderator by Name or Email" oninput="applyModeratorSearch()" 
        style="padding: 10px; width: 250px; border-radius: 5px; border: 1px solid #ccc;">
        <button type="button" onclick="applyModeratorSearch()" 
        style="padding: 10px 20px; margin-left: 10px; background-color: #004b91; color: white; border: none; border-radius: 6px;">Search</button>
        
        <button type="button" onclick="exportModeratorsAsCSV()" 
        style="padding: 10px 20px; margin-left: 10px; margin-top: 10px; background-color: #28a745; color: white; border: none; border-radius: 6px;">
            Export as CSV
        </button>
    
    </div>
    <div style="display: flex; justify-content: flex-end; margin-bottom: 10px;">
        <button onclick="refreshModerators()" 
            style="background: none; border: none; font-size: 24px; cursor: pointer;" 
            title="Refresh Table">
            <i class="fas fa-sync-alt"></i>
        </button>
    </div>
    
    
    

    <table>
        
        <thead>
            <tr>
                <th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Designation</th><th>Created At</th><th>Updated At</th><th>Action</th>
            </tr>
        </thead>
        <tbody id="moderatorTableBody"></tbody>
    </table>

    <!-- Edit Moderator Modal -->
<div id="editModeratorModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; 
background:rgba(0,0,0,0.5); justify-content:center; align-items:center; z-index:9999;">
<div style="background:#fff; padding:30px; border-radius:10px; width:350px; position:relative;">
    <h3>Edit Moderator</h3>
    <input type="hidden" id="editModeratorId">

    <div style="margin-bottom:10px;">
        <label>Name:</label>
        <input type="text" id="editName" style="width:100%; padding:8px;">
    </div>

    <div style="margin-bottom:10px;">
        <label>Phone:</label>
        <input type="text" id="editPhone" style="width:100%; padding:8px;">
    </div>

    <div style="margin-bottom:10px;">
        <label>Designation:</label>
        <input type="text" id="editDesignation" style="width:100%; padding:8px;">
    </div>

    <div style="margin-bottom:10px;">
        <label>New Password (optional):</label>
        <input type="password" id="editPassword" style="width:100%; padding:8px;">
    </div>

    <button onclick="submitEditModerator()" style="padding:8px 15px; background-color:#28a745; color:white; border:none; border-radius:6px;">Save Changes</button>
    <button onclick="closeEditModal()" style="padding:8px 15px; background-color:#dc3545; color:white; border:none; border-radius:6px; margin-left:10px;">Cancel</button>
</div>
</div>


    <div style="text-align: center; margin-top: 20px;">
        <button onclick="previousModeratorPage()" style="padding: 8px 16px; margin-right: 10px;">Previous</button>
        <span id="moderatorPageInfo"></span>
        <button onclick="nextModeratorPage()" style="padding: 8px 16px; margin-left: 10px;">Next</button>
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
            <td data-label="Created At">${moderator.created_at}</td>
            <td data-label="Updated At">${moderator.updated_at}</td>
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

document.addEventListener('DOMContentLoaded', function () {
    loadModerators();
});

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
            <td data-label="Created At">${moderator.created_at}</td>
            <td data-label="Updated At">${moderator.updated_at}</td>
            <td data-label="Action">
                  <button class=" btn btn-outline-danger" onclick="openEditModerator(${moderator.id})">Edit</button>
                <button class="btn mt-2 btn btn-outline-primary" onclick="printModerator(${moderator.id})">Print Details</button>
            </td>
        `;
        tbody.appendChild(row);
    });

    document.getElementById('moderatorPageInfo').innerText = `Page ${currentModeratorPage} of ${Math.ceil(filteredModerators.length / moderatorsPerPage)}`;
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
                        }
                        .details-box h2 {
                            text-align: center;
                            margin-bottom: 20px;
                            color: #004b91;
                        }
                        .detail-item {
                            margin: 10px 0;
                            font-size: 18px;
                        }
                        .label {
                            font-weight: bold;
                            color: #333;
                        }
                    </style>
                </head>
                <body>
                    <div class="header">
                        <h1>Techno International Batanagar</h1>
                    </div>
                    <div class="details-box">
                        <h2>Moderator Details</h2>
                        <div class="detail-item"><span class="label">ID:</span> ${moderator.id}</div>
                        <div class="detail-item"><span class="label">Name:</span> ${moderator.name}</div>
                        <div class="detail-item"><span class="label">Email:</span> ${moderator.email}</div>
                        <div class="detail-item"><span class="label">Phone:</span> ${moderator.phone}</div>
                        <div class="detail-item"><span class="label">Designation:</span> ${moderator.designation}</div>
                        <div class="detail-item"><span class="label">Created At:</span> ${new Date(moderator.created_at).toLocaleString()}</div>
                        <div class="detail-item"><span class="label">Updated At:</span> ${new Date(moderator.updated_at).toLocaleString()}</div>
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




</script>

@endsection

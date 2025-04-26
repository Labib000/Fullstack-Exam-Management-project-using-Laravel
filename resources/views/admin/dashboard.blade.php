@extends('layout.sidebar')

<head>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<style>
    body {
       font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
       background: url('{{ asset('images/bg-wave.svg') }}') no-repeat top center;
       background-size: cover;
       position: relative;
   }
</style>


@section('content')
    <div class="container">
        <h2 class="mb-4 text-white">Welcome, Admin 👋</h2>

        <!-- Top Bar Section -->
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card text-white bg-primary h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Total Approved Students</h5>
                        <p class="card-text fs-3" id="approved-student-count">Loading...</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card text-white bg-info h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Total Moderators</h5>
                        <p class="card-text fs-3" id="moderator-count">Loading...</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card text-white bg-dark h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Total Admins</h5>
                        <p class="card-text fs-3" id="admin-count">Loading...</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="row mt-5">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-white fw-bold">
                        Admin and Moderator Overview
                    </div>
                    <div class="card-body">
                        <canvas id="adminModeratorChart" width="400" height="400"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-white fw-bold">
                        Student Status Overview
                    </div>
                    <div class="card-body">
                        <canvas id="studentStatusChart" width="400" height="400"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        const token = localStorage.getItem('admin_token');
        let approved = 0;
        let pending = 0;
        let moderators = 0;
        let admins = 0;

        let fetchCompleted = 0; // Track how many fetches are completed

        // Function to check if all fetches are completed
        function checkAllFetched() {
            if (fetchCompleted === 4) {
                updateCharts();
            }
        }

        // Fetch approved students
        fetch('/api/students?status=approved', {
            headers: { 'Authorization': 'Bearer ' + token }
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 200) {
                approved = data.students.length;
                document.getElementById('approved-student-count').textContent = approved;
            } else {
                document.getElementById('approved-student-count').textContent = 'Error';
            }
            fetchCompleted++;
            checkAllFetched();
        })
        .catch(err => {
            console.error('Approved Students Fetch Error:', err);
            document.getElementById('approved-student-count').textContent = 'Error';
            fetchCompleted++;
            checkAllFetched();
        });

        // Fetch pending students
        fetch('/api/students?status=pending', {
            headers: { 'Authorization': 'Bearer ' + token }
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 200) {
                pending = data.students.length;
            }
            fetchCompleted++;
            checkAllFetched();
        })
        .catch(err => {
            console.error('Pending Students Fetch Error:', err);
            fetchCompleted++;
            checkAllFetched();
        });

        // Fetch moderators
        fetch('/api/moderators', {
            headers: { 'Authorization': 'Bearer ' + token }
        })
        .then(res => res.json())
        .then(data => {
            if (data) {
                moderators = data.moderators.length;
                document.getElementById('moderator-count').textContent = moderators;
            } else {
                document.getElementById('moderator-count').textContent = 'Error';
            }
            fetchCompleted++;
            checkAllFetched();
        })
        .catch(err => {
            console.error('Moderators Fetch Error:', err);
            document.getElementById('moderator-count').textContent = 'Error';
            fetchCompleted++;
            checkAllFetched();
        });

        // Fetch admins
        fetch('/api/admins', {
            headers: { 'Authorization': 'Bearer ' + token }
        })
        .then(res => res.json())
        .then(data => {
            if (data) {
                admins = data.admins.length;
                document.getElementById('admin-count').textContent = admins;
            } else {
                document.getElementById('admin-count').textContent = 'Error';
            }
            fetchCompleted++;
            checkAllFetched();
        })
        .catch(err => {
            console.error('Admins Fetch Error:', err);
            document.getElementById('admin-count').textContent = 'Error';
            fetchCompleted++;
            checkAllFetched();
        });

        // Create charts only after all fetches are done
        function updateCharts() {
            // Bar Chart
            const ctxBar = document.getElementById('adminModeratorChart').getContext('2d');
            new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: ['Approved Students', 'Moderators', 'Admins'],
                    datasets: [{
                        label: 'Count',
                        data: [approved, moderators, admins],
                        backgroundColor: ['#198754', '#0dcaf0', '#212529'],
                        borderColor: ['#fff', '#fff', '#fff'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });

            // Pie Chart
            const ctxPie = document.getElementById('studentStatusChart').getContext('2d');
            new Chart(ctxPie, {
                type: 'pie',
                data: {
                    labels: ['Approved', 'Pending'],
                    datasets: [{
                        label: 'Student Status',
                        data: [approved, pending],
                        backgroundColor: ['#198754', '#ffc107'],
                        borderColor: ['#fff', '#fff'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        }
                    }
                }
            });
        }
    </script>
@endsection

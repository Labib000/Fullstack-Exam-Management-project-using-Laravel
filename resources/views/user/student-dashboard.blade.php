{{-- resources/views/student/dashboard.blade.php --}}
@extends('layout.sidebar')
<head>
    <!-- Include SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>


@section('content')
    <div class="container">
        <h2 class="mb-4">Welcome, Student 👋</h2>

        <div class="row g-4">
            <!-- Total Courses Card -->
            <div class="col-md-4">
                <div class="card text-white bg-primary h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Total Courses</h5>
                        <p class="card-text fs-3">5</p>
                    </div>
                </div>
            </div>

            <!-- Upcoming Exams Card -->
            <div class="col-md-4">
                <div class="card text-white bg-success h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Upcoming Exams</h5>
                        <p class="card-text fs-3">3</p>
                    </div>
                </div>
            </div>

            <!-- Completed Courses Card -->
            <div class="col-md-4">
                <div class="card text-white bg-secondary h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Completed Courses</h5>
                        <p class="card-text fs-3">2</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col">
                <div class="card shadow-sm">
                    <div class="card-header bg-white fw-bold">
                        Recent Activity
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Enrolled in <strong>Mathematics</strong> course.</li>
                            <li class="list-group-item">Completed <strong>Physics Term 1</strong> exam.</li>
                            <li class="list-group-item">Requested for <strong>Transcripts</strong>.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
   <script>
    // Logout functionality with SweetAlert2
    document.getElementById('logoutBtn').addEventListener('click', function () {
        fetch('/api/students/logout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + localStorage.getItem('student_token') // assuming token is stored in localStorage
            }
        })
        .then(response => {
            if (response.ok) {
                // Show success alert with SweetAlert2
                Swal.fire({
                    icon: 'success',
                    title: 'Logged out successfully!',
                    text: 'You have been logged out. Redirecting...',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    localStorage.removeItem('student_token'); // Remove the token from localStorage
                    window.location.href = '/'; // Redirect to home
                });
            } else {
                // Show error alert with SweetAlert2
                Swal.fire({
                    icon: 'error',
                    title: 'Logout failed!',
                    text: 'Something went wrong during logout.',
                    confirmButtonText: 'Try Again'
                });
            }
        })
        .catch(error => {
            console.error('Logout Error:', error);
            // Show error alert with SweetAlert2
            Swal.fire({
                icon: 'error',
                title: 'Logout failed!',
                text: 'Something went wrong during logout.',
                confirmButtonText: 'Try Again'
            });
        });
    });
</script>

@endsection

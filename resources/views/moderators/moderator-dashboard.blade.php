@extends('layout.sidebar')

<head>
    <!-- Include SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

@section('content')
    <div class="container">
        <h2 class="mb-4">Welcome, Moderator 👋</h2>

        <div class="row g-4">
            <!-- Pending Approvals -->
            <div class="col-md-4">
                <div class="card text-white bg-warning h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Pending Approvals</h5>
                        <p class="card-text fs-3">47</p>
                    </div>
                </div>
            </div>

            <!-- Total Approved Students -->
            <div class="col-md-4">
                <div class="card text-white bg-success h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Approved Students</h5>
                        <p class="card-text fs-3">1,201</p>
                    </div>
                </div>
            </div>

            <!-- Reports -->
            <div class="col-md-4">
                <div class="card text-white bg-info h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Reports Reviewed</h5>
                        <p class="card-text fs-3">89</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col">
                <div class="card shadow-sm">
                    <div class="card-header bg-white fw-bold">
                        Recent Moderator Activity
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Approved student <strong>Ananya Roy</strong>.</li>
                            <li class="list-group-item">Reviewed report for <strong>April Exams</strong>.</li>
                            <li class="list-group-item">Marked student <strong>Mohit Das</strong> as duplicate.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Logout functionality with SweetAlert2
        document.getElementById('logoutBtn').addEventListener('click', function () {
            fetch('/api/moderators/logout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + localStorage.getItem('moderator_token') // assuming token is stored in localStorage
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
                        localStorage.removeItem('moderator_token'); // Remove the token from localStorage
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        .sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            background-color: #212529;
            color: white;
            overflow-y: auto;
        }
        .sidebar a, .sidebar button {
            color: #ddd;
            text-decoration: none;
            transition: 0.2s;
        }
        .sidebar a:hover, .sidebar .nav-link.active {
            background-color: #343a40;
            color: white;
            border-radius: 0.375rem;
        }
        .sidebar .nav-link {
            padding: 0.6rem 1rem;
        }
        .sidebar .logo {
            max-width: 100px;
            margin-bottom: 10px;
        }
        .content {
            margin-left: 260px;
            padding: 2rem;
        }
        .sidebar .section-title {
            font-size: 0.85rem;
            color: #bbb;
            margin-top: 1rem;
            padding-left: 1rem;
        }
        .logo{
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <div class="sidebar d-flex flex-column p-3">
        <div class="text-center mb-3">
            <img src="{{ asset('images/technobatanagar-logo.jpg') }}" alt="College Logo" class="logo img-fluid">
            <h5 class="text-white mt-2" id="panelHeading">Admin Panel</h5>
        </div>

        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="/admin/dashboard" class="nav-link">🏠 Dashboard</a>
            </li>

            <!-- STUDENT SECTION (Visible only for Admin & Moderator) -->
            <div class="section-title" id="studentsSectionTitle">STUDENTS</div>
            <li class="nav-item" id="addStudentLink">
                <a href="/admin/form" class="nav-link">➕ Add Student</a>
            </li>
            <li class="nav-item" id="studentDetailsLink">
                <a href="/student/table" class="nav-link">📄 Student Details</a>
            </li>
            <div class="section-title" id="moderatorSectionTitle">MODERATORS</div>
<li class="nav-item" id="addModeratorLink">
    <a href="/moderators/add" class="nav-link">➕ Add Moderator</a>
</li>
<li class="nav-item" id="moderatorDetailsLink">
    <a href="/moderator/table" class="nav-link">📋 Moderator Details</a>
</li>


            <!-- EXAM SECTION -->
            <div class="section-title">EXAMS</div>
            <li class="nav-item" id="addExamLink">
                <a href="/exams/add" class="nav-link">📝 Add Exam</a>
            </li>
            <li class="nav-item" id="examResultsLink">
                <a href="/exams/results" class="nav-link">📈 Exam Results</a>
            </li>
            <li class="nav-item" id="examListLink">
                <a href="/exams/list" class="nav-link">📊 Exam List</a>
            </li>
            <li class="nav-item" id="myExamsLink">
                <a href="/exams" class="nav-link">📋 My Exams</a>
            </li>

            <!-- OTHERS SECTION -->
            <div class="section-title">OTHERS</div>
            <li class="nav-item">
                <a href="/courses" class="nav-link">📚 Courses</a>
            </li>
            <li class="nav-item">
                <a href="/reports" class="nav-link">📈 Reports</a>
            </li>
            <li class="nav-item mb-3">
                <a href="/settings" class="nav-link">⚙️ Settings</a>
            </li>
        </ul>

        <button id="logoutBtn" class="btn btn-danger w-100 mt-3 mt-auto">🚪 Logout</button>

    </div>

    <div class="content">
        @yield('content')
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const role = localStorage.getItem('admin_token') || localStorage.getItem('moderator_token') || localStorage.getItem('student_token');
            
            // Check if role exists and determine which role is logged in
            if (localStorage.getItem('admin_token')) {
                document.getElementById('panelHeading').textContent = 'Admin Panel';
                // Admin has full access
                showAdminSidebar();
            } else if (localStorage.getItem('moderator_token')) {
                document.getElementById('panelHeading').textContent = 'Moderator Panel';
                // Moderator access: Can see student-related sections and exams
                showModeratorSidebar();
            } else if (localStorage.getItem('student_token')) {
                document.getElementById('panelHeading').textContent = 'Student Panel';
                // Student access: Only see My Exams and All Exams
                showStudentSidebar();
            }
        });

        // Functions to Show/Hide Sections based on Role
        function showAdminSidebar() {
            // Show all sections for Admin
            document.getElementById('studentsSectionTitle').style.display = 'block';
            document.getElementById('addStudentLink').style.display = 'block';
            document.getElementById('studentDetailsLink').style.display = 'block';
            document.getElementById('addExamLink').style.display = 'block';
            document.getElementById('examResultsLink').style.display = 'block';
            document.getElementById('examListLink').style.display = 'block';
            document.getElementById('myExamsLink').style.display = 'block';
        }

        function showModeratorSidebar() {
            // Moderator can see Add Exam, Exam Results, and Exam List, but not Add Student
            document.getElementById('studentsSectionTitle').style.display = 'block';
            document.getElementById('addStudentLink').style.display = 'none'; // Hide Add Student for Moderator
            document.getElementById('studentDetailsLink').style.display = 'block'; // Show Student Details for Moderator
            document.getElementById('addExamLink').style.display = 'block'; // Show Add Exam for Moderator
            document.getElementById('examResultsLink').style.display = 'block'; // Show Exam Results for Moderator
            document.getElementById('examListLink').style.display = 'block'; // Show Exam List for Moderator
            document.getElementById('myExamsLink').style.display = 'none'; // Hide My Exams for Moderator
        }

        function showStudentSidebar() {
            // Student only sees "My Exams" and "All Exams"
            document.getElementById('studentsSectionTitle').style.display = 'none';
            document.getElementById('addStudentLink').style.display = 'none';
            document.getElementById('studentDetailsLink').style.display = 'none';
            document.getElementById('addExamLink').style.display = 'none';
            document.getElementById('examResultsLink').style.display = 'none';
            document.getElementById('examListLink').style.display = 'none';
            document.getElementById('myExamsLink').style.display = 'block'; // Show My Exams for Students
            const allExamsLink = document.createElement('li');
            allExamsLink.classList.add('nav-item');
            allExamsLink.innerHTML = '<a href="/exams/all" class="nav-link">📋 All Exams</a>';
            document.querySelector('.nav').appendChild(allExamsLink); // Dynamically add "All Exams" for Students
        }

        function showAdminSidebar() {
    // Existing student and exam links
    document.getElementById('studentsSectionTitle').style.display = 'block';
    document.getElementById('addStudentLink').style.display = 'block';
    document.getElementById('studentDetailsLink').style.display = 'block';
    document.getElementById('addExamLink').style.display = 'block';
    document.getElementById('examResultsLink').style.display = 'block';
    document.getElementById('examListLink').style.display = 'block';
    document.getElementById('myExamsLink').style.display = 'block';

    // New Moderator Links
    document.getElementById('moderatorSectionTitle').style.display = 'block';
    document.getElementById('addModeratorLink').style.display = 'block';
    document.getElementById('moderatorDetailsLink').style.display = 'block';
}

function showModeratorSidebar() {
    // Moderator access
    document.getElementById('studentsSectionTitle').style.display = 'block';
    document.getElementById('addStudentLink').style.display = 'none';
    document.getElementById('studentDetailsLink').style.display = 'block';
    document.getElementById('addExamLink').style.display = 'block';
    document.getElementById('examResultsLink').style.display = 'block';
    document.getElementById('examListLink').style.display = 'block';
    document.getElementById('myExamsLink').style.display = 'none';

    // Hide Moderator Section
    document.getElementById('moderatorSectionTitle').style.display = 'none';
    document.getElementById('addModeratorLink').style.display = 'none';
    document.getElementById('moderatorDetailsLink').style.display = 'none';
}

function showStudentSidebar() {
    // Student access
    document.getElementById('studentsSectionTitle').style.display = 'none';
    document.getElementById('addStudentLink').style.display = 'none';
    document.getElementById('studentDetailsLink').style.display = 'none';
    document.getElementById('addExamLink').style.display = 'none';
    document.getElementById('examResultsLink').style.display = 'none';
    document.getElementById('examListLink').style.display = 'none';
    document.getElementById('myExamsLink').style.display = 'block';

    // Hide Moderator Section
    document.getElementById('moderatorSectionTitle').style.display = 'none';
    document.getElementById('addModeratorLink').style.display = 'none';
    document.getElementById('moderatorDetailsLink').style.display = 'none';

    // Add All Exams link for student
    const allExamsLink = document.createElement('li');
    allExamsLink.classList.add('nav-item');
    allExamsLink.innerHTML = '<a href="/exams/all" class="nav-link">📋 All Exams</a>';
    document.querySelector('.nav').appendChild(allExamsLink);
}

    </script>
</body>
</html>

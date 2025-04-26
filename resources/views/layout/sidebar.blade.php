<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --sidebar-bg: #1e2937;
            --sidebar-hover: #2d3748;
            --sidebar-active: #3b82f6;
            --sidebar-text: #e2e8f0;
            --sidebar-icon: #9ca3af;
            --sidebar-section: #6b7280;
            --sidebar-width: 280px;
        }
        
        body {
            min-height: 100vh;
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            background-color: var(--sidebar-bg);
            color: var(--sidebar-text);
            overflow-y: auto;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            transition: all 0.3s ease;
        }
        
        .sidebar-header {
            padding: 1.5rem 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            margin-bottom: 1rem;
        }
        
        .logo-container {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 1rem;
            transition: transform 0.2s;
        }
        
        .logo-container:hover {
            transform: scale(1.05);
        }
        
        .sidebar .logo {
            max-width: 100px;
            border-radius: 8px;
        }
        
        .panel-title {
            font-weight: 600;
            letter-spacing: 0.5px;
            font-size: 1.1rem;
            margin-top: 0.5rem;
            text-transform: uppercase;
        }
        
        .sidebar .nav-item {
            margin: 0.2rem 0.7rem;
        }
        
        .sidebar a, .sidebar button {
            color: var(--sidebar-text);
            text-decoration: none;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            border-radius: 8px;
            font-weight: 500;
        }
        
        .sidebar a:hover {
            background-color: var(--sidebar-hover);
            transform: translateX(5px);
        }
        
        .sidebar .nav-link.active {
            background-color: var(--sidebar-active);
            color: white;
            box-shadow: 0 4px 8px rgba(59, 130, 246, 0.3);
        }
        
        .sidebar .nav-link {
            padding: 0.8rem 1rem;
        }
        
        .sidebar .section-title {
            font-size: 0.8rem;
            color: var(--sidebar-section);
            margin-top: 1.5rem;
            margin-bottom: 0.5rem;
            padding-left: 1.5rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .content {
            margin-left: var(--sidebar-width);
            padding: 2rem;
            transition: all 0.3s ease;
        }
        
        .nav-icon {
            margin-right: 12px;
            width: 20px;
            text-align: center;
            font-size: 1rem;
            color: var(--sidebar-icon);
            transition: color 0.2s;
        }
        
        .sidebar a:hover .nav-icon {
            color: white;
        }
        
        .sidebar .nav-link.active .nav-icon {
            color: white;
        }
        
        .logout-container {
            padding: 0 1rem;
            margin-top: 2rem;
            margin-bottom: 1.5rem;
        }
        
        .logout-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            background-color: rgba(220, 38, 38, 0.1);
            color: #ef4444;
            border: 1px solid rgba(220, 38, 38, 0.2);
            padding: 0.8rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            width: 100%;
        }
        
        .logout-btn:hover {
            background-color: #ef4444;
            color: white;
            box-shadow: 0 4px 8px rgba(239, 68, 68, 0.3);
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                width: 240px;
            }
            .content {
                margin-left: 240px;
            }
        }
        
        @media (max-width: 768px) {
            .sidebar {
                width: 0;
                padding: 0;
            }
            .content {
                margin-left: 0;
            }
            .sidebar.active {
                width: 280px;
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar d-flex flex-column">
        <div class="sidebar-header">
            <div class="logo-container">
                <img src="{{ asset('images/technobatanagar-logo.jpg') }}" alt="College Logo" class="logo img-fluid">
            </div>
            <h5 class="panel-title text-center" id="panelHeading">Dashboard</h5>
        </div>

        <ul class="nav flex-column">
            <!-- DASHBOARD LINKS - Role specific -->
            <li class="nav-item" id="adminDashboardLink">
                <a href="/admin/dashboard" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i> Admin Dashboard
                </a>
            </li>
            <li class="nav-item" id="moderatorDashboardLink">
                <a href="/moderator/dashboard" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i> Moderator Dashboard
                </a>
            </li>
            <li class="nav-item" id="studentDashboardLink">
                <a href="/student/dashboard" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i> Student Dashboard
                </a>
            </li>

            <!-- STUDENT SECTION -->
            <div class="section-title" id="studentsSectionTitle">
                <i class="fas fa-user-graduate me-2"></i>STUDENTS
            </div>
            <li class="nav-item" id="addStudentLink">
                <a href="/admin/form" class="nav-link">
                    <i class="nav-icon fas fa-user-plus"></i> Add Student
                </a>
            </li>
            <li class="nav-item" id="studentDetailsLink">
                <a href="/student/table" class="nav-link">
                    <i class="nav-icon fas fa-user-shield"></i> Student Details
                </a>
            </li>
            
            <!-- MODERATOR SECTION -->
            <div class="section-title" id="moderatorSectionTitle">
                <i class="fas fa-users-cog me-2"></i>MODERATORS
            </div>
            <li class="nav-item" id="addModeratorLink">
                <a href="/moderators/add" class="nav-link">
                    <i class="nav-icon fas fa-user-plus"></i> Add Moderator
                </a>
            </li>
            <li class="nav-item" id="moderatorDetailsLink">
                <a href="/moderator/table" class="nav-link">
                    <i class="nav-icon fas fa-clipboard-list"></i> Moderator Details
                </a>
            </li>

            <!-- EXAM SECTION -->
            <div class="section-title" id="examSectionTitle">
                <i class="fas fa-file-alt me-2"></i>EXAMS
            </div>
            <li class="nav-item" id="addExamLink">
                <a href="/exams/add" class="nav-link">
                    <i class="nav-icon fas fa-plus-circle"></i> Add Exam
                </a>
            </li>
            <li class="nav-item" id="examResultsLink">
                <a href="/exams/results" class="nav-link">
                    <i class="nav-icon fas fa-chart-bar"></i> Exam Results
                </a>
            </li>
            <li class="nav-item" id="examListLink">
                <a href="/exams/list" class="nav-link">
                    <i class="nav-icon fas fa-list-alt"></i> Exam List
                </a>
            </li>
            <li class="nav-item" id="myExamsLink">
                <a href="/exams" class="nav-link">
                    <i class="nav-icon fas fa-file-signature"></i> My Exams
                </a>
            </li>
            <li class="nav-item" id="allExamsLink">
                <a href="/exams/all" class="nav-link">
                    <i class="nav-icon fas fa-clipboard-check"></i> All Exams
                </a>
            </li>

            <!-- OTHERS SECTION -->
            <div class="section-title" id="othersSectionTitle">
                <i class="fas fa-cogs me-2"></i>OTHERS
            </div>
            <li class="nav-item" id="coursesLink">
                <a href="/courses" class="nav-link">
                    <i class="nav-icon fas fa-book"></i> Courses
                </a>
            </li>
            <li class="nav-item" id="reportsLink">
                <a href="/reports" class="nav-link">
                    <i class="nav-icon fas fa-chart-line"></i> Reports
                </a>
            </li>
            <li class="nav-item" id="settingsLink">
                <a href="/settings" class="nav-link">
                    <i class="nav-icon fas fa-cog"></i> Settings
                </a>
            </li>
        </ul>

        <div class="logout-container mt-auto">
            <button id="logoutBtn" class="logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </button>
        </div>
    </div>

    <div class="content">
        @yield('content')
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Check which token exists to determine the role
            const hasAdminToken = localStorage.getItem('admin_token') !== null;
            const hasModeratorToken = localStorage.getItem('moderator_token') !== null;
            const hasStudentToken = localStorage.getItem('student_token') !== null;
            
            // Add active class to current page link
            const currentPath = window.location.pathname;
            document.querySelectorAll('.nav-link').forEach(link => {
                const href = link.getAttribute('href');
                if (href === currentPath) {
                    link.classList.add('active');
                }
            });
            
            // Determine which role is logged in and show appropriate sidebar
            if (hasAdminToken) {
                document.getElementById('panelHeading').textContent = 'Admin Panel';
                showAdminSidebar();
            } else if (hasModeratorToken) {
                document.getElementById('panelHeading').textContent = 'Moderator Panel';
                showModeratorSidebar();
            } else if (hasStudentToken) {
                document.getElementById('panelHeading').textContent = 'Student Panel';
                showStudentSidebar();
            }
            
            // Logout functionality
            // document.getElementById('logoutBtn').addEventListener('click', function() {
            //     // Clear all tokens
            //     localStorage.removeItem('admin_token');
            //     localStorage.removeItem('moderator_token');
            //     localStorage.removeItem('student_token');
                
            //     // Redirect to login page
            //     window.location.href = '/login';
            // });
        });

        // Functions to Show/Hide Sections based on Role
        function showAdminSidebar() {
            // Show only Admin Dashboard
            document.getElementById('adminDashboardLink').style.display = 'block';
            document.getElementById('moderatorDashboardLink').style.display = 'none';
            document.getElementById('studentDashboardLink').style.display = 'none';
            
            // Student section
            document.getElementById('studentsSectionTitle').style.display = 'block';
            document.getElementById('addStudentLink').style.display = 'block';
            document.getElementById('studentDetailsLink').style.display = 'block';
            
            // Moderator section
            document.getElementById('moderatorSectionTitle').style.display = 'block';
            document.getElementById('addModeratorLink').style.display = 'block';
            document.getElementById('moderatorDetailsLink').style.display = 'block';
            
            // Exam section
            document.getElementById('examSectionTitle').style.display = 'block';
            document.getElementById('addExamLink').style.display = 'block';
            document.getElementById('examResultsLink').style.display = 'block';
            document.getElementById('examListLink').style.display = 'block';
            document.getElementById('myExamsLink').style.display = 'none'; // Admin doesn't see My Exams
            document.getElementById('allExamsLink').style.display = 'block';
            
            // Others section
            document.getElementById('othersSectionTitle').style.display = 'block';
            document.getElementById('coursesLink').style.display = 'block';
            document.getElementById('reportsLink').style.display = 'block';
            document.getElementById('settingsLink').style.display = 'block';
        }

        function showModeratorSidebar() {
            // Show only Moderator Dashboard
            document.getElementById('adminDashboardLink').style.display = 'none';
            document.getElementById('moderatorDashboardLink').style.display = 'block';
            document.getElementById('studentDashboardLink').style.display = 'none';
            
            // Student section - no add student
            document.getElementById('studentsSectionTitle').style.display = 'block';
            document.getElementById('addStudentLink').style.display = 'none'; // Moderator can't add students
            document.getElementById('studentDetailsLink').style.display = 'block';
            
            // Hide Moderator Section
            document.getElementById('moderatorSectionTitle').style.display = 'block';
            document.getElementById('addModeratorLink').style.display = 'none'; // Moderator can't add moderators
            document.getElementById('moderatorDetailsLink').style.display = 'block';
            
            // Exam section
            document.getElementById('examSectionTitle').style.display = 'block';
            document.getElementById('addExamLink').style.display = 'block';
            document.getElementById('examResultsLink').style.display = 'block';
            document.getElementById('examListLink').style.display = 'block';
            document.getElementById('myExamsLink').style.display = 'none'; // Moderator doesn't see My Exams
            document.getElementById('allExamsLink').style.display = 'block';
            
            // Others section
            document.getElementById('othersSectionTitle').style.display = 'block';
            document.getElementById('coursesLink').style.display = 'block';
            document.getElementById('reportsLink').style.display = 'block';
            document.getElementById('settingsLink').style.display = 'block';
        }

        function showStudentSidebar() {
            // Show only Student Dashboard
            document.getElementById('adminDashboardLink').style.display = 'none';
            document.getElementById('moderatorDashboardLink').style.display = 'none';
            document.getElementById('studentDashboardLink').style.display = 'block';
            
            // Hide Student section
            document.getElementById('studentsSectionTitle').style.display = 'none';
            document.getElementById('addStudentLink').style.display = 'none';
            document.getElementById('studentDetailsLink').style.display = 'none';
            
            // Hide Moderator Section
            document.getElementById('moderatorSectionTitle').style.display = 'none';
            document.getElementById('addModeratorLink').style.display = 'none';
            document.getElementById('moderatorDetailsLink').style.display = 'none';
            
            // Show limited Exam section
            document.getElementById('examSectionTitle').style.display = 'block';
            document.getElementById('addExamLink').style.display = 'none';
            document.getElementById('examResultsLink').style.display = 'none';
            document.getElementById('examListLink').style.display = 'block'; // Students can see Exam List
            document.getElementById('myExamsLink').style.display = 'block'; // Only students see My Exams
            document.getElementById('allExamsLink').style.display = 'block'; // Students can see All Exams
            
            // Hide Others section
            document.getElementById('othersSectionTitle').style.display = 'none';
            document.getElementById('coursesLink').style.display = 'none';
            document.getElementById('reportsLink').style.display = 'none';
            document.getElementById('settingsLink').style.display = 'none';
        }
    </script>
</body>
</html>
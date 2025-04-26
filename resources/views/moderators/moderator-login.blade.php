<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Moderator Login | Techno Batanagar</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    body, html {
      height: 100%;
      margin: 0;
      background: url('{{ asset('images/bg-wave.svg') }}') no-repeat center bottom;
      background-size: cover;
      font-family: 'Segoe UI', sans-serif;
    }

    .form-container {
      background-color: rgba(255, 255, 255, 0.95);
      padding: 2rem;
      border-radius: 1rem;
      box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }

    .college-img {
      height: 90vh;
      object-fit: cover;
      border-radius: 0 0 0 1rem;
    }

    .btn-custom {
      border-radius: 50px;
    }

    .floating-img {
      animation: floatImage 6s ease-in-out infinite;
    }

    @keyframes floatImage {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-10px); }
    }
  </style>
</head>
<body>

<div class="container-fluid">
  <div class="row g-0">
    <!-- Left College Info -->
    <div class="col-md-6 mt-5 d-none d-md-flex align-items-center justify-content-center position-relative" style="background-color: transparent;">
      <div class="text-center p-4" style="max-width: 90%;">
        <img src="{{ asset('images/college.jpeg') }}" alt="College" class="img-fluid floating-img mb-4" style="max-height: 300px; border-radius: 1rem;">
        <h3 class="mb-3 text-white">Techno Batanagar</h3>
        <p class="text-white">
          Techno International Batanagar is a premier institute committed to academic excellence and innovation. Join us in shaping the future through knowledge and leadership.
        </p>
      </div>
    </div>

    <!-- Right Form -->
    <div class="col-md-6 d-flex align-items-center justify-content-center">
      <div class="form-container w-75 shadow-lg bg-white bg-opacity-75 p-4 rounded-4">
        <ul class="nav nav-tabs mb-4 justify-content-center" id="authTabs">
          <li class="nav-item">
            <a class="nav-link active text-secondary fw-semibold" data-bs-toggle="tab" href="#loginTab">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-secondary fw-semibold" data-bs-toggle="tab" href="#signupTab">Sign Up</a>
          </li>
        </ul>

        <div class="tab-content">
          <!-- Login Tab -->
          <div class="tab-pane fade show active" id="loginTab">
            <form id="loginForm">
              <div class="mb-3">
                <label class="form-label text-muted">Email</label>
                <input type="email" class="form-control bg-light border-0 rounded-3" name="email" required>
              </div>
              <div class="mb-3">
                <label class="form-label text-muted">Password</label>
                <input type="password" class="form-control bg-light border-0 rounded-3" name="password" required>
              </div>
              <button type="submit" class="btn btn-dark w-100 rounded-pill">Login</button>
            </form>
          </div>

          <!-- Sign Up Tab -->
          <div class="tab-pane fade" id="signupTab">
            <form id="signupForm">
              <div class="mb-3">
                <label class="form-label text-muted">Name</label>
                <input type="text" class="form-control bg-light border-0 rounded-3" name="name" required>
              </div>
              <div class="mb-3">
                <label class="form-label text-muted">Email</label>
                <input type="email" class="form-control bg-light border-0 rounded-3" name="email" required>
              </div>
              <div class="mb-3">
                <label class="form-label text-muted">Password</label>
                <input type="password" class="form-control bg-light border-0 rounded-3" name="password" required>
              </div>
              <div class="mb-3">
                <label class="form-label text-muted">Phone <small class="text-muted">(optional)</small></label>
                <input type="text" class="form-control bg-light border-0 rounded-3" name="phone">
              </div>
              <div class="mb-3">
                <label class="form-label text-muted">Designation <small class="text-muted">(optional)</small></label>
                <input type="text" class="form-control bg-light border-0 rounded-3" name="designation">
              </div>
              <button type="submit" class="btn btn-secondary w-100 rounded-pill">Sign Up</button>
            </form>
          </div>
        </div>

        <p class="mt-4 text-center text-muted">New here? <a href="#" class="text-decoration-none fw-medium" onclick="switchToSignup()">Sign up</a></p>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- JavaScript for API Calls -->
<script>
  const loginForm = document.getElementById('loginForm');
  const signupForm = document.getElementById('signupForm');

  loginForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(loginForm);
    const body = Object.fromEntries(formData.entries());

    try {
      const res = await fetch(`/api/moderators/login`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(body)
      });

      const data = await res.json();

      if (!data.success) {
        Swal.fire('Login Failed', data.result || 'Invalid credentials.', 'error');
      } else {
        Swal.fire({
          title: 'Login Successful!',
          text: 'Welcome moderator!',
          icon: 'success',
          timer: 1500,
          showConfirmButton: false
        }).then(() => {
          localStorage.setItem('moderator_token', data.token);
          window.location.href = '/moderator/dashboard';
        });
      }
    } catch (err) {
      Swal.fire('Server Error', 'Please try again later.', 'error');
    }
  });

  signupForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(signupForm);
    const body = Object.fromEntries(formData.entries());

    try {
      const res = await fetch(`/api/moderators`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(body)
      });

      const data = await res.json();

      if (!data.success) {
        Swal.fire('Signup Failed', data.result || 'Invalid data or email already taken.', 'error');
      } else {
        Swal.fire({
          title: 'Signup Successful!',
          text: 'Welcome aboard, moderator!',
          icon: 'success',
          timer: 1500,
          showConfirmButton: false
        }).then(() => {
          window.location.href = '/moderator/login';
        });
      }
    } catch (err) {
      Swal.fire('Server Error', 'Please try again later.', 'error');
    }
  });

  function switchToSignup() {
    new bootstrap.Tab(document.querySelector('a[href="#signupTab"]')).show();
  }
</script>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Portal - Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/student-login.css') }}">
</head>
<body>
<div class="container">
    <div class="left-panel">
        <!-- Background SVG and animated College Image -->
        <div class="svg-background">
            <img src="{{ asset('images/college.jpeg') }}" class="photo" alt="College Photo">
            <p class="college-about">Welcome to our prestigious college, where we nurture the future leaders and innovators of tomorrow. Our campus is filled with a rich history of academic excellence and vibrant student life.</p>
        </div>
    </div>
    <div class="right-panel">
        <div class="form-wrapper">
            <h2 id="form-title">Student Login</h2>

            <!-- LOGIN FORM -->
            <form id="studentLoginForm">
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
                <p class="toggle">New here? <span onclick="toggleForm()">Sign Up</span></p>
            </form>
            <!-- SIGNUP FORM -->
            <form id="studentSignUpForm" style="display: none;">
                <div class="form-step">
                    <input name="name" required placeholder="Full Name" />
                    <input type="email" name="email" required placeholder="Email" />
                    <input type="password" name="password" required placeholder="Password" />
                    <input name="phone" required placeholder="Phone" />
                </div>

                <div class="form-step" style="display: none;">
                    <input name="alt_phone" placeholder="Alt Phone" />
                    <input name="whatsapp" placeholder="WhatsApp" />
                    <input type="date" name="dob" />
                    <input name="birth_place" placeholder="Birth Place" />
                    <input name="region" placeholder="Region" />
                </div>

                <div class="form-step" style="display: none;">
                    <input name="caste" placeholder="Caste" />
                    <input name="blood_group" placeholder="Blood Group" />
                    <input name="identity_details" placeholder="Identity Details" />
                    <input name="current_address" placeholder="Current Address" />
                    <input name="permanent_address" placeholder="Permanent Address" />
                </div>

                <div class="form-step" style="display: none;">
                    <input name="qualification" placeholder="Qualification" />
                    <input name="passing_year" placeholder="Passing Year" />
                    <input name="percentage" placeholder="Percentage" />
                    <input name="institution" placeholder="Institution Name" />
                </div>

                <div style="margin-top: 20px;">
                    <button type="button" id="prevBtn">Previous</button>
                    <button type="button" id="nextBtn">Next</button>
                    <button type="submit" id="submitBtn">Submit</button>
                    <p class="toggle">Already registered? <span onclick="toggleForm()">Login</span></p>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- SCRIPT -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const loginForm = document.getElementById("studentLoginForm");
    const signupForm = document.getElementById("studentSignUpForm");
    const formTitle = document.getElementById("form-title");

    const nextBtn = document.getElementById("nextBtn");
    const prevBtn = document.getElementById("prevBtn");
    const submitBtn = document.getElementById("submitBtn");

    let currentStep = 0;
    const formSteps = signupForm.querySelectorAll(".form-step");
    const formData = {};

    if (signupForm) showStep(currentStep);

    // ========== FORM TOGGLE ==========
    window.toggleForm = function () {
        if (loginForm.style.display === "none") {
            // Switch to login
            loginForm.style.display = "block";
            signupForm.style.display = "none";
            formTitle.textContent = "Student Login";
        } else {
            // Switch to sign-up
            loginForm.style.display = "none";
            signupForm.style.display = "block";
            formTitle.textContent = "Student Sign Up";
        }
    };

    // ========== SIGNUP MULTI-STEP ==========
    if (nextBtn && prevBtn && submitBtn) {
        nextBtn.addEventListener("click", function () {
            if (validateStep(currentStep)) {
                currentStep++;
                showStep(currentStep);
            }
        });

        prevBtn.addEventListener("click", function () {
            currentStep--;
            showStep(currentStep);
        });

        submitBtn.addEventListener("click", function (e) {
            e.preventDefault();
            if (validateStep(currentStep)) {
                const inputs = signupForm.querySelectorAll("input, select, textarea");
                inputs.forEach(input => {
                    formData[input.name] = input.value.trim();
                });

                fetch("/api/students", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json"
                    },
                    body: JSON.stringify(formData)
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 200 || data.token) {
                        alert("Sign up successful!");
                        toggleForm(); // Switch to login
                    } else {
                        alert("Signup failed: " + (data.message || "Check inputs"));
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert("Error signing up. Try again.");
                });
            }
        });
    }

    function showStep(step) {
        formSteps.forEach((stepDiv, i) => {
            stepDiv.style.display = i === step ? "block" : "none";
        });
        prevBtn.style.display = step === 0 ? "none" : "inline-block";
        nextBtn.style.display = step === formSteps.length - 1 ? "none" : "inline-block";
        submitBtn.style.display = step === formSteps.length - 1 ? "inline-block" : "none";
    }

    function validateStep(step) {
        const inputs = formSteps[step].querySelectorAll("input[required], select[required], textarea[required]");
        for (let input of inputs) {
            if (!input.value.trim()) {
                alert("Please fill out: " + input.name);
                input.focus();
                return false;
            }
        }
        return true;
    }

    // ========== LOGIN ==========
    if (loginForm) {
        loginForm.addEventListener("submit", function (e) {
            e.preventDefault();

            const email = loginForm.querySelector("input[name='email']").value.trim();
            const password = loginForm.querySelector("input[name='password']").value.trim();

            if (!email || !password) {
                alert("Please fill in both fields.");
                return;
            }

            console.log("Logging in with:", email, password);  // Check what data is being sent

            fetch("/api/students/login", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json"
                },
                body: JSON.stringify({ email, password })
            })
            .then(res => res.json())
            .then(data => {
                console.log("Full login response:", data);  // Check the complete response structure

                // Adjust for nested response (if applicable)
                if (data && data.result.token) {
                    console.log("Token found:", data.result.token);  // Log token to verify it's there
                    localStorage.setItem("student_token", data.result.token);
                    alert("Login successful!");
                    window.location.href = "/student/dashboard";
                } else {
                    alert("Login failed: " + (data.message || "Invalid credentials"));
                }
            })
            .catch(err => {
                console.error("Login error:", err);
                alert("Login error.");
            });
        });
    }
});
</script>
</body>
</html>

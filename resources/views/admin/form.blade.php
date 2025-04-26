@extends('layout.sidebar')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4" style="color: #242dd1">Student Registration Form</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('students.store') }}" method="POST" id="studentForm">
        @csrf

        <div class="card p-4">
            <!-- Progress Bar -->
                <div class="progress mb-4">
                    <div class="progress-bar" role="progressbar" style="width: 25%;" id="formProgress" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                        Step 1 of 4
                        </div>
                </div>

   
            <div class="form-step" id="step-1">
                <h5>Step 1: Basic Information</h5>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label>Student Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="col-md-4 mt-2">
                        <label>Phone</label>
                        <input type="text" name="phone" class="form-control" required>
                    </div>
                    <div class="col-md-4 mt-3">
                        <label>Alternate Phone</label>
                        <input type="text" name="alt_phone" class="form-control">
                    </div>
                    <div class="col-md-4 mt-3">
                        <label>WhatsApp Number</label>
                        <input type="text" name="whatsapp" class="form-control">
                    </div>
                </div>
                <button type="button" class="btn btn-primary float-end" onclick="nextStep(2)">Next</button>
            </div>

            <!-- Step 2: Identity Info -->
            <div class="form-step d-none" id="step-2">
                <h5>Step 2: Identity Information</h5>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Date of Birth</label>
                        <input type="date" name="dob" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label>Place of Birth</label>
                        <input type="text" name="birth_place" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label>Region</label>
                        <input type="text" name="region" class="form-control">
                    </div>
                    <div class="col-md-6 mt-3">
                        <label>Caste</label>
                        <input type="text" name="caste" class="form-control">
                    </div>
                    <div class="col-md-6 mt-3">
                        <label>Blood Group</label>
                        <input type="text" name="blood_group" class="form-control">
                    </div>
                    <div class="col-12 mt-3">
                        <label>Identity Details</label>
                        <input type="text" name="identity_details" class="form-control">
                    </div>
                </div>
                <button type="button" class="btn btn-secondary" onclick="nextStep(1)">Previous</button>
                <button type="button" class="btn btn-primary float-end" onclick="nextStep(3)">Next</button>
            </div>

            <!-- Step 3: Address -->
            <div class="form-step d-none" id="step-3">
                <h5>Step 3: Address Information</h5>
                <div class="mb-3">
                    <label>Current Address</label>
                    <textarea name="current_address" class="form-control" rows="2"></textarea>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="copyAddress">
                    <label class="form-check-label" for="copyAddress">
                        Same as Current Address
                    </label>
                </div>
                <div class="mb-3">
                    <label>Permanent Address</label>
                    <textarea name="permanent_address" class="form-control" rows="2" id="permanentAddress"></textarea>
                </div>
                <button type="button" class="btn btn-secondary" onclick="nextStep(2)">Previous</button>
                <button type="button" class="btn btn-primary float-end" onclick="nextStep(4)">Next</button>
            </div>

            <!-- Step 4: Academic -->
            <div class="form-step d-none" id="step-4">
                <h5>Step 4: Academic Information</h5>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label>Qualification</label>
                        <input type="text" name="qualification" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label>Passing Year</label>
                        <input type="text" name="passing_year" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label>Percentage</label>
                        <input type="text" name="percentage" class="form-control">
                    </div>
                    <div class="col-12 mt-3">
                        <label>Institution</label>
                        <input type="text" name="institution" class="form-control">
                    </div>
                </div>
                <button type="button" class="btn btn-secondary" onclick="nextStep(3)">Previous</button>
                <button type="submit" class="btn btn-success float-end">Submit</button>
            </div>
        </div>
    </form>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function nextStep(step) {
        
          document.querySelectorAll('.form-step').forEach(stepEl => stepEl.classList.add('d-none'));


document.getElementById(`step-${step}`).classList.remove('d-none');


const progressBar = document.getElementById('formProgress');
const stepPercentages = {
    1: 25,
    2: 50,
    3: 75,
    4: 100
};

progressBar.style.width = `${stepPercentages[step]}%`;
progressBar.setAttribute('aria-valuenow', stepPercentages[step]);
progressBar.textContent = `Step ${step} of 4`;
    }

  
    document.getElementById('copyAddress').addEventListener('change', function () {
        const current = document.querySelector('[name="current_address"]').value;
        document.getElementById('permanentAddress').value = this.checked ? current : '';
    });
</script>

<style>
    body {
    background: url('{{ asset('images/bg-wave.svg') }}') no-repeat top center;
    background-size: cover;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    position: relative;
}


    .svg-background {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        z-index: -1;
    }

    .container {
        margin-top: 100px;
        background: #b6b2b2;
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
        position: relative;
        z-index: 1;
        opacity: 0.9;
    }
    .card{
        background-color: #b6b2b2;
    }

    .progress-bar {
        background: linear-gradient(90deg, #4e54c8, #8f94fb);
        font-weight: bold;
    }

    .form-control, textarea {
        border-radius: 10px;
        border: 1px solid #d1d1d1;
        box-shadow: none;
    }

    .form-control:focus, textarea:focus {
        border-color: #8f94fb;
        box-shadow: 0 0 0 0.2rem rgba(143, 148, 251, 0.25);
    }

    .btn-primary {
        background-color: #4e54c8;
        border: none;
        border-radius: 8px;
    }

    .btn-success {
        background-color: #28a745;
        border-radius: 8px;
    }

    .btn-secondary {
        border-radius: 8px;
    }

    .form-step h5 {
        font-weight: 600;
        margin-bottom: 20px;
        color: #4e54c8;
    }
</style>

@endsection

@extends('layout.sidebar')

@section('content')
<div class="container">
    <h2>Edit Student</h2>

    <form id="edit-student-form"  style="max-width: 800px; margin: auto;">
        @method('PUT')

        <div class="form-group">
            <label>Name:</label>
            <input type="text" name="name" value="{{ $student->name }}" required>
        </div>

        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" value="{{ $student->email }}" required>
        </div>
        <div class="form-group">
            <label>Password:</label>
            <input type="password" name="password" placeholder="Enter new password (leave blank to keep current)">
        </div>

        <div class="form-group">
            <label>Phone:</label>
            <input type="text" name="phone" value="{{ $student->phone }}" required>
        </div>

        <div class="form-group">
            <label>Alt Phone:</label>
            <input type="text" name="alt_phone" value="{{ $student->alt_phone }}">
        </div>

        <div class="form-group">
            <label>WhatsApp:</label>
            <input type="text" name="whatsapp" value="{{ $student->whatsapp }}">
        </div>

        <div class="form-group">
            <label>Date of Birth:</label>
            <input type="date" name="dob" value="{{ $student->dob }}">
        </div>

        <div class="form-group">
            <label>Birth Place:</label>
            <input type="text" name="birth_place" value="{{ $student->birth_place }}">
        </div>

        <div class="form-group">
            <label>Region:</label>
            <input type="text" name="region" value="{{ $student->region }}">
        </div>

        <div class="form-group">
            <label>Caste:</label>
            <input type="text" name="caste" value="{{ $student->caste }}">
        </div>

        <div class="form-group">
            <label>Blood Group:</label>
            <input type="text" name="blood_group" value="{{ $student->blood_group }}">
        </div>

        <div class="form-group">
            <label>Identity Details:</label>
            <textarea name="identity_details">{{ $student->identity_details }}</textarea>
        </div>

        <div class="form-group">
            <label>Current Address:</label>
            <textarea name="current_address">{{ $student->current_address }}</textarea>
        </div>

        <div class="form-group">
            <label>Permanent Address:</label>
            <textarea name="permanent_address">{{ $student->permanent_address }}</textarea>
        </div>

        <div class="form-group">
            <label>Qualification:</label>
            <input type="text" name="qualification" value="{{ $student->qualification }}">
        </div>

        <div class="form-group">
            <label>Passing Year:</label>
            <input type="number" name="passing_year" value="{{ $student->passing_year }}">
        </div>

        <div class="form-group">
            <label>Percentage:</label>
            <input type="number" step="0.01" name="percentage" value="{{ $student->percentage }}">
        </div>

        <div class="form-group">
            <label>Institution:</label>
            <input type="text" name="institution" value="{{ $student->institution }}">
        </div>

        <button type="submit">Update Student</button>
    </form>
</div>

<style>
    body {
        background: url('{{ asset('images/bg-wave.svg') }}') no-repeat top center;
        background-size: cover;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 0;
        padding: 0;
    }

    .container {
        padding: 30px;
        background-color: rgba(255, 255, 255, 0.9);
        border-radius: 10px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        max-width: 800px;
        margin: 50px auto;
    }

    h2 {
        text-align: center;
        margin-bottom: 30px;
        color: #4e54c8;
        font-size: 2rem;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 6px;
        font-weight: 600;
        color: #333;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 1rem;
        transition: all 0.2s ease-in-out;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        border-color: #4e54c8;
        box-shadow: 0 0 6px rgba(78, 84, 200, 0.3);
        outline: none;
    }

    .form-group textarea {
        resize: vertical;
        min-height: 80px;
    }

    button[type="submit"] {
        background: linear-gradient(to right, #4e54c8, #8f94fb);
        color: white;
        padding: 12px 24px;
        border: none;
        border-radius: 6px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: block;
        margin: 30px auto 0;
    }

    button[type="submit"]:hover {
        background: linear-gradient(to right, #3d43b2, #7d84f7);
    }
</style>


<script>
    document.getElementById('edit-student-form').addEventListener('submit', function(event) {
        event.preventDefault();
    
        const studentId = {{ $student->id }};
        const token = localStorage.getItem('admin_token');
        
        if (!token) {
            alert("You're not logged in. Please log in first.");
            return;
        }

        const formData = new FormData(this);
        const data = {};
        formData.forEach((value, key) => {
            if (value !== '') data[key] = value; // Skip empty values like blank password
        });

        fetch(`/api/students/edit/${studentId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + token
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(result => {
            alert('Student updated successfully!');
            window.location.href = "/admin/table"; // redirect if needed
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error updating student: ' + (error.message || 'Unknown error'));
        });
    });
</script>

    
@endsection

@extends('master.app')

@section('title', 'Sign Up')

@push('styles')
<style>
    .auth-wrapper {
        min-height: calc(100vh - 100px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
    }
    .auth-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
        overflow: hidden;
        width: 100%;
        max-width: 520px;
        border: 1px solid rgba(0,0,0,0.06);
    }
    .auth-header {padding: 2.5rem 2.5rem 1.5rem;text-align: center}
    .auth-header h2 {font-weight:800;color:#1f2937;margin-bottom:0.5rem;font-size:1.75rem}
    .auth-header p {color:#6b7280;font-size:0.95rem}
    .auth-body {padding:0 2.5rem 2.5rem}
    .form-control {border-radius:10px;border:1.5px solid #e5e7eb;padding:1rem 0.75rem;background-color:#f9fafb}
    .form-control:focus{background-color:#fff;border-color:#0d6efd;box-shadow:0 0 0 4px rgba(13,110,253,0.08)}
    .btn-auth{border-radius:10px;padding:.85rem 1.5rem;font-weight:600}
    .btn-google{background:#fff;color:#4b5563;border:1.5px solid #e5e7eb;display:flex;align-items:center;justify-content:center;gap:.75rem}
    .divider{display:flex;align-items:center;text-align:center;margin:1.75rem 0;color:#9ca3af;font-size:.85rem}
    .divider::before,.divider::after{content:'';flex:1;border-bottom:1px solid #e5e7eb}
    .auth-footer{text-align:center;margin-top:1.5rem;font-size:.95rem;color:#6b7280}
    .auth-footer a{color:#0d6efd;font-weight:600;text-decoration:none}
    /* Ensure navbar toggler icon is visible across builds */
    .navbar-toggler-icon {
        background-image: url("data:image/svg+xml;charset=utf8,%3csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3e%3cpath stroke='rgba(15,23,42,0.7)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    }
    @media (max-width:576px){.auth-card{max-width:92%;margin:0 1rem}}
</style>
@endpush

@section('content')
<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-header">
            <h2>Create Account</h2>
            <p>Sign up to get started — we'll never share your details.</p>
        </div>

        <div class="auth-body">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('signup') }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" required>
                    @error('phone')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                    @error('password')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>

                <button type="submit" class="btn btn-primary btn-auth w-100 mb-3">Create Account</button>

                <div class="divider">OR CONTINUE WITH</div>

                <a href="{{ route('google.redirect') }}" class="btn btn-google btn-auth w-100 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="20" height="20"><path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"/><path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"/><path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"/><path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"/></svg>
                    Sign up with Google
                </a>

                <div class="auth-footer">
                    Already have an account? <a href="{{ route('login') }}">Login here</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

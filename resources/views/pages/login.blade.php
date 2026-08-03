@extends('master.app')

@section('title', 'Login')

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
        max-width: 450px;
        border: 1px solid rgba(0,0,0,0.06);
    }
    .auth-header {
        padding: 2.5rem 2.5rem 1.5rem;
        text-align: center;
    }
    .auth-header h2 {
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 0.5rem;
        font-size: 1.75rem;
    }
    .auth-header p {
        color: #6b7280;
        font-size: 0.95rem;
    }
    .auth-body {
        padding: 0 2.5rem 2.5rem;
    }
    .form-floating > .form-control:focus ~ label,
    .form-floating > .form-control:not(:placeholder-shown) ~ label {
        color: #0d6efd;
    }
    .form-control {
        border-radius: 10px;
        border: 1.5px solid #e5e7eb;
        padding: 1rem 0.75rem;
        background-color: #f9fafb;
        transition: all 0.2s;
    }
    .form-control:focus {
        background-color: #ffffff;
        border-color: #0d6efd;
        box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
    }
    .btn-auth {
        border-radius: 10px;
        padding: 0.85rem 1.5rem;
        font-weight: 600;
        letter-spacing: 0.3px;
        transition: all 0.2s ease;
    }
    .btn-auth:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 6px -1px rgba(13, 110, 253, 0.2), 0 2px 4px -1px rgba(13, 110, 253, 0.1);
    }
    .btn-google {
        background-color: #ffffff;
        color: #4b5563;
        border: 1.5px solid #e5e7eb;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
    }
    .btn-google:hover {
        background-color: #f9fafb;
        color: #1f2937;
        border-color: #d1d5db;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        transform: none;
    }
    .divider {
        display: flex;
        align-items: center;
        text-align: center;
        margin: 1.75rem 0;
        color: #9ca3af;
        font-size: 0.85rem;
        font-weight: 500;
        letter-spacing: 0.5px;
    }
    .divider::before,
    .divider::after {
        content: '';
        flex: 1;
        border-bottom: 1px solid #e5e7eb;
    }
    .divider:not(:empty)::before {
        margin-right: 1em;
    }
    .divider:not(:empty)::after {
        margin-left: 1em;
    }
    .auth-footer {
        text-align: center;
        margin-top: 2rem;
        font-size: 0.95rem;
        color: #6b7280;
    }
    .auth-footer a {
        color: #0d6efd;
        font-weight: 600;
        text-decoration: none;
        transition: color 0.2s;
    }
    .auth-footer a:hover {
        color: #0b5ed7;
        text-decoration: underline;
    }
    /* Ensure navbar toggler icon is visible across builds */
    .navbar-toggler-icon {
        background-image: url("data:image/svg+xml;charset=utf8,%3csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3e%3cpath stroke='rgba(15,23,42,0.7)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    }
    @media (max-width:576px){
        .auth-card{max-width:92%;margin:0 1rem}
        .auth-header h2{font-size:1.5rem}
    }
</style>
@endpush

@section('content')
<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-header">
            <h2>Welcome Back</h2>
            <p>Please enter your details to sign in.</p>
        </div>
        
        <div class="auth-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">{{ session('status') }}</div>
            @endif

            @if (session('csrf_error'))
                <div class="alert alert-warning" role="alert">{{ session('csrf_error') }}</div>
            @endif

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

            <form method="POST" action="{{ route('loginCheck') }}">
                @csrf

                <div class="form-floating mb-3">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                        id="email" name="email" placeholder="name@example.com" value="{{ old('email') }}" required>
                    <label for="email">Email Address</label>
                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                        id="password" name="password" placeholder="Password" required>
                    <label for="password">Password</label>
                    @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label text-muted" for="remember">Remember me</label>
                    </div>
                    <a href="{{ route('password.request') }}" class="text-decoration-none fw-semibold">Forgot password?</a>
                </div>

                <button type="submit" class="btn btn-primary btn-auth w-100 mb-3">Sign In</button>

                <div class="divider">OR CONTINUE WITH</div>

                <a href="{{ route('google.redirect') }}" class="btn btn-google btn-auth w-100">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="20px" height="20px"><path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"/><path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"/><path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"/><path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"/></svg>
                    Sign in with Google
                </a>

                <div class="auth-footer">
                    Don't have an account? <a href="{{ route('viewSignup') }}">Sign up here</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

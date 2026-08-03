@extends('master.app')

@section('title', 'Forgot Password')

@push('styles')
<style>
    .auth-wrapper{min-height:calc(100vh - 100px);display:flex;align-items:center;justify-content:center;padding:2rem 1rem}
    .auth-card{background:#fff;border-radius:16px;box-shadow:0 10px 25px -5px rgba(0,0,0,.05),0 8px 10px -6px rgba(0,0,0,.01);width:100%;max-width:450px;border:1px solid rgba(0,0,0,.06)}
    .auth-header{padding:2.5rem 2.5rem 1.5rem;text-align:center}
    .auth-header h2{font-weight:800;color:#1f2937;margin-bottom:.5rem;font-size:1.75rem}
    .auth-header p{color:#6b7280;font-size:.95rem;margin-bottom:0}
    .auth-body{padding:0 2.5rem 2.5rem}
    .form-control{border-radius:10px;border:1.5px solid #e5e7eb;padding:1rem .75rem;background:#f9fafb}
    .form-control:focus{background:#fff;border-color:#0d6efd;box-shadow:0 0 0 4px rgba(13,110,253,.1)}
    .btn-auth{border-radius:10px;padding:.85rem 1.5rem;font-weight:600}
    .auth-footer{text-align:center;margin-top:1.5rem;color:#6b7280}
    .auth-footer a{color:#0d6efd;font-weight:600;text-decoration:none}
</style>
@endpush

@section('content')
<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-header">
            <h2>Forgot Password?</h2>
            <p>Enter your email and we will send you a secure password reset link.</p>
        </div>
        <div class="auth-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="form-floating mb-4">
                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                        id="email" name="email" placeholder="name@example.com" value="{{ old('email') }}"
                        required autofocus autocomplete="email">
                    <label for="email">Email Address</label>
                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary btn-auth w-100">Send Reset Link</button>
            </form>

            <div class="auth-footer">
                Remembered your password? <a href="{{ route('login') }}">Back to login</a>
            </div>
        </div>
    </div>
</div>
@endsection
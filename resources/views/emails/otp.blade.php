@extends('layouts.app')
@section('title', 'Email Verification')
@section('styles')
<style>
    .otp {
        min-height: 100vh;
        background: #f8f8f4;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: "Segoe UI", sans-serif;
    }

    .verify-card {
        max-width: 420px;
        width: 100%;
        background: #fff;
        border-radius: 20px;
        padding: 40px 30px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        text-align: center;
    }

    .icon-circle {
        width: 80px;
        height: 80px;
        margin: 0 auto 20px;
        border-radius: 50%;
        background: #eef5ff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 34px;
        color: #4facfe;
    }

    .otp-inputs input {
        width: 50px;
        height: 55px;
        text-align: center;
        font-size: 22px;
        border-radius: 10px;
        border: 1px solid #ddd;
        margin: 0 6px;
    }

    .otp-inputs input:focus {
        border-color: #4facfe;
        box-shadow: 0 0 0 2px rgba(79, 172, 254, 0.2);
    }

    .btn-confirm {
        background: #4facfe;
        border: none;
        border-radius: 12px;
        padding: 12px;
        font-size: 16px;
    }

    .btn-confirm:hover {
        background: #3a9cfb;
    }

    .resend {
        font-size: 14px;
    }

    .resend a {
        color: #4facfe;
        text-decoration: none;
        font-weight: 500;
    }

    .resend a:hover {
        text-decoration: underline;
    }
</style>
@section('content')
<div class="otp">
    <div class="verify-card">
        <div class="icon-circle">
            ✉️
        </div>

        <h4 class="fw-bold mb-2">Verify your email</h4>
        <p class="text-muted mb-4">
            Please enter the 5 digit code sent to<br>
            <strong>{{ session('verify_email') }}</strong>
        </p>

        <form method="POST" action="{{ route('verify#email') }}" id="otpForm">
            @csrf

            {{-- Hidden field to hold final OTP --}}
            <input type="hidden" name="code" id="otpCode">

            <div class="d-flex justify-content-center otp-inputs mb-4">
                <input type="text" maxlength="1" class="form-control otp-input" inputmode="numeric">
                <input type="text" maxlength="1" class="form-control otp-input" inputmode="numeric">
                <input type="text" maxlength="1" class="form-control otp-input" inputmode="numeric">
                <input type="text" maxlength="1" class="form-control otp-input" inputmode="numeric">
                <input type="text" maxlength="1" class="form-control otp-input" inputmode="numeric">
                <input type="text" maxlength="1" class="form-control otp-input" inputmode="numeric">
            </div>

            @error('code')
                <div class="text-danger text-center mb-3">
                    {{ $message }}
                </div>
            @enderror

            <button type="submit" class="btn btn-outline-dark w-100 mb-3">
                Confirm
            </button>
        </form>

        <div class="resend text-muted">
            Don't receive code?
            <a href="#">Resend code</a>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    const inputs = document.querySelectorAll('.otp-input');
    const hiddenInput = document.getElementById('otpCode');
    const form = document.getElementById('otpForm');

    inputs.forEach((input, index) => {
        input.addEventListener('input', () => {
            input.value = input.value.replace(/[^0-9]/g, '');

            if (input.value && index < inputs.length - 1) {
                inputs[index + 1].focus();
            }

            updateOtp();
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && !input.value && index > 0) {
                inputs[index - 1].focus();
            }
        });
    });

    function updateOtp() {
        hiddenInput.value = Array.from(inputs)
            .map(input => input.value)
            .join('');
    }

    form.addEventListener('submit', (e) => {
        updateOtp();

        if (hiddenInput.value.length !== 6) {
            e.preventDefault();
            alert('Please enter the complete 6-digit code.');
        }
    });
</script>
@endsection


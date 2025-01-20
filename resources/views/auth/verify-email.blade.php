<x-guest-layout>
    <div class="left-content">
        <div class="login-form-container">
            <div class="login-form">
                <h1 class="form-title text-center mb-4">VERIFY EMAIL</h1>

                <p class="text-center mb-4">
                    Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.
                </p>

                @if (session('status') == 'verification-link-sent')
                    <div class="alert alert-success text-center">
                        A new verification link has been sent to the email address you provided during registration.
                    </div>
                @endif

                <!-- Resend Verification Email -->
                <form method="POST" action="{{ route('verification.send') }}" class="text-center">
                    @csrf
                    <button type="submit" class="btn btn-login">RESEND VERIFICATION EMAIL</button>
                </form>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}" class="text-center mt-3">
                    @csrf
                    <button type="submit" class="back-link">Log Out</button>
                </form>
            </div>
        </div>
    </div>

    <div class="right-content"></div>
</x-guest-layout>

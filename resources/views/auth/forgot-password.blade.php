<x-guest-layout>
    <div class="left-content">
        <div class="login-form-container">
            <div class="login-form">
                <h1 class="form-title text-center mb-4">FORGOT PASSWORD</h1>
                
                <p class="text-center mb-4">
                    Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
                </p>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="alert alert-success text-center mb-4">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="mb-4">
                        <label for="email" class="form-label">EMAIL</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email address" value="{{ old('email') }}" required autofocus>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-login">SEND RESET LINK</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="right-content"></div>
</x-guest-layout>

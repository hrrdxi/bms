<x-guest-layout>
    <div class="left-content">
        <div class="login-form-container">
            <div class="login-form">
                <h1 class="form-title text-center mb-4">REGISTER</h1>
                
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div class="mb-4">
                        <label for="name" class="form-label">NAME</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name" required autofocus>
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="form-label">EMAIL</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label for="password" class="form-label">PASSWORD</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Create a password" required>
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">CONFIRM PASSWORD</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Re-enter password" required>
                    </div>

                    <!-- Register Button -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-login">REGISTER</button>
                    </div>

                    <!-- Login Link -->
                    <div class="text-center mt-3">
                        <a class="back-link" href="{{ route('login') }}">Already have an account? Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="right-content"></div>
</x-guest-layout>

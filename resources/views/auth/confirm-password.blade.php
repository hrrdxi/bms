<x-guest-layout>
    <div class="left-content">
        <div class="login-form-container">
            <div class="login-form">
                <h1 class="form-title text-center mb-4">CONFIRM PASSWORD</h1>
                
                <p class="text-center mb-4">
                    This is a secure area of the application. Please confirm your password before continuing.
                </p>

                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf

                    <!-- Password -->
                    <div class="mb-4">
                        <label for="password" class="form-label">PASSWORD</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required autofocus>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-login">CONFIRM</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="right-content"></div>
</x-guest-layout>

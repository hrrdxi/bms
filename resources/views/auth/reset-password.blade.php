<x-guest-layout>
    <div class="left-content">
        <div class="login-form-container">
            <div class="login-form">
                <h1 class="form-title text-center mb-4">RESET PASSWORD</h1>
                
                <form method="POST" action="{{ route('password.store') }}">
                    @csrf

                    <!-- Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="form-label">EMAIL</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" value="{{ old('email', $request->email) }}" required autofocus>
                    </div>

                    <!-- New Password -->
                    <div class="mb-4">
                        <label for="password" class="form-label">NEW PASSWORD</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Create a new password" required>
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">CONFIRM PASSWORD</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Re-enter your new password" required>
                    </div>

                    <!-- Reset Button -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-login">RESET PASSWORD</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="right-content"></div>
</x-guest-layout>

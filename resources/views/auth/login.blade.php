<x-guest-layout>
    <div class="left-content">
        <div class="login-form-container">
            <div class="login-form">
                <h1 class="form-title text-center mb-4">LOGIN</h1>
                
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Input -->
                    <div class="mb-4">
                        <label for="email" class="form-label">EMAIL</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="name@gmail.com" required autofocus>
                    </div>

                    <!-- Password Input -->
                    <div class="mb-4">
                        <label for="password" class="form-label">PASSWORD</label>
                        <div class="password-field position-relative">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
                            <button type="button" class="password-toggle">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                                    <line x1="1" y1="1" x2="23" y2="23"></line>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Login Button -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-login">LOGIN</button>
                    </div>

                    <!-- Forgot Password Link -->
                    @if (Route::has('password.request'))
                        <div class="text-center mt-3">
                            <a class="back-link" href="{{ route('password.request') }}">Lupa password?</a>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
    
    <div class="right-content"></div>

    <script>
        document.querySelector('.password-toggle').addEventListener('click', function() {
            const passwordInput = document.querySelector('#password');
            passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
        });
    </script>
</x-guest-layout>

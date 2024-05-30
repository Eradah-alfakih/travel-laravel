<div class="guest-layout">
    <div class="authentication-card">
        <div class="logo">
            <!-- Your logo goes here -->
        </div>

        <div class="validation-errors mb-4">
            <!-- Validation errors here -->
        </div>

        @if (session('status'))
            <div class="status-message mb-4">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="authentication-form">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label">{{ __('Email') }}</label>
                <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
            </div>

            <div class="form-group">
                <label for="password" class="form-label">{{ __('Password') }}</label>
                <input id="password" class="form-input" type="password" name="password" required autocomplete="current-password">
            </div>

            <div class="form-group">
                <label for="remember_me" class="remember-me">
                    <input id="remember_me" class="checkbox" type="checkbox" name="remember">
                    <span class="text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="forgot-password">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-gray-600 hover:text-gray-900">{{ __('Forgot your password?') }}</a>
                @endif
            </div>

            <div class="login-button">
                <button type="submit" class="btn">{{ __('Log in') }}</button>
            </div>
        </form>
    </div>
</div>
<style>
    .guest-layout {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.authentication-card {
    background-color: #fff;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.logo {
    /* Styles for logo */
}

.validation-errors {
    /* Styles for validation errors */
}

.status-message {
    /* Styles for status message */
}

.authentication-form {
    /* Styles for authentication form */
}

.form-group {
    margin-bottom: 20px;
}

.form-label {
    font-size: 16px;
    margin-bottom: 5px;
}

.form-input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.remember-me {
    display: flex;
    align-items: center;
}

.checkbox {
    margin-right: 5px;
}

.forgot-password {
    margin-top: 10px;
}

.login-button {
    margin-top: 20px;
}

.btn {
    background-color: #007bff;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn:hover {
    background-color: #0056b3;
}

    </style>
<div class="guest-layout">
    <div class="authentication-card">
        <div class="logo">
            <!-- Your logo goes here -->
        </div>

        <div class="validation-errors mb-4">
            <!-- Validation errors here -->
        </div>

        <form method="POST" action="{{ route('register') }}" class="authentication-form">
            @csrf

            <div class="form-group">
                <label for="name" class="form-label">{{ __('Name') }}</label>
                <input id="name" class="form-input" type="text" name="name" :value="old('name')" required autofocus autocomplete="name">
            </div>

            <div class="form-group">
                <label for="email" class="form-label">{{ __('Email') }}</label>
                <input id="email" class="form-input" type="email" name="email" :value="old('email')" required autocomplete="username">
            </div>

            <div class="form-group">
                <label for="password" class="form-label">{{ __('Password') }}</label>
                <input id="password" class="form-input" type="password" name="password" required autocomplete="new-password">
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                <input id="password_confirmation" class="form-input" type="password" name="password_confirmation" required autocomplete="new-password">
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="form-group">
                    <label for="terms" class="terms">
                        <input id="terms" class="checkbox" type="checkbox" name="terms" required>
                        <span class="terms-text">
                            {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="terms-link">'.__('Terms of Service').'</a>',
                                'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="terms-link">'.__('Privacy Policy').'</a>',
                            ]) !!}
                        </span>
                    </label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a href="{{ route('login') }}" class="already-registered">{{ __('Already registered?') }}</a>

                <button type="submit" class="btn">{{ __('Register') }}</button>
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

.terms {
    display: flex;
    align-items: center;
}

.checkbox {
    margin-right: 5px;
}

.terms-text {
    font-size: 14px;
    color: #555;
}

.terms-link {
    text-decoration: underline;
    color: #007bff;
}

.already-registered {
    margin-right: 10px;
    font-size: 14px;
    color: #555;
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
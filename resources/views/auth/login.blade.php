{{--<x-guest-layout>--}}
{{--    <x-jet-authentication-card>--}}
{{--        <x-slot name="logo">--}}
{{--            <x-jet-authentication-card-logo />--}}
{{--        </x-slot>--}}

{{--        <x-jet-validation-errors class="mb-4" />--}}

{{--        @if (session('status'))--}}
{{--            <div class="mb-4 font-medium text-sm text-green-600">--}}
{{--                {{ session('status') }}--}}
{{--            </div>--}}
{{--        @endif--}}

{{--        <form method="POST" action="{{ route('login') }}">--}}
{{--            @csrf--}}

{{--            <div>--}}
{{--                <x-jet-label for="email" value="{{ __('Email') }}" />--}}
{{--                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />--}}
{{--            </div>--}}

{{--            <div class="mt-4">--}}
{{--                <x-jet-label for="password" value="{{ __('Password') }}" />--}}
{{--                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />--}}
{{--            </div>--}}

{{--            <div class="block mt-4">--}}
{{--                <label for="remember_me" class="flex items-center">--}}
{{--                    <x-jet-checkbox id="remember_me" name="remember" />--}}
{{--                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>--}}
{{--                </label>--}}
{{--            </div>--}}

{{--            <div class="flex items-center justify-end mt-4">--}}
{{--                @if (Route::has('password.request'))--}}
{{--                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">--}}
{{--                        {{ __('Forgot your password?') }}--}}
{{--                    </a>--}}
{{--                @endif--}}

{{--                <x-jet-button class="ml-4">--}}
{{--                    {{ __('Log in') }}--}}
{{--                </x-jet-button>--}}
{{--            </div>--}}
{{--        </form>--}}
{{--    </x-jet-authentication-card>--}}
{{--</x-guest-layout>--}}
<x-guest-layout>
    <!doctype html>
    <html lang="en">
    <head>
        <title>Login 05</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&amp;display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../../../../stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <!--<link rel="stylesheet" href="https://preview.colorlib.com/theme/bootstrap/login-form-15/css/style.css">-->
{{--        <link rel="stylesheet" href="{{ asset('assets/login-page-assets/css/login-page-style.css') }}">--}}
        <link rel="stylesheet" href="{{ asset('public/assets/login-page-assets/css/login-page-style.css') }}">
    </head>
    <body>
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center mb-5">
                    {{--                <h2 class="heading-section">Login #05</h2>--}}
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-7 col-lg-5">
                    <div class="wrap">
                        {{--                    <div class="img" style="background-image: url(https://preview.colorlib.com/theme/bootstrap/login-form-15/images/bg-1.jpg);"></div>--}}
                        <div class="img" style="background-image: url(https://www.peta.org/wp-content/uploads/2019/08/iStock-1160758684_NONTANUN-CHAIPRAKON-1-602x301.jpg);"></div>
                        <div class="login-wrap p-4 p-md-5">
                            <div class="d-flex">
                                <div class="w-100">
                                    <h3 class="mb-4">Sign In</h3>
                                </div>
                            </div>

                            <x-jet-validation-errors class="mb-4" />
                            @if (session('status'))
                                <div class="mb-4 font-medium text-sm text-green-600">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('login') }}" class="signin-form">
                                @csrf
                                <div class="form-group mt-3">
                                    <input id="email" type="email" name="email" class="form-control" :value="old('email')" required>
                                    <label class="form-control-placeholder" for="email">Email</label>
                                </div>
                                <div class="form-group">
                                    <input id="password-field" type="password" name="password" class="form-control" required autocomplete="current-password">
                                    <label class="form-control-placeholder" for="password">Password</label>
                                    <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="form-control btn btn-primary rounded submit px-3">Sign In</button>
                                </div>
                            </form>
                            <p class="text-center">Not a member? <a data-toggle="tab" style="color: red;" href="#signup">Sign Up</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{--    <script src="https://preview.colorlib.com/theme/bootstrap/login-form-15/js/jquery.min.js"></script>--}}
    {{--    <script src="https://preview.colorlib.com/theme/bootstrap/login-form-15/js/popper.js"></script>--}}
    {{--    <script src="https://preview.colorlib.com/theme/bootstrap/login-form-15/js/bootstrap.min.js"></script>--}}
    {{--    <script src="https://preview.colorlib.com/theme/bootstrap/login-form-15/js/main.js"></script>--}}
    </body>

    </html>
</x-guest-layout>

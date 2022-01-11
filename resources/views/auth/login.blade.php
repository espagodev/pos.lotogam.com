<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Meta -->
    <meta name="description" content="Responsive Bootstrap4 Dashboard Template">
    <meta name="author" content="ParkerThemes">
    <link rel="shortcut icon" href="{{ asset('img/fav.png') }}" />

    <!-- Title -->
    <title>Lotogam Pos - Login</title>

    <!-- *************
   ************ Common Css Files *************
  ************ -->

    <!-- Bootstrap css -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <!-- Main css -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">

</head>

    <body class="authentication">

        <!-- Container start -->
		<div class="container">
			
            <form method="POST" action="{{ route('login') }}">
                @csrf
				<div class="row justify-content-md-center">
					<div class="col-xl-4 col-lg-5 col-md-6 col-sm-12">
						<div class="login-screen">
							<div class="login-box">
								<a href="#" class="login-logo">
									<img src="{{ asset('img/logo.png') }}" alt="Pos Lotogam" />
								</a>
								<h5>Bienvenido de nuevo,<br />Inicie sesión en su cuenta    .</h5>
								<div class="form-group">
									<input  type="text" id="email" class="form-control" placeholder="{{ __('E-Mail Address') }}" name="email"
                                    value="{{ old('email') }}" required autocomplete="email" autofocus/>
								</div>
								<div class="form-group">
									<input type="password" id="password" class="form-control" placeholder="{{ __('Password') }}"  name="password"
                                    required autocomplete="current-password" />
								</div>
								<div class="actions mb-4">
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
										<label class="custom-control-label" for="remember">{{ __('Remember Me') }}</label>
									</div>
									<button type="submit" class="btn btn-primary"> {{ __('Login') }}</button>
								</div>
								
							</div>
						</div>
					</div>
				</div>
			</form>

		</div>
		<!-- Container end -->

    </body>

</html>

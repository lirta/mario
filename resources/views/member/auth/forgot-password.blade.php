<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="{{asset('assets/')}}/images/favicon-32x32.png" type="image/png" />
	<!-- loader-->
	<link href="{{asset('assets/')}}/css/pace.min.css" rel="stylesheet" />
	<script src="{{asset('assets/')}}/js/pace.min.js"></script>
	<!-- Bootstrap CSS -->
	<link href="{{asset('assets/')}}/css/bootstrap.min.css" rel="stylesheet">
	<link href="{{asset('assets/')}}/css/bootstrap-extended.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
	<link href="{{asset('assets/')}}/css/app.css" rel="stylesheet">
	<link href="{{asset('assets/')}}/css/icons.css" rel="stylesheet">
	<title>{{$titlePage}}</title>
</head>

<body>
	<!-- wrapper -->
	<div class="wrapper">
		<div class="authentication-header"></div>
		<div class="authentication-forgot d-flex align-items-center justify-content-center">
			<div class="card forgot-box">
				<div class="card-body">
					<div class="p-4 rounded">
						<div class="text-center">
							<img src="{{asset('assets/')}}/images/icons/lock.png" width="120" alt="" />
						</div>
						<h4 class="mt-5 font-weight-bold">Forgot Password?</h4>
						<p class="text-muted">Enter your registered email to reset the password</p>
						@include('alert.alert')
						<div class="form-body">
							<form class="row g-3" action="{{ route('member.forgot_password') }}" enctype="multipart/form-data" method="POST">
								@csrf
								<div class="my-4">
									<label class="form-label">Email</label>
									<input type="text" class="form-control form-control-lg" name="email" placeholder="example@user.com" />
								</div>
								<div class="d-grid gap-2">
									<button type="submit" class="btn btn-primary btn-lg">Send</button> <a href="{{ route('member_login') }}" class="btn btn-white btn-lg"><i class='bx bx-arrow-back me-1'></i>Back to Login</a>
								</div>
							</form>
						</div>
						{{-- <div class="my-4">
							<label class="form-label">Email</label>
							<input type="text" class="form-control form-control-lg" name="email" placeholder="example@user.com" />
						</div>
						<div class="d-grid gap-2">
							<button type="button" class="btn btn-primary btn-lg">Send</button> <a href="{{ route('member_login') }}" class="btn btn-white btn-lg"><i class='bx bx-arrow-back me-1'></i>Back to Login</a>
						</div> --}}
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end wrapper -->
</body>

</html>
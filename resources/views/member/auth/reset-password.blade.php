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
	<title>Synadmin – Bootstrap5 Admin Template</title>
</head>

<body>
	<!-- wrapper -->
	<div class="wrapper">
		<div class="authentication-header"></div>
		 <div class="authentication-reset-password d-flex align-items-center justify-content-center">
			<div class="row">
				<div class="col-12 col-lg-10 mx-auto">
					<div class="card">
						<div class="row g-0">
							<div class="col-lg-5 border-end">
								<div class="card-body">
									<div class="p-5">
										<div class="text-start">
											<img src="{{asset('assets/')}}/images/logo-img.png" width="180" alt="">
										</div>
										<h4 class="mt-5 font-weight-bold">Genrate New Password</h4>
										<p class="text-muted">We received your reset password request. Please enter your new password!</p>
										@if(Session('success'))
											<div class="alert alert-warning border-0 bg-warning alert-dismissible fade show py-2">
												<div class="d-flex align-items-center">
													<div class="font-35 text-white"><i class='bx bx-info-circle'></i>
													</div>
													<div class="ms-3">
														<h6 class="mb-0 text-white">{{Session('success')}}</h6>
														<div class="text-white">{{Session('success')}}</div>
													</div>
												</div>
												<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
											</div>

										@endif
                                        @if (Session('error'))
											<div class="alert border-0 border-start border-5 border-danger alert-dismissible fade show py-2">
												<div class="d-flex align-items-center">
													<div class="font-35 text-danger"><i class='bx bxs-message-square-x'></i>
													</div>
													<div class="ms-3">
														<h6 class="mb-0 text-danger">Danger Alerts</h6>
														<div>{{ session('error') }}</div>
													</div>
												</div>
												<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
											</div>
                                        @endif
										<form action="{{route('member.reset_password_post')}}" enctype="multipart/form-data" method="POST">
										@csrf
										<input type="hidden" name="token" value="{{ $token }}">
											<div class="mb-3 mt-5">
												<label class="form-label">Email</label>
												<input type="text" class="form-control" name="email" placeholder="Enter new password" />
											</div>
											<div class="mb-3">
												<label class="form-label">New Password</label>
												<input type="password" class="form-control" name="password" placeholder="Enter new password" />
											</div>
											<div class="mb-3">
												<label class="form-label">Confirm Password</label>
												<input type="password" class="form-control" name="password_confirmation" placeholder="Confirm password" />
											</div>
											<div class="d-grid gap-2">
												<button type="submit" class="btn btn-primary">Change Password</button> <a href="{{ route('member_login') }}" class="btn btn-light"><i class='bx bx-arrow-back mr-1'></i>Back to Login</a>
											</div>
										</form>
									</div>
								</div>
							</div>
							<div class="col-lg-7">
								<img src="{{asset('assets/')}}/images/login-images/forgot-password-frent-img.jpg" class="card-img login-img h-100" alt="...">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end wrapper -->
</body>

</html>
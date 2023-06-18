<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	{{-- <link rel="icon" href="{{asset('assets/')}}/images/favicon-32x32.png" type="image/png" /> --}}
    <link rel="icon" href="{{ asset('assets/images/logo/'.@$settings->favicon)}}" type="image/png" />
	<!--plugins-->
	<link href="{{asset('assets/')}}/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
	<link href="{{asset('assets/')}}/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
	<link href="{{asset('assets/')}}/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
	<!-- loader-->
	<link href="{{asset('assets/')}}/css/pace.min.css" rel="stylesheet" />
	<script src="{{asset('assets/')}}/js/pace.min.js"></script>
	<!-- Bootstrap CSS -->
	<link href="{{asset('assets/')}}/css/bootstrap.min.css" rel="stylesheet">
	<link href="{{asset('assets/')}}/css/bootstrap-extended.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
	<link href="{{asset('assets/')}}/css/app.css" rel="stylesheet">
	<link href="{{asset('assets/')}}/css/icons.css" rel="stylesheet">
	<title>HoneyGold - Register Member</title>
</head>

<body>
	<!--wrapper-->
	<div class="wrapper">
		<div class="authentication-header"></div>
		<header class="login-header shadow">
			<nav class="navbar navbar-expand-lg navbar-light bg-white rounded fixed-top rounded-0 shadow-sm">
				<div class="container-fluid">
					<div>
                        @if (@$settings->logo)
                            <img src="{{ asset('assets/images/logo/'.$settings->logo) }}" class="logo-icon" alt="logo icon">

                        @else
                            <img src="{{ asset('assets/images/logo-icon.png')}}" class="logo-icon" alt="logo icon">

                        @endif
                    </div>
                    <div>
                        <h4 class="logo-text">{{@$titlePage}}</h4>
                    </div>

					<div class="user-box dropdown border-light-2">

						</ul>
					</div>
				</div>
			</nav>
		</header>

		<div class="d-flex align-items-center justify-content-center my-4">
			<div class="container">
				<div class="row row-cols-1 row-cols-lg-2 row-cols-xl-1">
					<div class="col mx-auto">
						<div class="card mt-5">
							<div class="card-body">
                                   @include('alert.alert')
								   
                                <form action="{{ route('member.register') }}" enctype="multipart/form-data" method="post">
                                    @csrf

								<div class="border p-4 rounded">
									<div class="text-center">
										<h3 class="">{{ __('Sign Up') }}</h3>
										<p>{{ __('Already have an account') }}? <a href="{{ route('member_login') }}">{{ __('Sign in here') }}</a>
										</p>
									</div>
                                    <hr/>

									<div class="card-title d-flex align-items-center">
                                        <div><i class="bx bxs-user me-1 font-22 text-info"></i>
                                        </div>
                                        <h5 class="mb-0 text-info">{{ __('User Registration') }}</h5>
                                    </div>
                                    <div class="login-separater text-center mb-4"> <span>User Profile</span>
										<hr/>
									</div>

                                    <div class="row mb-3">
                                        <label for="inputEnterYourName" class="col-sm-3 col-form-label">@lang('Enter Your Name')</label>
                                        <div class="col-sm-9">
                                            <input onchange="myChangeFunctionName(this)" type="text" class="form-control @error('fullname') is-invalid @enderror" id="inputEnterYourName" name="fullname" placeholder="Enter Your Name" value="{{old('fullname')}}" required>
											@error('fullname')
												<div class="invalid-feedback">
													{{$message}}
												</div>
											@enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputPhoneNo2" class="col-sm-3 col-form-label">@lang('Phone No')</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="inputPhoneNo2" name="phone" value="{{old('phone')}}" placeholder="08137885899">
											@error('phone')
												<div class="invalid-feedback">
													{{$message}}
												</div>
											@enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputEmailAddress2" class="col-sm-3 col-form-label">@lang('Email')</label>
                                        <div class="col-sm-9">
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="inputEmailAddress2" name="email" placeholder="Email Address" value="{{old('email')}}">
											@error('email')
												<div class="invalid-feedback">
													{{$message}}
												</div>
											@enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputChoosePassword2" class="col-sm-3 col-form-label">@lang('Choose Password')</label>
                                        <div class="col-sm-9">
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="inputChoosePassword2" name="password" placeholder="Choose Password" >
											@error('password')
												<div class="invalid-feedback">
													{{$message}}
												</div>
											@enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="password_confirmation" class="col-sm-3 col-form-label">@lang('Confirm Password')</label>
                                        <div class="col-sm-9">
                                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" >
											@error('password_confirmation')
												<div class="invalid-feedback">
													{{$message}}
												</div>
											@enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputAddress4" class="col-sm-3 col-form-label">@lang('Address')</label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control @error('address') is-invalid @enderror" id="inputAddress4" rows="3" name="address" placeholder="Address">{{old('address')}}</textarea>
											@error('address')
												<div class="invalid-feedback">
													{{$message}}
												</div>
											@enderror
                                        </div>
                                    </div>
                                    {{-- <div class="row mb-3">
                                        <label for="inputAddress4" class="col-sm-3 col-form-label"></label>
                                        <div class="col-sm-9">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="gridCheck4" required>
                                                <label class="form-check-label" for="gridCheck4"><a data-bs-toggle="modal" data-bs-target="#targetModal" >Agree with term & condition</a></label>

													<div class="modal fade" id="targetModal" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-scrollable">
                                                        <div class="modal-content modal-lg">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">@lang('Teram & Condition')</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                                <div class="modal-body">
                                                                    <div class="form-group">

                                                                        @include('member.auth.termcondition')

                                                                    </div>
                                                                </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button id="agree" type="button" class="btn btn-danger" data-bs-dismiss="modal">Agree</button>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="row">
                                        <label class="col-sm-3 col-form-label"></label>
                                        <div class="col-sm-9">
                                            <button type="submit" class="btn btn-info px-5">@lang('Register')</button>
                                        </div>
                                    </div>
								</div>
                            </form>
							</div>
						</div>
					</div>
				</div>
				<!--end row-->
			</div>
		</div>
		<footer class="bg-white shadow-sm border-top p-2 text-center fixed-bottom">
			<p class="mb-0">Copyright © 2023. All right reserved.</p>
		</footer>
	</div>
	<!--end wrapper-->
	<!-- Bootstrap JS -->
	<script src="{{asset('assets/')}}/js/bootstrap.bundle.min.js"></script>
	<!--plugins-->
	<script src="{{asset('assets/')}}/js/jquery.min.js"></script>
	<script src="{{asset('assets/')}}/plugins/simplebar/js/simplebar.min.js"></script>
	<script src="{{asset('assets/')}}/plugins/metismenu/js/metisMenu.min.js"></script>
	<script src="{{asset('assets/')}}/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
	<!--Password show & hide js -->
	<script>
		$(document).ready(function () {
			$("#show_hide_password a").on('click', function (event) {
				event.preventDefault();
				if ($('#show_hide_password input').attr("type") == "text") {
					$('#show_hide_password input').attr('type', 'password');
					$('#show_hide_password i').addClass("bx-hide");
					$('#show_hide_password i').removeClass("bx-show");
				} else if ($('#show_hide_password input').attr("type") == "password") {
					$('#show_hide_password input').attr('type', 'text');
					$('#show_hide_password i').removeClass("bx-hide");
					$('#show_hide_password i').addClass("bx-show");
				}
			});
		});
	</script>
    <script type="text/javascript">
        function myChangeFunctionName(inputname) {
          var accountbank = document.getElementById('account_name');
          accountbank.value = inputname.value;
        }
      </script>
	<!--app JS-->
	<script src="{{asset('assets/js/app.js')}}"></script>
    <script>
        document.getElementById('warning_referral').style.display = 'none';
        document.getElementById('referral_data').style.display = 'none';
         function myChangeFunction() {
            var input1 = document.getElementById('referral_email').value;
            var input2 = document.getElementById('referral').value;
            // var title = $("input[name=title]").val();
            // var details = $("input[name=details]").val();
            //alert (input2);
            $.ajax({
                // method:"POST",
                url: "{{ route('member.checkReferral') }}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    "type":"POST",
                    "referral":input2,
                    "_token": "{{ csrf_token() }}",
            },
                success: function(response){
                    $(".result").html(response);
                }
            });
            }

            var input1 = document.getElementById('referral_email').value;
            var input2 = document.getElementById('referral').value;
            // var title = $("input[name=title]").val();
            // var details = $("input[name=details]").val();
            //alert (input2);
            if($('#referral').val().length > 0) {
                $.ajax({
                // method:"POST",
                url: "{{ route('member.checkReferral') }}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    "type":"POST",
                    "referral":input2,
                    "_token": "{{ csrf_token() }}",
                },
                    success: function(response){
                        $(".result").html(response);
                    }
                });
            }

            var toggle = false;
            $("#agree").click(function() {
                    $("input[type=checkbox]").attr("checked",!toggle);
                    toggle = !toggle;
            });

    </script>
<script>
    $("html").attr("class","color-sidebar sidebarcolor6");
</script>
</body>

</html>

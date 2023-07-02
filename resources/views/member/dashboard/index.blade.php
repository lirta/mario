@extends('layouts.member.app')
@section('wrapper')

<div class="page-wrapper">
    <div class="page-wrapper">
                <div class="page-content">
                    <!--breadcrumb-->
                    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                        <div class="breadcrumb-title pe-3">User Profile</div>
                        <div class="ps-3">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0 p-0">
                                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">User Profilep</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="ms-auto">
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary">Settings</button>
                                <button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">	<span class="visually-hidden">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">	<a class="dropdown-item" href="javascript:;">Action</a>
                                    <a class="dropdown-item" href="javascript:;">Another action</a>
                                    <a class="dropdown-item" href="javascript:;">Something else here</a>
                                    <div class="dropdown-divider"></div>	<a class="dropdown-item" href="javascript:;">Separated link</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end breadcrumb-->
                    <div class="container">
                        <div class="main-body">
							@include('alert.alert')
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex flex-column align-items-center text-center">
                                                {{-- <img src="assets/images/user.png" alt="Admin" class="rounded-circle p-1 bg-primary" width="110"> --}}
                                                <div class="mt-3">
                                                    <h4>{{$user->fullname}}</h4>
                                                    <p class="text-secondary mb-1">{{$user->member_id}}</p>
                                                    <p class="text-muted font-size-sm">{{$user->email}}</p>
                                                    <p class="text-muted font-size-sm">{{$user->mobile_code.$user->mobile}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="card">
                                       <form action="{{ route('member.edit.profile') }}" enctype="multipart/form-data" method="post">
										@csrf
										<input type="hidden" name="member_id" value="{{$user->member_id}}">
											 <div class="card-body">
												<div class="row mb-3">
													<label for="inputEnterYourName" class="col-sm-3 col-form-label">@lang('Enter Your Name')</label>
													<div class="col-sm-9">
														<input onchange="myChangeFunctionName(this)" type="text" class="form-control @error('fullname') is-invalid @enderror" id="inputEnterYourName" name="fullname" value="{{$user->fullname}}" required>
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
														<input type="text" class="form-control @error('phone') is-invalid @enderror" id="inputPhoneNo2" name="phone" value="{{"0".$user->mobile}}" >
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
														<input type="email" class="form-control @error('email') is-invalid @enderror" id="inputEmailAddress2" name="email" value="{{$user->email}}">
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
												<div class="row">
													<div class="col-sm-3"></div>
													<div class="col-sm-9 text-secondary">
														<input type="submit" class="btn btn-primary px-4" value="Save Changes" />
													</div>
												</div>
											</div>
									   </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection
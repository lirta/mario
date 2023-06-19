@extends('layouts.member.app')

@section("style")
	<link href="{{asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet" />
	<link href="{{asset('assets/plugins/select2/css/select2-bootstrap4.css')}}" rel="stylesheet" />
@endsection

@section("wrapper")
	<div class="page-wrapper">
		<div class="page-content">
			<!--breadcrumb-->
			<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
				<div class="breadcrumb-title pe-3">Antrian</div>
				<div class="ps-3">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb mb-0 p-0">
							<li class="breadcrumb-item"><a href="{{ route('member.antrian')}}"><i class="bx bx-home-alt"></i></a>
							</li>
							<li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
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
					<div class="row">
						<div class="col-lg-12">
							{{-- added alert message --}}
							@include('alert.alert')

							<div class="card">
							<form  action="{{ route('member.antrian.store')}}" method="POST" enctype="multipart/form-data">
							{{-- {{ csrf_field() }} --}}
							@csrf

								<div class="card-body">

									<div class="row mb-3">
										<div class="col-sm-3">
											<h6 class="mb-0" for="service">Jenis Layanan</h6>
										</div>
										<div class="col-sm-9 ">
											<div class="mb-3">
												<select class="single-select" name="service">
													<option value="0">Select Layanan</option>
													@forelse($layanan as $item)
														<option value="{{$item->id}}" >{{$item->layanan}}</option>
													@empty
														<option value="0">No Data Found</option>
													@endforelse
												</select>
											</div>
										</div>
									</div>

									<a href="{{ route('member.antrian')}}" class="btn btn-secondary px-4"><i class="fadeIn animated bx bx-arrow-to-left"></i> Back</a>
									<button type="submit" class="btn btn-primary px-4">Create</button>
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

@push('breadcrumb-plugins')
    <a href="{{ route('member.antrian') }}" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="la la-fw la-backward"></i>Go Back</a>
@endpush
@section("script")
	<script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>
	<script>
		$('.single-select').select2({
			theme: 'bootstrap4',
			width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
			placeholder: $(this).data('placeholder'),
			allowClear: Boolean($(this).data('allow-clear')),
		});
		$('.multiple-select').select2({
			theme: 'bootstrap4',
			width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
			placeholder: $(this).data('placeholder'),
			allowClear: Boolean($(this).data('allow-clear')),
		});
	</script>
	@endsection
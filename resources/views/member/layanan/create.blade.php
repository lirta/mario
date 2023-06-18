@extends('layouts.admin.app')


@section('wrapper')
	<div class="page-wrapper">
		<div class="page-content">
			<!--breadcrumb-->
			<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
				<div class="breadcrumb-title pe-3">Member Profile</div>
				<div class="ps-3">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb mb-0 p-0">
							<li class="breadcrumb-item"><a href="{{route('layanan.index')}}"><i class="bx bx-home-alt"></i></a>
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
								{{-- alert --}}
							<div class="card">
							<form action="{{route('layanan.store')}}" method="POST" enctype="multipart/form-data">
							@csrf
							@method("POST")
								<div class="card-body">
									<div class="row mb-3">
										<div class="col-sm-3">
											<h6 class="mb-0" for="layanan">@lang('Layanan') <span class="text-danger">*</span></h6>
										</div>
										<div class="col-sm-9 text-secondary">
											<input type="text" id="layanan" class="form-control @error('layanan') is-invalid @enderror"  name="layanan" value="{{old('layanan')}}" placeholder="@lang('Name Layanan')"/>
											@error('layanan')
												<div class="invalid-feedback">
													{{$message}}
												</div>
											@enderror
										</div>
									</div>
									<div class="row mb-3">
										<div class="col-sm-3">
											<h6 class="mb-0" for="waktu">@lang('Waktu (Menit)') <span class="text-danger">*</span></h6>
										</div>
										<div class="col-sm-9 text-secondary">
											<input type="number" id="waktu" class="form-control @error('waktu') is-invalid @enderror"  name="waktu" value="{{old('waktu')}}" placeholder="@lang('ex: 60')"/>
											@error('waktu')
												<div class="invalid-feedback">
													{{$message}}
												</div>
											@enderror
										</div>
									</div>
									<div class="row mb-3">
										<div class="col-sm-3">
											<h6 class="mb-0" for="des">@lang('Description') <span class="text-danger">*</span></h6>
										</div>
										<div class="col-sm-9 text-secondary">
											<textarea name="des" id="des"  class="form-control @error('des') is-invalid @enderror"  cols="30" rows="3" placeholder="Description">{{old('des')}}</textarea>
										</div>
									</div>
									
									<div class="row">
										<div class="col-sm-3"></div>
										<div class="col-sm-9 text-secondary">
											<a href="{{ route('layanan.index')}}" class="btn btn-secondary px-4"><i class="fadeIn animated bx bx-arrow-to-left"></i> Back</a>
											<button type="submit" class="btn btn-primary px-4">Create Layanan</button>
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
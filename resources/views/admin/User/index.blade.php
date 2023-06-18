@extends("layouts.app")

		@section("wrapper")
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Dashboard</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Data pengunjung Wendys SG</li>
							</ol>
						</nav>
					</div>
				</div>
				<!--end breadcrumb-->
				{{-- @include('include.alert') --}}
				<div class="row">
					<div class="col-xl-12 mx-auto mt-2">
						<div class="card">
							<div class="card-header">
								Data Locasi
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table class="table table-bordered mb-0 table-hover">
										<thead>
											<tr>
												<th>@lang('Date')</th>
												<th>@lang('IP')</th>
												<th>@lang('Country Name')</th>
												<th>@lang('Country Code')</th>
												<th>@lang('Region Code')</th>
												<th>@lang('Region Name')</th>
												<th>@lang('City')</th>
												<th>@lang('Latitude')</th>
												<th>@lang('Longitude')</th>
											</tr>
										</thead>
										<tbody>
											@forelse ($user as $item)
												<tr>
													<td>{{ showDateTime($item->created_at) }} <br> {{ diffForHumans($item->created_at) }}</td>
													<td>{{$item->ip_address}}</td>
													<td>{{$item->countryName}}</td>
													<td>{{$item->countryCode}}</td>
													<td>{{$item->regionCode}}</td>
													<td>{{$item->regionName}}</td>
													<td>{{$item->cityName}}</td>
													<td>{{$item->zipCode}}</td>
													<td>{{$item->latitude}}</td>
													<td>{{$item->longitude}}</td>
												</tr>
											@empty
												<td class="text-muted text-center" colspan="100%">Tidak ada data</td>
											@endforelse
										</tbody>
									</table>
								</div>
							</div>
							<div class="card-footer py-4">
								{{-- {!! $orders->links() !!} --}}
							</div>
						</div>
						<div class="card">
							<div class="card-header">
								Data Locasi
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table class="table table-bordered mb-0 table-hover">
										<thead>
											<tr>
												<th>@lang('IP')</th>
												<th>@lang('Device')</th>
												<th>@lang('isDesktop')</th>
												<th>@lang('isPhone')</th>
												<th>@lang('isTaplet')</th>
												<th>@lang('Browser')</th>
												<th>@lang('Browser V')</th>
												<th>@lang('Platform')</th>
												<th>@lang('Platform V')</th>
												<th>@lang('isRobot')</th>
												<th>@lang('lang')</th>
											</tr>
										</thead>
										<tbody>
											@forelse ($device as $dev)
												<tr>
													<td>{{$dev->ip->ip_address}}</td>
													<td>{{$dev->device}}</td>
													<td>{{$dev->isDesktop}}</td>
													<td>{{$dev->isPhone}}</td>
													<td>{{$dev->isTablet}}</td>
													<td>{{$dev->browser}}</td>
													<td>{{$dev->browser_v}}</td>
													<td>{{$dev->platform}}</td>
													<td>{{$dev->platform_v}}</td>
													<td>{{$dev->isRobot}}</td>
													<td>{{$dev->lang}}</td>
												</tr>
											@empty
												<td class="text-muted text-center" colspan="100%">Tidak ada data</td>
											@endforelse
										</tbody>
									</table>
								</div>
							</div>
							<div class="card-footer py-4">
								{{-- {!! $orders->links() !!} --}}
							</div>
						</div>
					</div>
				</div>
				<!--end row-->
			</div>
		</div>
<!--end page wrapper -->
@endsection


@push('script')
<script>
    'use strict';
    $('.delete').on('click', function () {
        var modal = $('#deleteStaff');
        modal.find('input[name=id]').val($(this).data('id'))
        modal.modal('show');
    });
</script>
@endpush


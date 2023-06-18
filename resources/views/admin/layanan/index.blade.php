@extends('layouts.admin.app')


@section('wrapper')
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
								<li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
							</ol>
						</nav>
					</div>
				</div>
				<div class="col-sm-9 text-secondary">
						<a href="{{route('layanan.create')}}" class="btn btn-sm btn-outline-primary mr-2" data-toggle="tooltip" title="" data-original-title="@lang('create')">
							Create Layanan
						</a>
                </div>
				<!--end breadcrumb-->
				
				<div class="row">
					
					<div class="col-xl-12 mx-auto mt-3">
						<div class="card">
							<div class="card-body">
								{{-- alert --}}
								@include('alert.alert')

								<table class="table table-bordered mb-0 table-hover">
									<thead>
										<tr>
										<th>@lang('Layanan')</th>
										<th>@lang('Perkiraan Waktu')</th>
										<th>@lang('Description')</th>
										<th>@lang('Action')</th>
										</tr>
									</thead>
									<tbody>
										@forelse ($layanan as $item)
											<tr>
												<td>{{$item->layanan}}</td>
												<td>{{$item->perkiraan_waktu}} Menit</td>
												<td>{{$item->description}}</td>
												<td data-label="@lang('Action')">
													<a href="{{route('layanan.edit', $item->id)}}" class="btn btn-sm btn-warning mr-2" data-toggle="tooltip" title="" data-original-title="@lang('Edit')">
														@lang('Edit')
													</a>
													<a href="{{route('layanan.delete', $item->id)}}" onclick="return confirm('Are you sure to delete this layanan?')" class="btn btn-sm btn-danger delete" data-toggle="tooltip" title="" data-original-title="@lang('Delete')">
														@lang('Delete')
													</a>
												</td>
											</tr>
										@empty
											<tr>
												<td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
											</tr>
										@endforelse
									</tbody>
								</table>
								{!! $layanan->links() !!}
							</div>
						</div>
						{{-- <div class="card-footer py-4">
							{{ paginateLinks($features) }}
						</div> --}}

					</div>
				</div>
				<!--end row-->
			</div>
		</div>
@endsection
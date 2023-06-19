@extends('layouts.member.app')


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
						<a href="{{route('member.antrian.create')}}" class="btn btn-sm btn-outline-primary mr-2" data-toggle="tooltip" title="" data-original-title="@lang('create')">
							Create Antrian
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
										<th>@lang('No Antrian')</th>
										<th>@lang('Layanan')</th>
										<th>@lang('Perkiraan Waktu')</th>
										<th>@lang('Description')</th>
										<th>@lang('Status')</th>
										</tr>
									</thead>
									<tbody>
										@forelse ($antrian as $item)
											<tr>
												<td>
													@if ($item->member_id == Auth::user()->member_id)
														<span class="badge text-primary bg-light-primary p-2 px-3 ps">{{$item->no_antrian}}</span>
													@else
														{{$item->no_antrian}}
													@endif
												</td>
												<td>{{$item->service->layanan}}</td>
												<td>{{$item->service->perkiraan_waktu}} Menit</td>
												<td>{{$item->service->description}}</td>
												<td>
													@if ($item->status == 0)
														<span class="badge text-warning bg-light-warning p-2 px-3 ps">Waiting List</span>
													@elseif($item->status == 1)
														<span class="badge text-primary bg-light-primary p-2 px-3 ps">In Progres</span>
													@elseif($item->status == 2)
														<span class="badge text-success bg-light-success p-2 px-3 ps">Finish</span>
													@elseif($item->status == 3)
														<span class="badge text-danger bg-light-danger p-2 px-3 ps">Cancel</span>
													@endif
												</td>
											</tr>
										@empty
											<tr>
												<td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
											</tr>
										@endforelse
									</tbody>
								</table>
								{!! $antrian->links() !!}
							</div>
						</div>

					</div>
				</div>
				<!--end row-->
			</div>
		</div>
@endsection
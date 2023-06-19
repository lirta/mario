@extends('layouts.admin.app')

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
								<li class="breadcrumb-item active" aria-current="page">Staff Table</li>
							</ol>
						</nav>
					</div>
				</div>
				<div class="col-sm-9 text-secondary">
					{{-- @can('staff-create')
						<a href="{{route('staff.create')}}" class="btn btn-sm btn-outline-primary mr-2" data-toggle="tooltip" title="" data-original-title="@lang('Edit')">
							New Staff
						</a>
					@endcan --}}
                </div>
				<!--end breadcrumb-->
				<div class="row">
					<div class="col-xl-12 mx-auto mt-3">
						<div class="card">
							<div class="card-body">
								@include('alert.alert')
								<table class="table table-bordered mb-0 table-hover">
									<thead>
										<tr>
										<th>@lang('Name')</th>
										<th>@lang('Email')</th>
										<th>@lang('Password')</th>
										<th>@lang('Joined At')</th>
										<th>@lang('Action')</th>
										</tr>
									</thead>
									<tbody>
									@forelse($staffs as $staff)
										<tr>
											<td data-label="@lang('Name')">
												<span class="font-weight-bold">{{$staff->fullname}}</span>
											</td>

											<td data-label="@lang('Email')">
												<span class="font-weight-bold">{{$staff->email}}</span>
											</td>

											<td data-label="@lang('Password')">
												@if($staff->status == 0)
													<span class="font-weight-bold">{{$staff->show_password}}</span>
												@else
													<span class="font-weight-bold">@lang('N/A')</span>
												@endif
											</td>

											<td data-label="@lang('Joined At')">
												{{ showDateTime($staff->created_at) }} <br> {{ diffForHumans($staff->created_at) }}
											</td>

											<td data-label="@lang('Action')">
                                                {{-- <a href="{{route('staff.edit', $staff->id)}}" class="btn btn-sm btn-outline-primary mr-2" data-toggle="tooltip" title="" data-original-title="@lang('Edit')">
                                                    Edit
                                                </a>
												@can('staff-edit')
													<a href="{{route('staff.edit', $staff->id)}}" class="btn btn-sm btn-outline-primary mr-2" data-toggle="tooltip" title="" data-original-title="@lang('Edit')">
														Edit
													</a>
												@endcan
												@can('staff-delete')
													<a href="{{route('staff.delete', $staff->id)}}" onclick="return confirm('Are you sure to delete this staff?')" class="btn btn-sm btn-outline-danger delete" data-toggle="tooltip" title="" data-original-title="@lang('Delete')">
														Delete
													</a>
												@endcan --}}

											</td>
											@empty
											<tr>
												<td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
											</tr>
                            				@endforelse
										</tr>
									</tbody>
								</table>
								{!! $staffs->links() !!}
							</div>
						</div>
					</div>
				</div>
				<!--end row-->
			</div>
		</div>
@endsection
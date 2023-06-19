@extends("layouts.admin.app")

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
								<li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
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
									<table id="example__" class="table table-striped table-bordered" style="width:100%">
										<thead>
											<tr>
											<th>@lang('#')</th>
											<th>@lang('Member ID')</th>
											<th>@lang('Name')</th>
											<th>@lang('Email')</th>
											<th>@lang('Phone')</th>
											<th>@lang('Address')</th>
											<th>@lang('Joined At')</th>
											<th>@lang('Action')</th>
											</tr>
										</thead>
										<tbody>
										@forelse($user as $key => $users)
											<tr>
                                                <td class=" text-center">
                                                    {{ $user->firstItem() + $key }}
                                                </td>
												<td><div class="badge text-primary bg-light-primary">{{$users->member_id}}</div></td>
												<td data-label="@lang('Name')">
                                                    {{$users->fullname}}
                                                    <br>
                                                    <div class="badge text-success bg-light-success"></div><br>
												</td>
												<td>{{$users->email}}</td>
												<td>{{$users->mobile_code}} {{$users->mobile}}</td>
												<td>{{$users->address}}</td>

												<td data-label="@lang('Joined At')">
													{{ showDateTime($users->created_at) }} <br> {{ diffForHumans($users->created_at) }}
												</td>

												<td data-label="@lang('Action')">
												</td>
												@empty
												<tr>
													<td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
												</tr>
												@endforelse
											</tr>
										</tbody>
									</table>
									{!! $user->links() !!}
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


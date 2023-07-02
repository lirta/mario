@extends("layouts.admin.app")

	@section("style")
	<link href="{{ url('assets/plugins/highcharts/css/highcharts.css') }}" rel="stylesheet" />
	<link href="{{ url('assets/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet" />
	@endsection

		@section("wrapper")
		<div class="page-wrapper">
			<div class="page-content">

             <div class="dash-wrapper bg-dark">
                <div class="row row-cols-1 row-cols-lg-3">
					<div class="col">
						<div class="card radius-10">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div class="flex-grow-1">
										<p class="text-success mb-0 font-13">{{ __('Total Antrian Hari ini') }}</p>
										<h4 class="font-weight-bold">{{$all}}</h4>
									</div>
									{{-- <div class="widgets-icons bg-gradient-cosmic text-white">
									</div> --}}
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div class="flex-grow-1">
										{{-- <p class="mb-0">Amount VD</p> --}}
										<p class="text-success mb-0 font-13">Menunggu</p>
										<h4 class="font-weight-bold">{{$wait}}</h4>
									</div>
									{{-- <div class="widgets-icons bg-gradient-burning text-white"><i class='bx bx-dollar-circle'></i>
									</div> --}}
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div class="flex-grow-1">
										<p class="text-success mb-0 font-13">Selesai</p>
										<h4 class="font-weight-bold">{{$finish}}</h4>
									</div>
									{{-- <div class="widgets-icons bg-gradient-lush text-white"><i class='bx bx-dollar'></i>
									</div> --}}
								</div>
							</div>
						</div>
					</div>

					<div class="col">
						<div class="card radius-10">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div class="flex-grow-1">
										<p class="text-success mb-0 font-13">Sedang Dikerjakan</p>
										@if (@$antri == null)
											<h4 class="font-weight-bold">Tidak Ada Yang Dikerjakan</h4>
										@else
											<h4 class="font-weight-bold">{{@$antri->no_antrian}} => {{@$antri->service->layanan}}</h4>
											<h4 class="font-weight-bold">Member ID => {{@$antri->user->member_id}}</h4>
											
										@endif
									</div>
									{{-- <div class="widgets-icons bg-gradient-lush text-white"><i class='bx bx-dollar'></i>
									</div> --}}
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
			 </div>
			</div>
		</div>
		@endsection
	@section("script")
	<script src="{{ url('assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
	<script src="{{ url('assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
	<script src="{{ url('assets/plugins/highcharts/js/highcharts.js') }}"></script>
	<script src="{{ url('assets/plugins/highcharts/js/exporting.js') }}"></script>
	<script src="{{ url('assets/plugins/highcharts/js/variable-pie.js') }}"></script>
	<script src="{{ url('assets/plugins/highcharts/js/export-data.js') }}"></script>
	<script src="{{ url('assets/plugins/highcharts/js/accessibility.js') }}"></script>
	<script src="{{ url('assets/plugins/apexcharts-bundle/js/apexcharts.min.js') }}"></script>
    <script>
		new PerfectScrollbar('.dashboard-top-countries');
	</script>
	<script>
		$(".topbar").addClass('topbar d-flex align-items-center bg-dark shadow-none border-light-2 border-bottom');
		$(".nav-link").addClass('text-white');
		$(".user-name").addClass('text-white');
	</script>
	<script src="{{ url('assets/js/index.js') }}"></script>
	@endsection

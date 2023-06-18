@extends("layouts.admin.app")

	@section("style")
	<link href="{{ url('assets/plugins/highcharts/css/highcharts.css') }}" rel="stylesheet" />
	<link href="{{ url('assets/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet" />
	@endsection

		@section("wrapper")
		<div class="page-wrapper">
			<div class="page-content">

             <div class="dash-wrapper bg-dark">
                 
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

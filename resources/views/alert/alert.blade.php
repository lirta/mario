@if(Session('success'))
	<div class="alert alert-success border-0 bg-success alert-dismissible fade show py-2">
		<div class="d-flex align-items-center">
			<div class="font-35 text-white"><i class='bx bxs-check-circle'></i>
			</div>
			<div class="ms-3">
				<h6 class="mb-0 text-white">Success Alerts</h6>
				<div class="text-white">{{ Session('success') }}</div>
			</div>
		</div>
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	</div>
@elseif(Session('error'))
	<div class="alert alert-danger border-0 bg-danger alert-dismissible fade show py-2">
		<div class="d-flex align-items-center">
			<div class="font-35 text-white"><i class='bx bx-info-circle'></i>
			</div>
			<div class="ms-3">
				<h6 class="mb-0 text-white">Error</h6>
				<div class="text-white">{{Session('error')}}</div>
			</div>
		</div>
		<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	</div>

@endif
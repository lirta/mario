<div class="modal fade" id="extra{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Tambahan Waktu</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form action="{{route('antrian.extra-time')}}" method="POST" enctype="multipart/form-data">
			@csrf
				<div class="card-body">
					<input type="hidden" name="id" value="{{$item->id}}">
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
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary px-4">Create Layanan</button>
				</div>
			</form>
		</div>
	</div>
</div>
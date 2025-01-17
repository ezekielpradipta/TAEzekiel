@php
	$judul = 'Kegiatan TAK'
@endphp
@extends('layouts.admin')
@section('content')
	@include('admin.header',[$judul=>'judul'])
		<section class="content">
		@include('admin.alert')
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Daftar {{$judul}}</h3>
				<a href="{{route('admin.kegiatanTAK.create')}}" class="btn btn-primary float-right">
					<span class="fas fa-plus"> Tambah {{$judul}}</span>
				</a>
			</div>
			<div class="col-sm-6">
            <select name="pilar_filter" id="pilar_filter" class="form-control" required>
                <option value="">- Pilih Pilar -</option>
                @foreach($pilartaks as $pilartak)
                    <option value="{{ $pilartak->id }}"> {{$pilartak->kategoritak->nama}} -
                    {{ $pilartak->nama }}</option>
                @endforeach
            </select>
        </div>
			<div class="card-body">

				<table id="dt" class="table table-bordered table-striped">
					<thead>
						<th>Nama Kegiatan</th>
						<th>Aksi</th>
					</thead>
				</table>
			</div>
		</div>
	</section>
@endsection
@push('scripts')
    <script>
        $(document).ready(function(){
		 fetch_data();
		 function fetch_data(pilartaks = '')
		 {
		  $('#dt').DataTable({
		   processing: true,
		   serverSide: true,
		   ajax: {
		    url:"{{ route('admin.kegiatanTAK.index') }}",
		    data: {pilartaks:pilartaks}
		   },
			columns: [
                    
                    { data: 'nama', name: 'nama' },
     			 { data: 'action', name: 'action', orderable: false, searchable: false}
                ]
		  });
		 }
		 
		 $('#pilar_filter').change(function(){
		  var pilartak_id = $('#pilar_filter').val();
		  $('#dt').DataTable().destroy();
		  fetch_data(pilartak_id);
		 });

		});
    </script>
@endpush
@php
	$judul = 'Tingkat TAK'
@endphp
@extends('layouts.admin')
@section('content')
	@include('admin.header',[$judul=>'judul'])
		<section class="content">
		@include('admin.alert')
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Daftar {{$judul}}</h3>
				<a href="{{route('admin.tingkatTAK.create')}}" class="btn btn-primary float-right">
					<span class="fas fa-plus"> Tambah {{$judul}}</span>
				</a>
			</div>
			<div class="col-sm-6">
            <select name="kegiatan_filter" id="kegiatan_filter" class="form-control" required>
                <option value="">- Pilih Kegiatan -</option>
                @foreach($kegiatantaks as $kegiatantak)
                    <option value="{{ $kegiatantak->id }}"> 
                    {{ $kegiatantak->nama }}</option>
                @endforeach
            </select>
        </div>
			<div class="card-body">

				<table id="dt" class="table table-bordered table-striped">
					<thead>
						<th>Nama Kegiatan</th>
						<th>Nama Tingkat</th>
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
		 function fetch_data(kegiatantaks = '')
		 {
		  $('#dt').DataTable({
		   processing: true,
		   serverSide: true,
		   ajax: {
		    url:"{{ route('admin.tingkatTAK.index') }}",
		    data: {kegiatantaks:kegiatantaks}
		   },
			columns: [
                 { data: 'nama', name: 'kegiatantaks.nama' },
                 { data: 'keterangan', name: 'tingkattaks.keterangan' },
     			 { data: 'action', name: 'action', orderable: false, searchable: false}
                ]
		  });
		 }
		 
		 $('#kegiatan_filter').change(function(){
		  var kegiatantak_id = $('#kegiatan_filter').val();
		  $('#dt').DataTable().destroy();
		  fetch_data(kegiatantak_id);
		 });

		});
    </script>
@endpush
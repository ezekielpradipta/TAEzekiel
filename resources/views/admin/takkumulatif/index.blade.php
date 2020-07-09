@php
	$judul = 'TAK Kumulatif'
@endphp
@extends('layouts.admin')
@section('content')
	@include('admin.header',[$judul=>'judul'])
		<section class="content">
		@include('admin.alert')
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Daftar {{$judul}}</h3>
				<a href="{{route('admin.takkumulatif.create')}}" class="btn btn-primary float-right">
					<span class="fas fa-plus"> Tambah {{$judul}}</span>
				</a>
			</div>
			<div class="card-body">
				<table id="dt" class="table table-bordered table-striped">
					<thead>
						<th>No.</th>
						<th>Prodi</th>
						<th>Angkatan</th>
						<th>Poin Minimal</th>
						<th>Aksi</th>
					</thead>
				</table>
			</div>
		</div>
	</section>
@endsection
@push('scripts')
	<script>
        $(function() {
            $('#dt').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.takkumulatif.data') }}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'prodi.nama',  name: 'prodi.nama' },
                    { data: 'angkatan.tahun', name: 'angkatan.tahun' },
                    { data: 'poinminimum', name: 'poinminimum' },
                    { data: 'action', name: 'action', orderable: false, searchable: false},
                   ]
            });
        });
    </script>
@endpush
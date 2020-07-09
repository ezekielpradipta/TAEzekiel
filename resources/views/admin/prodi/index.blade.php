@php
	$judul = 'Data Prodi'
@endphp
@extends('layouts.admin')
@section('content')
	@include('admin.header',[$judul=>'judul'])
		<section class="content">
		@include('admin.alert')
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Daftar {{$judul}}</h3>
				<a href="{{route('admin.prodi.create')}}" class="btn btn-primary float-right">
					<span class="fas fa-plus"> Tambah {{$judul}}</span>
				</a>
			</div>
			<div class="card-body">
				<table id="dt" class="table table-bordered table-striped">
					<thead>
						<th>No.</th>
						<th>Nama</th>
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
                ajax: '{{ route('admin.prodi.data') }}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'nama', name: 'nama' },
                    { data: 'action', name: 'action', orderable: false, searchable: false}
                ]
            });
        });
    </script>
@endpush
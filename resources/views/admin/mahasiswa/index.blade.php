@php
	$judul ='Data Mahasiswa'
@endphp
@extends('layouts.admin')
@section('content')

	@include('admin.header',[$judul=>'judul'])
	<section class="content">
		@include('admin.alert')
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Daftar {{$judul}}</h3>
				<a href="#" class="btn btn-primary float-right">
					<span class="fas fa-plus"> Tambah {{$judul}}</span>
				</a>
			</div>
			<div class="card-body">
				<table id="dt" class="table table-bordered table-striped">
					<thead>
						<th>No.</th>
						<th>Nama</th>
						<th>Email</th>
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
                ajax: '{{ route('admin.mahasiswa.data') }}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                   ]
            });
        });
    </script>
@endpush
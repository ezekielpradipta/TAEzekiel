@php
	$judul = 'TAK'
@endphp
@extends('layouts.admin')
@section('content')
	@include('admin.header',[$judul=>'judul'])
		<section class="content">
		@include('admin.alert')
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">Daftar {{$judul}}</h3>
				<a href="{{route('admin.tak.create')}}" class="btn btn-primary float-right">
					<span class="fas fa-plus"> Tambah {{$judul}}</span>
				</a>
			</div>

			<div class="card-body">

				<table id="dt" class="table table-bordered table-striped">
					<thead>
						<th>Kegiatan</th>
						<th>Tingkat</th>
						<
						<th>Poin</th>
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
                ajax: '{{ route('admin.tak.data') }}',
                columns: [
                    { data: 'kegiatantak.nama',  name: 'kegiatantak.nama' },
                    { data: 'tingkattak.keterangan',  name: 'tingkattak.keterangan' },
                    { data: 'score', name: 'score' },
                    { data: 'action', name: 'action', orderable: false, searchable: false},
                   ]
            });
        });
    </script>
@endpush
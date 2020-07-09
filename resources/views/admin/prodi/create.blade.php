@php
	$judul ='Prodi'
@endphp
@extends('layouts.admin')
@section('content')
@include('admin.header',[$judul=>'judul'])
<section class="content">
	@include('admin.alert')
	<div class="card">
		<div class="card-header">
			<h3 class="card-title">Tambah {{$judul}}</h3>
		</div>
		<form  method="post" enctype="multipart/form-data" action="{{route('admin.prodi.store')}}">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="card-body">
        @include('admin.prodi.form',['update'=>false])
			</div>
			<div class="card-footer">
				<button type="submit" id="register" class="btn btn-primary"><span class="fa fa-plus"></span> Tambah {{ $judul }}</button>
                    <a href="{{ route('admin.prodi.index') }}" class="btn btn-default"><span class="fa fa-arrow-left"></span> Batal</a>
			</div>
		</form>
	</div>
</section>
@endsection

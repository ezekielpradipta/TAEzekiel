@php
  $judul ='Kategori TAK'
@endphp
@extends('layouts.admin')
@section('content')
@include('admin.header',[$judul=>'judul'])
<section class="content">
  @include('admin.alert')
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Edit {{$judul}}</h3>
    </div>
    <form  method="post" enctype="multipart/form-data" action="{{route('admin.kategoriTAK.update',$kategoriTAK->id)}}">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
       @method('put')
      <div class="card-body">
        @include('admin.kategoriTAK.form',['update'=>true])
      </div>
      <div class="card-footer">
        <button type="submit" id="register" class="btn btn-primary"><span class="fa fa-plus"></span> Simpan {{ $judul }}</button>
                    <a href="{{ route('admin.kategoriTAK.index') }}" class="btn btn-default"><span class="fa fa-arrow-left"></span> Batal</a>
      </div>
    </form>
  </div>
</section>
@endsection
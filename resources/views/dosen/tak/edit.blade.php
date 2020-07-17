@php
  $judul ='Tingkat TAK'
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
    <form  method="post" enctype="multipart/form-data" action="{{route('admin.tak.update',$tak->id)}}">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
       @method('put')
      <div class="card-body">
        @include('admin.tak.formEdit',['update'=>true])
      </div>
      <div class="card-footer">
        <button type="submit" id="register" class="btn btn-primary"><span class="fa fa-plus"></span> Simpan {{ $judul }}</button>
                    <a href="{{ route('admin.tak.index') }}" class="btn btn-default"><span class="fa fa-arrow-left"></span> Batal</a>
      </div>
    </form>
  </div>
</section>
@endsection
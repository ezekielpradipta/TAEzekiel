@extends('layouts.app')

@section('content')

<div class="container">	
@if(session('success'))
    <div class="alert alert-success">
        {!! session('success') !!}
    </div>
@endif

@if(session('fail'))
    <div class="alert alert-danger">
        {!! session('fail') !!}
    </div>
@endif
		<form  method="POST" enctype="multipart/form-data" action="{{route('konfirmformmahasiswa')}}">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="card">
			<div class="text-center mt-3">
				<h5 class="card-title ">Selamat Datang {{ Auth::user()->name }} di Aplikasi TAK</h5>
				<h6 class="card-title">Silahkan Lengkapi Identitas diri anda</h6>
			</div>
			<div class="card-body">
					<div class="form-group">
						<div class="col-sm-6">
							<input type="hidden" name="user_id" value="{{Auth::user()->id}}">
						<label for="email">Email</label>
							<input type="email" name="email" class="form-control" id="email" value="{{ Auth::user()->email }}" readonly> 
						</div>	
					</div>
					<div class="form-group">
						<div class="col-sm-6">
						<label for="nim">NIM</label>
							<input type="text" name="nim" class="form-control @error('nim') is-invalid @enderror" id="nim" placeholder="NIM...." required > 
						</div>
						@error('nim')
                        	<span role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror	
					</div>
					<div class="form-group @error('dosen_id') has-error @enderror">
						<div class="col-sm-6">
						<label for="dosen_id">Dosen Wali</label>
							<select class="form-control" required name="dosen_id">
								<option value="">--Pilih Dosen--</option>
								@foreach ($dosens as $dosen)
								<option value="{{$dosen->id}}">{{$dosen->user->name}}</option>
								@endforeach
							</select>
						</div>
						@error('dosen_id')
                        	<span role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror	
					</div>
					<div class="form-group @error('gender') has-error @enderror ">
						<div class="col-sm-6">
						<label for="gender">Jenis Kelamin</label>
							<select class="form-control" name="gender" required>
								<option value="">--Pilih Gender--</option>
								<option value="L">Laki-Laki</option>
								<option value="P">Perempuan</option>
							</select>
						</div>
						@error('gender')
                        	<span role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
					</div>
					<div class="form-group">
                   		<div class="col-sm-6">
	                    	<label for="exampleInputFile">Upload Foto Profil</label>
			                  <div class="input-group">
		                      <div class="custom-file">
		                        <input type="file" name="image" class="custom-file-input" id="exampleInputFile">
		                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
		                      </div>
		                    </div>
	                    </div>
                  </div>
					
			</div>
			<div class="card-footer">
				<button type="submit" id="register" class="btn btn-primary"><span class="fa fa-plus"></span> Submit</button>
			</div>
			</div>
			</form>
			
		</div>
</div>	
@endsection
@push('scripts')
<script>
$(document).ready(function () {
  bsCustomFileInput.init();
});
</script>
@endpush
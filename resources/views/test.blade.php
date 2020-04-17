@extends('layouts.app')

@section('content')
<div class="container">	
		<div class="card">
			<div class="card-header">
				<h5 class="card-title">Selamat Datang</h5>
			</div>
			<form>
				<div class="card-body">
					<div class="form-group">
						<div class="col-sm-6">
						<label for="inputEmail">Email</label>
							<input type="email" name="email" class="form-control" id="inputEmail" readonly> 
						</div>	
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-sm-6">
								<label for="inputNIM">NIM</label>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
</div>	
@endsection
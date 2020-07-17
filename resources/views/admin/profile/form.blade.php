					
          <div class="form-group">
						<div class="col-sm-6">
						<label for="inputEmail">Email</label>
							<input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Email.." value="{{ old('email', $update ? $admin->user->email:'') }}"> 
						</div>
            @if($update)<span>Lewati jika tidak ingin mengganti email</span> @endif
						@error('email')
                        	<span role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    	<span id="emailbener" class="emailbener"></span>
                        <span id="error_email" class="error_email"></span>
                          
					</div>
					<div class="form-group">
						<div class="col-sm-6">
							<label for="inputUsername">Username</label>
							<input type="text" name="username" id="username" class="form-control @error('username') is-invalid @enderror" placeholder="Username.." value="{{ old('username', $update ? $admin->user->username:'') }}">
						</div>	
						@error('username')
                        	<span role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <span id="unamebener" class="unamebener"></span>
                        <span id="error_uname" class="error_uname"></span>
                                       
					</div>
          <div class="form-group">
            <div class="col-sm-6">
              <label for="inputNIDN">NIDN</label>
              <input type="text" name="nidn" id="nidn" class="form-control @error('nidn') is-invalid @enderror" placeholder="NIDN.." value="{{ old('nidn', $update ? $admin->nidn:'') }}">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-6">
              <label for="inputNama">Nama</label>
              <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Nama.." value="{{ old('nama', $update ? $admin->nama:'') }}">
            </div>  
            @error('nama')
                          <span role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                                       
          </div>
					<div class="form-group">
						<div class="col-sm-6">
							<label for="inputPassword">Password</label>
							<input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password.." value="{{ old('password', $update ? $admin->user->password_text:'') }}" autocomplete="new-password">
						</div>
						@error('password')
                        	<span  role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror	
					</div>
					<div class="form-group">
						<div class="col-sm-6">
					    	<div class="form-check">
					      		<input class="form-check-input" type="checkbox" id="gridCheck">
					      		<label class="form-check-label" for="gridCheck">
					        Show Password
					      		</label>
					    	</div>
					  </div>
					</div>
					<div class="form-group">
						<div class="col-sm-6">
							<label for="inputCPassword">Confirm Password</label>
							<input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm Password.." autocomplete="new-password">
						</div>						
					</div>
          <div class="form-group">
            <div class="col-sm-6">
              <label for="exampleInputFile">Upload Foto Admin</label>
              @if($update)
              <div class="col-sm-3">
                <img src="{{$admin->image_url}}" height="60px" width="60px" alt="image">
              </div>
              @endif
                <div class="input-group">

                  <div class="custom-file">
                    <input type="file" name="image" class="custom-file-input" id="exampleInputFile">
                      <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                  </div>
                </div>
            </div>
          </div>

@push('scripts')
<script type="text/javascript">
	$(document).ready(function(){		
		$('#gridCheck').click(function(){
			if($(this).is(':checked')){
				$('#password').attr('type','text');
			}else{
				$('#password').attr('type','password');
			}
		});
		bsCustomFileInput.init();
	});

</script>
@endpush
@push('scripts2')
<script>
    $(document).ready(function(){
      $('#email').blur(function(){
        var error_email = '';
        var email = $('#email').val();
        var _token = $('input[name="_token"]').val();
        var filter = /^([a-zA-Z0-9_\.\-])+\@(st3telkom\.ac\.id|ittelkom-pwt\.ac\.id)+$/;
        if(!filter.test(email))
        {
         $('#error_email').html('<label id="iderroremail" class="text-danger">Bukan Email Institusi</label>');
         $('#idemailbener').html('<label></label>');
         $('#email').addClass('has-error');
         $('#register').attr('disabled', 'disabled');
        }
        else
        {
         $.ajax({
          url:"{{ route('register.cekEmail') }}",
          method:"POST",
          data:{email:email, _token:_token},
          success:function(result)
          {
           if(result == 'unique')
           {
            $('#emailbener').html('<label id="idemailbener" class="text-success">Email Tersedia</label>');
            $('#iderroremail').html('<label></label>');
            $('#iderroremail2').html('<label></label>');
            $('#email').removeClass('has-error');
            $('#register').attr('disabled', false);
           }
           else
           {
            $('#error_email').html('<label id="iderroremail2" class="text-danger">Email Sudah Digunakan</label>');
            $('#idemailbener').html('<label></label>');
            $('#email').addClass('has-error');
            $('#register').attr('disabled', 'disabled');
           }
          }
         })
        }
     });
      $('#username').blur(function(){
          var error_uname = '';
          var username = $('#username').val();
          var _token = $('input[name="_token"]').val();
          
           $.ajax({
            url:"{{ route('register.cekUsername') }}",
            method:"POST",
            data:{username:username, _token:_token},
            success:function(result)
            {
             if(result == 'unique')
             {
              $('#unamebener').html('<label id="idunamebener" class="fa fa-check" style="color: green;"></label>');
              $('#iderroruname').html('<label></label>');
              $('#username').removeClass('has-error');
              $('#register').attr('disabled', false);
             }
             else
             {
              $('#error_uname').html('<label id="iderroruname" class="text-danger" style="margin-bottom: -4rem;">Nama Sudah Digunakan</label>');
              $('#idunamebener').html('<label></label>');
              $('#username').addClass('has-error');
              $('#register').attr('disabled', 'disabled');
             }
            }
           })
     });
    });

 </script>
@endpush
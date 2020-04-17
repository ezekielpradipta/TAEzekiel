					<div class="form-group">
						<div class="col-sm-6">
						<label for="inputEmail">Email</label>
							<input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Email.." value="{{ old('email', $update ? $dosen->email:'') }}"> 
						</div>
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
							<label for="inputNama">Nama</label>
							<input type="name" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Nama.." value="{{ old('name', $update ? $dosen->name:'') }}">
						</div>	
						@error('name')
                        	<span role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <span id="namabener" class="namabener"></span>
                        <span id="error_name" class="error_name"></span>
                                       
					</div>
					<div class="form-group">
						<div class="col-sm-6">
							<label for="inputPassword">Password</label>
							<input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password.." value="{{ old('password', $update ? $dosen->password_text:'') }}" autocomplete="new-password">
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
    });

         $('#name').blur(function(){
          var error_name = '';
          var name = $('#name').val();
          var _token = $('input[name="_token"]').val();
          
           $.ajax({
            url:"{{ route('register.cekNama') }}",
            method:"POST",
            data:{name:name, _token:_token},
            success:function(result)
            {
             if(result == 'unique')
             {
              $('#namabener').html('<label id="idnamabener" class="text-success">Nama Tersedia</label>');
              $('#iderrorname').html('<label></label>');
              $('#name').removeClass('has-error');
              $('#register').attr('disabled', false);
             }
             else
             {
              $('#error_name').html('<label id="iderrorname" class="text-danger">Nama Sudah Digunakan</label>');
              $('#idnamabener').html('<label></label>');
              $('#name').addClass('has-error');
              $('#register').attr('disabled', 'disabled');
             }
            }
           })
     });
 </script>
@endpush
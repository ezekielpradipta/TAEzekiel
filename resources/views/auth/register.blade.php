@extends('layouts.app')

@section('content')
<div class="container">
<div class="row justify-content-center">
    <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-6 d-none d-lg-block"></div>
                    <div class="col-lg-6">
                    <div class="pt-5 pb-5">
                            <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Daftar Akun</h1>
                            </div>
                        <form method="post" action="{{ route('register') }}" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="input-group col-lg-12 mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white px-4 border-md border-right-0"><i class="fa fa-user text-muted"></i></span>
                                </div>
                                    <input id="name" type="text" name="name" placeholder="Nama" class="form-control bg-white border-left-0 border-md @error('name') is-invalid @enderror mr-2"value="{{ old('name') }}" autocomplete="name" >
                                    @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                    @enderror
                                        <div id="namabener" class="namabener"></div>
                                        <div class="col-lg-12" style="font-size: small;">
                                             <span id="error_name" class="error_name"></span>
                                        </div>
                            </div>
                            <div class="input-group col-lg-12 mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white px-4 border-md border-right-0"><i class="fa fa-user text-muted"></i></span>
                                </div>
                                    <input id="username" type="text" name="username" placeholder="Username" class="form-control bg-white border-left-0 border-md @error('username') is-invalid @enderror mr-2"value="{{old('username')}}" autocomplete="username">
                                        @error('username')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                        <div id="unamebener" class="unamebener"></div>
                                        <div class="col-lg-12" style="font-size: small;">
                                             <span id="error_uname" class="error_uname"></span>
                                        </div>
                            </div>
                            <div>
                                <div class="input-group col-lg-12 mb-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white px-4 border-md border-right-0"><i class="fa fa-envelope text-muted"></i></span>
                                    </div>
                                        <input id="email" type="email" name="email" placeholder="Email" class="form-control bg-white border-left-0 border-md @error('email') is-invalid @enderror mr-2" value="{{ old('email') }}" >
                                            @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                            @enderror
                                        <div id="emailbener" class="emailbener"></div>
                                        <div class="col-lg-12" style="font-size: small;">
                                             <span id="error_email" class="error_email"></span>
                                        </div>
                                </div>
       
                            </div>
                            <div class="input-group col-lg-12 mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white px-4 border-md border-right-0"><i class="fa fa-lock text-muted"></i></span>
                                </div>
                                    <input id="password" type="password" name="password" placeholder="Password" class="form-control bg-white border-left-0 border-md @error('password') is-invalid @enderror mr-2" autocomplete="new-password">
                                        @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        @enderror
                                    <div id="msg"></div>
                            </div>

                            <div class="input-group col-lg-12 mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white px-4 border-md border-right-0"><i class="fa fa-lock text-muted"></i></span>
                                </div>
                                    <input id="password-confirm" type="password" name="password_confirmation" placeholder="Confrim Password" class="form-control bg-white border-left-0 border-md mr-2" autocomplete="new-password">
                                    <div id="msg2"></div>
                            </div>
                            
                       
                        <div class="form-group col-lg-12  mb-0">
                            <button type="submit" class="btn btn-primary btn-block py-2" id="register" name="register"><span class="font-weight-bold">Buat Akun Sekarang</span></button>   
                        </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function(){
        $('#password-confirm').keyup(validate);

    });
    function validate(){
        var pass1 = $("#password").val();
        var pass2 = $("#password-confirm").val();

        if(pass1 == pass2){
            $("#msg").html('<label class ="fa fa-check" style="color: green;"></label>');
            $("#msg2").html('<label class ="fa fa-check" style="color: green;"></label>');
        } else {
            $("#msg").html('<label class="fa fa-remove" style="color: red;"></label>');  
            $("#msg2").html('<label class="fa fa-remove" style="color: red;"></label>');
            $('#register').attr('disabled', 'disabled');   
        }
    }
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
       $('#error_email').html('<label id="iderroremail" class="text-danger" style="margin-bottom: -4rem;">Bukan Email Institusi</label>');
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
          $('#emailbener').html('<label id="idemailbener" class="fa fa-check text-success"></label>');
          $('#iderroremail').html('<label></label>');
          $('#iderroremail2').html('<label></label>');
          $('#email').removeClass('has-error');
          $('#register').attr('disabled', false);
         }
         else
         {
          $('#error_email').html('<label id="iderroremail2" class="text-danger" style="margin-bottom: -4rem;">Email Sudah Digunakan</label>');
          $('#idemailbener').html('<label></label>');
          $('#email').addClass('has-error');
          $('#register').attr('disabled', 'disabled');
         }
        }
       })
      }
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
              $('#namabener').html('<label id="idnamabener" class="fa fa-check" style="color: green;"></label>');
              $('#iderrorname').html('<label></label>');
              $('#name').removeClass('has-error');
              $('#register').attr('disabled', false);
             }
             else
             {
              $('#error_name').html('<label id="iderrorname" class="text-danger" style="margin-bottom: -4rem;">Nama Sudah Digunakan</label>');
              $('#idnamabener').html('<label></label>');
              $('#name').addClass('has-error');
              $('#register').attr('disabled', 'disabled');
             }
            }
           })
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
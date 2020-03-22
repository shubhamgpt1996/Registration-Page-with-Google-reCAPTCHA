<html>  
    <head>  
        <title>My Site</title>  
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    </head>  
    <body>  
        <div class="container" style="width: 600px">
   <br />
   
   <h3 align="center">Register Yourself Here!</a></h3><br />
   <br />
   <div class="panel panel-default">
      <div class="panel-heading">Register Form</div>
    <div class="panel-body">
     
     <form method="post" id="registration_form" action="{{ url('/registerUser') }}">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      {{-- <div class="col-md-6"> --}}
         {{-- <label>Name <span class="text-danger">*</span></label> --}}
         <span id="error" class="text-danger"></span>
         {{-- <span id="first_name_error" class="text-danger"></span> --}}
        {{-- </div> --}}
      <div class="form-group">
       <div class="row">
        <div class="col-md-6">
         <label>Name <span class="text-danger">*</span></label>
         <input type="text" name="name" id="name" class="form-control" required/>
         {{-- <span id="first_name_error" class="text-danger"></span> --}}
        </div>
       </div>
      </div>
      <div class="form-group">
       <label>Email Address <span class="text-danger">*</span></label>
       <input type="email" name="email" id="email" class="form-control" required/>
       {{-- <span id="email_error" class="text-danger"></span> --}}
      </div>
      <div class="form-group">
       <label>Password <span class="text-danger">*</span></label>
       <input type="password" name="password" id="password" class="form-control" required/>
       {{-- <span id="password_error" class="text-danger"></span> --}}
      </div>
      <input type="hidden" name="ip_count" id="ip_count" class="form-control" value='0'/>
      <div hidden id="captcha_div" class="form-group">
       {{-- <div class="g-recaptcha" data-sitekey="6Ldv2bcUAAAAAFeYuQAQWH7I_BVv2_2_vvmn2Fpp"></div> --}}
       {{-- <div class="g-recaptcha" data-sitekey="6LcR9-IUAAAAAH5NExgqyj0uPbQRV_0qTEuie_oh"></div> --}}
       <div class="g-recaptcha" data-sitekey={{env("RECAPTCHA_SITE_KEY")}}></div>
       <span id="captcha_error" class="text-danger"></span>
      </div>
      <div class="form-group">
       <input type="submit" name="register" id="register" class="btn btn-info" />
      </div>
     </form>
     
    </div>
   </div>
  </div>
    </body>  
</html>

<script>
$(document).ready(function(){

 $('#registration_form').on('submit', function(event){
  event.preventDefault();
  // validate-user




  $.ajax({
   url:"validate-user",
   method:"POST",
   data:$(this).serialize(),
   dataType:"json",
   beforeSend:function()
   {
    // $('#ip_count').val(3);
    $('#register').attr('disabled','disabled');
   },
   success:function(data)
   {
    console.log(data);
    $('#register').attr('disabled', false);
    if(data.success)
    {
      if(data.count >= 3){
        $('#ip_count').val(data.count);
        document.getElementById('captcha_div').removeAttribute('hidden');
      }
      else{
        
     // $('#registration_form')[0].reset();
     // $('#first_name_error').text('');
     // $('#last_name_error').text('');
     // $('#email_error').text('');
     // $('#password_error').text('');
     // $('#captcha_error').text('');
     // grecaptcha.reset();
     registration_form.submit();
     // alert('Form Successfully validated');
      }
    }
    else
    {
     $('#error').text(data.msg);
     // $('#last_name_error').text(data.last_name_error);
     // $('#email_error').text(data.email_error);
     // $('#password_error').text(data.password_error);
     // $('#captcha_error').text(data.captcha_error);
    }
   }
  })


  // $.ajax({
  //  url:"captcha-verification",
  //  method:"POST",
  //  data:$(this).serialize(),
  //  dataType:"json",
  //  beforeSend:function()
  //  {
  //   $('#register').attr('disabled','disabled');
  //  },
  //  success:function(data)
  //  {
  //   $('#register').attr('disabled', false);
  //   if(data.success)
  //   {
  //    $('#registration_form')[0].reset();
  //    $('#first_name_error').text('');
  //    $('#last_name_error').text('');
  //    $('#email_error').text('');
  //    $('#password_error').text('');
  //    $('#captcha_error').text('');
  //    grecaptcha.reset();
  //    alert('Form Successfully validated');
  //   }
  //   else
  //   {
  //    $('#first_name_error').text(data.first_name_error);
  //    $('#last_name_error').text(data.last_name_error);
  //    $('#email_error').text(data.email_error);
  //    $('#password_error').text(data.password_error);
  //    $('#captcha_error').text(data.captcha_error);
  //   }
  //  }
  // })
 });

});
</script>
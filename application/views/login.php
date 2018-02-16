<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Login Form</title>
  
  <link href="<?php echo base_url()?>template/sbadmin/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <script src="<?php echo base_url();?>/template/jquery/jquery.js"></script>

  <script src="<?php echo base_url()?>template/sbadmin/vendor/bootstrap/js/bootstrap.min.js"></script>

</head>

<body>

 <div class="container">    
  <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
    <div class="panel panel-info" >
      <div class="panel-heading">
        <div class="panel-title">Sign In</div>

      </div>     

      <div style="padding-top:30px" class="panel-body" >

        <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>

        <form id="loginForm" class="form-horizontal" role="form">

          <div style="margin-bottom: 25px" class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
            <input id="login-username" type="text" class="form-control" name="username" value="" placeholder="username">                                        
          </div>

          <div style="margin-bottom: 25px" class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
            <input id="login-password" type="password" class="form-control" name="password" placeholder="password">
          </div>

          <div style="margin-top:10px" class="form-group">
            <!-- Button -->

            <div class="col-sm-12 controls">
              <button type="submit" id="btn-login" href="#" class="btn btn-success">Login  </button>
              <a id="btn-fblogin" href="<?php echo base_url()?>index.php/Forecast/view" class="btn btn-primary">Halaman Peramalan</a>

            </div>
          </div>



        </div>    
      </form>     



    </div>                     
  </div>  
</div>

</body>
</html>

<script type="text/javascript">
  $('#loginForm').submit(function(e){
    e.preventDefault();
    console.log($('#loginForm').serialize());
    $.ajax({
      type:'POST',
      url:'<?php echo base_url()?>index.php/login/login',
      data:$('#loginForm').serialize(),
      success:function(data){
        console.log(data);
        if(data){
          window.location="<?php echo base_url();?>index.php/admin/";
        }
        else{
          alert("username atau password salah");
        }
      }
    });
  });
</script>
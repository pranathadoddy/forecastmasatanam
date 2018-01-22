<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Login Form</title>
  
  <link rel="stylesheet" href="<?php echo base_url();?>/template/normalize/normalize.min.css">
  <link rel="stylesheet" href="<?php echo base_url();?>/template/login/css/style.css">
  <script src="<?php echo base_url();?>/template/prefixfree/prefixfree.js"></script>
  <script src="<?php echo base_url();?>/template/jquery/jquery.js"></script>
</head>

<body>
  <div class="login">
   <h1>Login</h1>
   <form method="post" id="loginForm">
     <input type="text" name="username" placeholder="Username" required="required" />
     <input type="password" name="password" placeholder="Password" required="required" />
     <button type="submit" class="btn btn-primary btn-block btn-large">Login.</button>
   </form>
 </div>

 <script src="<?php echo base_url();?>/template/login/js/index.js"></script>

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
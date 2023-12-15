<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login form</title>
   <!-- icon css -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
   <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="assets/css/style.css">
   <script src="assets/js/login.js" defer></script>
</head>

<body>


   <div class="form-container">

      <div class="form">
         <h3>safe drive</h3>
         <div class="alert_msg"></div>
         <div class="input_box">
            <input type="email" name="email" class="email" placeholder="enter your email">
         </div>
         <div class="input_box d_flex ">
            <input type="password" name="password" class="pass" placeholder="enter your password">
            <span class="d_flex show_pass"><i class='bx bxs-hide'></i></span>
         </div>
         <div class="forget_pass">
            <a href="forgotpassword.php">forget password?</a>
         </div>
         <button class="form-btn login_btn">login now</button>
         <p class="form_link">don't have an account? <a href="register_form.php">register now</a></p>
      </div>

   </div>
</body>

</html>
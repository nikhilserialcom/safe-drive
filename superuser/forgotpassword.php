<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>forgot password form</title>

   <!-- icon css -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="assets/css/style.css">
   <!-- <script src="assets/js/login.js" defer></script> -->
</head>
<body>

   
<div class="form-container">

   <div class="form">
      <h3>safe drive</h3>
      <div class="alert_box alert"></div>
      <div class="form_header">
        <p>forget password?</p>
        <p>Enter your email and we'll send you instructions to reset your password</p>
      </div>
      <div class="input_box">
         <input type="email" name="email" class="email"  placeholder="enter your email">
      </div>
      <!-- <input type="submit" name="submit" value="login now" class="form-btn"> -->
      <button class="form-btn reset_link">send reset link</button>
      <div class="back_link">
          <a href="index.php">< back to sign in</a>
      </div>
   </div>

</div>
   <script src="assets/js/forgotpass.js"></script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>reset password form</title>
   <!-- icon css -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
   <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="assets/css/style.css">
   <script src="assets/js/otp.js" defer></script>
</head>

<body>


   <div class="form-container">

      <div class="form">
         <h3>safe drive</h3>
         <div class="alert_box alert"></div>
         <div class="form_header">
            <p>reset password?</p>
            <p class="email"></p>
         </div>
         <div class="otp_input">
            <input type="text" name="pass" class="otp">
            <input type="text" name="pass" class="otp">
            <input type="text" name="pass" class="otp">
            <input type="text" name="pass" class="otp">
         </div>
         <!-- <input type="submit" name="submit" value="login now" class="form-btn"> -->
         <button class="form-btn continue_btn">countinue</button>
         <b>Resend code in  <span id="timer"></span></b>
         <div class="back_link">
            <a href="forgotpassword.php">
               < back to sign in</a>
         </div>
      </div>

   </div>

</body>

</html>
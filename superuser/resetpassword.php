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
   <script src="assets/js/resetpassword.js" defer></script>
</head>

<body>


   <div class="form-container">

      <div class="form">
         <h3>safe drive</h3>
         <div class="form_header">
            <p>reset password?</p>
            <p>for example.demo@gmail.com</p>
         </div>
         <div class="input_box d_flex">
            <input type="password" name="pass" class="pass" placeholder="enter your new password">
            <span class="d_flex show_pass"><i class='bx bxs-hide'></i></span>
         </div>
         <div class="input_box d_flex">
            <input type="password" name="c_pass" class="c_pass" placeholder="enter your confirm password">
            <span class="d_flex show_pass"><i class='bx bxs-hide'></i></span>
         </div>
         <!-- <input type="submit" name="submit" value="login now" class="form-btn"> -->
         <button class="form-btn change_btn">change password</button>
         <div class="back_link">
            <a href="#">
               < back to sign in</a>
         </div>
      </div>

   </div>

</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register form</title>
   <!-- icon css -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
   <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="assets/css/style.css">
   <script src="assets/js/registare.js" defer></script>

</head>

<body>

   <div class="form-container">
      <div class="form">
         <h3>register now</h3>
         <div class="alert_msg"></div>
         <div class="input_box">
            <input type="text" name="username" class="username" placeholder="enter your username">
            <div class="error"></div>
         </div>
         <div class="input_box">
            <input type="text" name="name" class="full_name" placeholder="enter your name">
            <div class="error"></div>
         </div>
         <div class="input_box">
            <input type="email" name="email" class="email" placeholder="enter your email">
            <div class="error"></div>
         </div>
         <div class="input_box">
            <input type="password" name="password" class="pass" placeholder="enter your password">
            <div class="error"></div>
         </div>
         <!-- <div class="input_box">
         <input type="password" name="cpassword"  placeholder="confirm your password">
         <div class="error"></div>
      </div> -->
         <!-- <input type="submit" name="submit" value="register now" class="form-btn"> -->
         <button class="form-btn singup_btn">register now</button>
         <p class="form_link">already have an account? <a href="index.php">login now</a></p>
      </div>
   </div>

</body>

</html>
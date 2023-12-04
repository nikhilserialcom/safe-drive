<!DOCTYPE html>
<!-- Created by CodingLab |www.youtube.com/c/CodingLabYT-->
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8">
  <!--<title> Login and Registration Form in HTML & CSS | CodingLab </title>-->
  <link rel="stylesheet" href="assets/css/styles.css">
  <!-- Fontawesome CDN Link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
  <section class="login_page">
    <div class="container">
      <input type="checkbox" id="flip">
      <div class="cover">
        <div class="front">
          <img src="images/frontImg.jpg" alt="">
          <div class="text">
            <span class="text-1">Every new friend is a <br> new adventure</span>
            <span class="text-2">Let's get connected</span>
          </div>
        </div>
        <div class="back">
          <img class="backImg" src="images/backImg.jpg" alt="">
          <div class="text">
            <span class="text-1">Complete miles of journey <br> with one step</span>
            <span class="text-2">Let's get started</span>
          </div>
        </div>
      </div>
      <div class="forms">
        <div class="form-content">
          <div class="login-form">
            <div class="title">Login</div>
              <div class="input-boxes">
                <div class="input-box">
                  <i class="fas fa-envelope"></i>
                  <input type="email" class="email" placeholder="Enter your email">
                </div>
                <div class="input-box">
                  <i class="fas fa-lock"></i>
                  <input type="password" class="pass" placeholder="Enter your password">
                </div>
                <div class="text"><a href="#">Forgot password?</a></div>
                <div class="button">
                  <button class="log_btn">sign in</button>
                </div>
                <div class="text sign-up-text">Don't have an account? <label class="link" for="flip">Sigup now</label></div>
              </div>
          </div>
          <div class="signup-form">
            <div class="title">Signup</div>
              <div class="input-boxes">
                <div class="input-box">
                  <i class="fas fa-user"></i>
                  <input type="text" class="username" placeholder="Enter your username">
                  <div class="error"></div>
                </div>
                <div class="input-box">
                  <i class="fas fa-user"></i>
                  <input type="text" class="full_name" placeholder="Enter your name">
                  <div class="error"></div>
                </div>
                <div class="input-box">
                  <i class="fas fa-envelope"></i>
                  <input type="email" class="user_email" placeholder="Enter your email">
                  <div class="error"></div>
                </div>
                <div class="input-box">
                  <i class="fas fa-lock"></i>
                  <input type="password" class="user_pass" placeholder="Enter your password">
                  <div class="error"></div>
                </div>
                <div class="button">
                  <button class="singup_btn">sign up</button>
                </div>
                <div class="text sign-up-text">Already have an account? <label class="link" for="flip">Login now</label></div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <script src="assets/js/registare.js"></script>
</body>

</html>
</html>
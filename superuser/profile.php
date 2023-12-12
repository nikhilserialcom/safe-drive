<?php require_once 'layout/header.php'; ?>

<?php require_once 'layout/sidemenu.php'; ?>
<div class="delete_modal">
    <div class="delete_content">
        <div class="icon_box">
            <i class='bx bx-x-circle'></i>
        </div>
        <h4>are you sure?</h4>
        <input type="text" class="user_id" hidden>
        <p>Do you really want to delete these records? This process cannot be undone</p>
        <div class="btn_box">
            <button class="bg-label-success done_btn">yes</button>
            <button class="bg-label-danger cancel_btn">cancel</button>
        </div>
    </div>
</div>
<section class="content">
    <?php require_once 'layout/navbar.php'; ?>
    <main>
        <div class="head-title">
            <div class="left">
                <h1>Profile</h1>
                <ul class="breadcrumb">
                    <li>
                        <a href="#">Dashboard</a>
                    </li>
                    <i class="fas fa-chevron-right"></i>
                    <li>
                        <a href="#">Home</a>
                    </li>
                    <i class="fas fa-chevron-right"></i>
                    <li>
                        <a href="#" class="active">profile</a>
                    </li>
                </ul>
            </div>

        </div>

        <div class="profile_card">
            <div class="profile_box">

                <h5>profile details</h5>
                <div class="profile_image_box">
                    <div class="profile_image_content">
                        <!-- <img src="assets/img/profile.png" alt=""> -->
                    </div>
                    <div class="profile_btn">
                        <button class="upload_btn">upload new photo</button>
                        <input type="file" name="profileImage" class="profileImage" id="profileImage" accept=".png, .jpg, image/png, image/jpeg">
                        <p>Allowed JPG, GIF or PNG. Max size of 800K</p>
                    </div>
                    <div class="message_box">
                        <span class="alert-success">profile details update successfully !</span>   
                    </div>
                </div>
                <hr class="line">
                <div class="profile_data">
                    <div class="form">
                        <div class="user_data">
                            <div class="input_box">
                                <label for="">username :</label>
                                <input type="text" name="username" class="username" placeholder="enter your username">
                            </div>
                            <div class="input_box">
                                <label for="">full_name :</label>
                                <input type="text" name="name" class="full_name" placeholder="enter your full name">
                            </div>
                        </div>
                        <div class="password_change">
                            <div class="input_box">
                                <label for="">password :</label>
                                <input type="password" name="pass" class="pass" placeholder="enter your new password">
                            </div>
                            <div class="input_box">
                                <label for="">confrim password :</label>
                                <input type="password" name="c_pass" class="c_pass" placeholder="enter your confrim password">
                            </div>
                        </div>
                    </div>
                    <button class="change_btn">save change</button>
                </div>
            </div>
            <div class="delete_account">
                <h5>delete account</h5>
                <div class="delete_note alert-warning ">
                    <p>Are you sure you want to delete your account?</p>
                    <p>Once you delete your account, there is no going back. Please be certain.</p>
                </div>
                <button class="delete_btn">Deactivate Account</button>
            </div>
        </div>

    </main>
</section>
<script src="assets/js/profile.js"></script>
<?php require_once 'layout/footer.php'; ?>
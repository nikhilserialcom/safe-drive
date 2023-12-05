<?php require_once 'layout/header.php'; ?>

<?php require_once 'layout/sidemenu.php'; ?>
<div class="popup_image">
    <span class="close_popup">&times;</span>
    <div class="image_box">
        <img src="assets/img/2653062775.jpg" alt="">
    </div>
</div>
<section class="content">
    <?php require_once 'layout/navbar.php'; ?>
    <main>
        <div class="head-title">
            <div class="left">
                <h1>user information</h1>
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
                        <a href="#" class="active">users</a>
                    </li>
                </ul>
            </div>
        </div>  

        <div class="table-data">
            <div class="todo">
                <div class="user_avatar">
                    <!-- <div class="user_profile">
                        <img src="assets/img/7.png" alt="">
                    </div>
                    <div class="user_info">
                        <p class="user_name">nikhil patel</p>
                        <p class="user_type bg-label-secondary">driver</p>
                    </div> -->
                </div>
                <h5 class="info_title">details</h5>
                <div class="user_details">
                    <!-- <ul>
                        <li>
                            <span>mobile number:</span>
                            <span>+91635986587</span>
                        </li>
                        <li>
                            <span>email:</span>
                            <span>example@gmail.com</span>
                        </li>
                        <li>
                            <span>date of birth:</span>
                            <span>03/9/2023</span>
                        </li>
                        <li>
                            <span>city:</span>
                            <span>surat</span>
                        </li>
                        <li>
                            <span>status:</span>
                            <span class="badge bg-label-success">active</span>
                        </li>
                        <li>
                            <span>vehicle type:</span>
                            <span>car</span>
                        </li>
                        <li>
                            <span>vehicle brand:</span>
                            <span>lamborghini</span>
                        </li>
                    </ul> -->
                </div>
                <div class="action-btn">
                    <button class="btn-label-danger">suspend</button>
                </div>
            </div>
            <div class="order aadhar_card">
                <!-- <h3>aadhar card information</h3>
                <div class="info_header">
                    <span>aadhar no:</span>
                    <span>6359 8598 741</span>
                </div>
                <div class="info_document">
                    <div class="document_img_box">
                        <img src="assets/img/aadharcard1.png" alt="">
                    </div>
                    <div class="document_img_box">
                        <img src="assets/img/aadharcard1.png" alt="">
                    </div>
                    <div class="document_img_box">
                        <img src="assets/img/aadharcard1.png" alt="">
                    </div>
                </div> -->
            </div>
            <div class="order licese_data">
                <!-- <h3>driving licence information</h3>
                <div class="info_header">
                    <ul>
                        <li>
                            <span>driveing licence no:</span>
                            <span>AB12 12345678901</span>
                        </li>
                        <li>
                            <span>expiration date:</span>
                            <span>04/12/2023</span>
                        </li>
                    </ul>
                </div>
                <div class="info_document">
                    <div class="document_img_box">
                        <img src="assets/img/aadharcard1.png" alt="">
                    </div>
                    <div class="document_img_box">
                        <img src="assets/img/aadharcard1.png" alt="">
                    </div>
                    <div class="document_img_box">
                        <img src="assets/img/ID2.png" alt="">
                    </div>
                </div> -->
            </div>
            <div class="todo">
                <div class="police_data">
                    <!-- <h3>police clearance certificate</h3>
                    <div class="info_document">
                        <div class="document_img_box">
                            <img src="assets/img/aadharcard1.png" alt="">
                        </div>
                    </div> -->
                </div>
                <div class="insurance_data">
                    <!-- <h3>vehicle insurance</h3>
                    <div class="info_document">
                        <div class="document_img_box">
                            <img src="assets/img/aadharcard1.png" alt="">
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
        <div class="table-data">
            <div class="order vehicle_info">
                <!-- <h3>vahicle  information</h3>
                <div class="info_header">
                    <ul>
                        <li>
                            <span>vahicle Brand:</span>
                            <span>TATA</span>
                        </li>
                        <li>
                            <span>vahicel modal:</span>
                            <span>Tata Harrier</span>
                        </li>
                        <li>
                            <span>number plate no:</span>
                            <span>GJ-05-ET-1258</span>
                        </li>
                        <li>
                            <span>transport year:</span>
                            <span>04/12/2023</span>
                        </li>
                    </ul>
                </div>
                <h4>vehicel photo:</h4>
                <div class="vehicel_car_document">
                    <div class="car_img_box">
                        <img src="assets/img/aadharcard1.png" alt="">
                    </div>
                    <div class="car_img_box">
                        <img src="assets/img/aadharcard1.png" alt="">
                    </div>
                    <div class="car_img_box">
                        <img src="assets/img/aadharcard1.png" alt="">
                    </div>
                    <div class="car_img_box">
                        <img src="assets/img/aadharcard1.png" alt="">
                    </div>
                </div>
                <h4>rc photo:</h4>
                <div class="info_document">
                    <div class="document_img_box">
                        <img src="assets/img/aadharcard1.png" alt="">
                    </div>
                    <div class="document_img_box">
                        <img src="assets/img/aadharcard1.png" alt="">
                    </div>
                    <div class="document_img_box">
                        <img src="assets/img/ID2.png" alt="">
                    </div>
                </div> -->
            </div>
        </div>
    </main>
</section>

    <script src="assets/js/showuserdata.js" type="module"></script>
<?php require_once 'layout/footer.php'; ?>
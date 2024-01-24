<?php require_once 'layout/header.php'; ?>

<?php require_once 'layout/sidemenu.php'; ?>
<div class="popup_image">
    <span class="close_popup">&times;</span>
    <div class="image_box">
        <img src="assets/img/2653062775.jpg" alt="">
    </div>
</div>
<div class="accept_modal">
    <div class="accept_content">
        <span class="close">&times;</span>
        <div class="check_box">
            <div class="check_img">
                <img src="assets/img/check.svg" alt="">
            </div>
        </div>
        <p class="text">police clearance certificate is approved</p>
        <button class="btn" id="next_over">done</button>
    </div>
</div>
<div class="reject_modal">
    <div class="reject_content">
        <span class="close">&times;</span>
        <h3>rejection reason</h3>
        <!-- <div class="docu_list">
            <input type="checkbox" class="checkbox" value="aadhar card"><span>aadhar card</span> <br>
            <input type="checkbox" class="checkbox" value="driving license"><span>driving license</span> <br>
            <input type="checkbox" class="checkbox" value="police certification"><span>police certification</span> <br>
            <input type="checkbox" class="checkbox" value="vehicel insurance"><span>vehicel insurance</span> <br>
            <input type="checkbox" class="checkbox" value="vehicel informetion"><span>vehicel informetion</span>
        </div> -->
        <input type="text" class="reject_input" placeholder="Enter the reason">
        <button class="done_btn">done</button>
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
                        <a href="dashborad.php">Dashboard</a>
                    </li>
                    <i class="fas fa-chevron-right"></i>
                    <li>
                        <a href="users.php" class="active">users</a>
                    </li>
                    <!-- <i class="fas fa-chevron-right"></i>
                    <li>
                        <a href="#">Home</a>
                    </li> -->
                </ul>
            </div>
        </div>

        <div class="msg_box active_btn">
            <!-- <span class="alert-success">profile details update successfully !</span> -->
        </div>

        <div class="table-data">
            <div class="todo">
                <div class="back-btn back_btn">
                    <i class="fas fa-chevron-left"></i>
                </div>
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
                <div class="action-btn driver_btn">
                    <button class="bg-label-success active_driver">active</button>
                    <button class="btn-label-danger reject_driver">rejected</button>
                </div>
                <div class="msg_box driver_active">
                    <!-- <span class="alert-success">profile details update successfully !</span> -->
                </div>
            </div>
            <div class="order">
                <h3>aadhar card information</h3>
                <div class="aadhar_card">
                    <!-- 
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
                <div class="action-btn aadhar_btn">
                    <button class="bg-label-success aadhar_approve_btn">accept</button>
                    <button class="bg-label-danger aadhar_reject_btn">reject</button>
                </div>
                <div class="msg_box aadhar">
                    <!-- <span class="alert-success">profile details update successfully !</span> -->
                </div>
            </div>
            <div class="order">
                <h3>driving licence information</h3>
                <div class="licese_data">
                    <!--
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
                <div class="action-btn licese_btn">
                    <button class="bg-label-success license_approve_btn">accept</button>
                    <button class="bg-label-danger license_reject_btn">reject</button>
                </div>
                <div class="msg_box license">
                    <!-- <span class="alert-success">profile details update successfully !</span> -->
                </div>
            </div>
            <div class="todo">
                <h3>police clearance certificate</h3>
                <div class="police_data">
                    <!-- <h3>police clearance certificate</h3>
                    <div class="info_document">
                        <div class="document_img_box">
                            <img src="assets/img/aadharcard1.png" alt="">
                        </div>
                    </div> -->
                </div>
                <div class="action-btn police_btn">
                    <button class="bg-label-success police_approve_btn">accept</button>
                    <button class="bg-label-danger police_reject_btn">reject</button>
                </div>
                <div class="msg_box police">
                    <!-- <span class="alert-success">profile details update successfully !</span> -->
                </div>
                <h3>vehicle insurance</h3>
                <div class="insurance_data">
                    <!-- <h3>vehicle insurance</h3>
                    <div class="info_document">
                        <div class="document_img_box">
                            <img src="assets/img/aadharcard1.png" alt="">
                        </div>
                    </div> -->
                </div>
                <div class="action-btn insurance_btn">
                    <button class="bg-label-success insurance_approve_btn">accept</button>
                    <button class="bg-label-danger insurance_reject_btn">reject</button>
                </div>
                <div class="msg_box insurance">
                    <!-- <span class="alert-success">profile details update successfully !</span> -->
                </div>
            </div>
        </div>
        <div class="table-data">
            <div class="order">
                <h3>vahicle information</h3>
                <div class="vehicle_info">
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
                <div class="action-btn vehicel_btn">
                    <button class="bg-label-success vehicel_approve_btn">accept</button>
                    <button class="bg-label-danger vehicel_reject_btn">reject</button>
                </div>
                <div class="msg_box vehicale">
                    <!-- <span class="alert-success">profile details update successfully !</span> -->
                </div>
            </div>
        </div>
    </main>
</section>

<script src="assets/js/showuserdata.js" type="module"></script>
<?php require_once 'layout/footer.php'; ?>
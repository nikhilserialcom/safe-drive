<?php require_once 'layout/header.php'; ?>

<?php require_once 'layout/sidemenu.php'; ?>
<div class="user_modal">
    <div class="user_btn">
        <span class="close" id="closeModalBtn">&times;</span>
        <h3></h3>
        <div class="user_data">
            <!-- <div class="user_pic">
                <img src="assets/img/7.png" alt="">
            </div>
            <div class="user_name d_flex flex_direction">
                <span>nikhil patel</span>
                <span>nikhil@gmail.com</span>
            </div> -->
        </div>
        <!-- <div class="modal_btn d_flex">
            <button class="bg-label-success"><i class='bx bxs-edit'></i></button>
            <button class="bg-label-danger "><i class='bx bxs-trash-alt'></i></button>
            <button class="view_btn"><i class='bx bxs-show'></i></button>
        </div> -->
    </div>
</div>
<section class="content">
    <!-- <div class="view_mode">
        <ul class="view_list">
            <li>view</li>
            <li>suspend</li>
        </ul>
    </div> -->

    <?php require_once 'layout/navbar.php'; ?>
    <main>
        <div class="head-title">
            <div class="left">
                <h1>user List</h1>
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

        <div class="box-info">
            <li>
                <i class='bx bxs-user bg-label-primary'></i>
                <span class="text">
                    <h3 class="total_driver">1.5K</h3>
                    <p>total users</p>
                </span>
            </li>
            <li>
                <i class='bx bxs-user-check bg-label-danger'></i>
                <span class="text">
                    <h3>1M</h3>
                    <p>Clients</p>
                </span>
            </li>
            <li>
                <i class="bx bx-group bx-sm bg-label-success"></i>
                <span class="text">
                    <h3>$900k</h3>
                    <p>active users</p>
                </span>
            </li>
            <li>
                <i class='bx bxs-user-voice bg-label-warning'></i>
                <span class="text">
                    <h3>$900k</h3>
                    <p>pending users</p>
                </span>
            </li>
        </div>

        <div class="table-data">
            <div class="order">
                <div class="head">
                    <h3>Recent users</h3>
                    <i class="fas fa-search"></i>
                    <i class="fas fa-filter"></i>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th></th>
                            <th>User</th>
                            <th>Order Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="user_list">
                        <!-- <tr>
                            <td>
                                <div class="plus_icon">
                                    <i class='bx bxs-plus-circle'></i>
                                </div>

                            </td>
                            <td>
                                <img src="assets/img/profile.png" alt="" />
                                <p>User Name</p>
                            </td>
                            <td>07-05-2023</td>
                            <td><span class="status pending">Pending</span></td>
                            <td>
                                <button class="bg-label-success"><i class='bx bxs-edit'></i></button>
                                <button class="bg-label-danger "><i class='bx bxs-trash-alt'></i></button>
                                <button class="view_btn"><i class='bx bx-dots-vertical-rounded'></i></button>

                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="plus_icon">
                                    <i class='bx bxs-plus-circle'></i>
                                </div>
                            </td>
                            <td>
                                <img src="assets/img/profile.png" alt="" />
                                <p>User Name</p>
                            </td>
                            <td>07-05-2023</td>
                            <td><span class="status pending">Pending</span></td>
                            <td>
                                <button class="bg-label-success"><i class='bx bxs-edit'></i></button>
                                <button class="bg-label-danger "><i class='bx bxs-trash-alt'></i></button>
                                <button class="view_btn"><i class='bx bx-dots-vertical-rounded'></i></button>

                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="plus_icon">
                                    <i class='bx bxs-plus-circle'></i>
                                </div>
                            </td>
                            <td>
                                <img src="assets/img/profile.png" alt="" />
                                <p>User Name</p>
                            </td>
                            <td>07-05-2023</td>
                            <td><span class="status pending">Pending</span></td>
                            <td>
                                <button class="bg-label-success"><i class='bx bxs-edit'></i></button>
                                <button class="bg-label-danger "><i class='bx bxs-trash-alt'></i></button>
                                <button class="view_btn"><i class='bx bx-dots-vertical-rounded'></i></button>

                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="plus_icon">
                                    <i class='bx bxs-plus-circle'></i>
                                </div>
                            </td>
                            <td>
                                <img src="assets/img/profile.png" alt="" />
                                <p>User Name</p>
                            </td>
                            <td>07-05-2023</td>
                            <td><span class="status pending">Pending</span></td>
                            <td>
                                <button class="bg-label-success"><i class='bx bxs-edit'></i></button>
                                <button class="bg-label-danger "><i class='bx bxs-trash-alt'></i></button>
                                <button class="view_btn"><i class='bx bx-dots-vertical-rounded'></i></button>

                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="plus_icon">
                                    <i class='bx bxs-plus-circle'></i>
                                </div>
                            </td>
                            <td>
                                <img src="assets/img/profile.png" alt="" />
                                <p>User Name</p>
                            </td>
                            <td>07-05-2023</td>
                            <td><span class="status pending">Pending</span></td>
                            <td>
                                <button class="bg-label-success"><i class='bx bxs-edit'></i></button>
                                <button class="bg-label-danger "><i class='bx bxs-trash-alt'></i></button>
                                <button class="view_btn"><i class='bx bx-dots-vertical-rounded'></i></button>

                            </td>
                        </tr> -->

                    </tbody>
                </table>
            </div>
        </div>
    </main>
</section>

<script src="assets/js/userlist.js" type="module"></script>

<?php require_once 'layout/footer.php'; ?>
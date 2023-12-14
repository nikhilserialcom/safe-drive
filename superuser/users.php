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
                    <h3 class="total_driver"></h3>
                    <p>total drivers</p>
                </span>
            </li>
            <li>
                <i class='bx bxs-user-check bg-label-danger'></i>
                <span class="text">
                    <h3 class="reject_driver"></h3>
                    <p>reject drivers</p>
                </span>
            </li>
            <li>
                <i class="bx bx-group bx-sm bg-label-success"></i>
                <span class="text">
                    <h3 class="active_driver"></h3>
                    <p>active drivers</p>
                </span>
            </li>
            <li>
                <i class='bx bxs-user-voice bg-label-warning'></i>
                <span class="text">
                    <h3 class="pending_driver"></h3>
                    <p>pending drivers</p>
                </span>
            </li>
        </div>

        <div class="table-data">
            <div class="order">
                <div class="head">
                    <h3>driver list</h3>
                    <div class="search_box">
                        <input type="serach" class="search_input" placeholder="search...">
                        <button class="search_btn d_flex"><i class="fas fa-search"></i></button>
                        <button class="close_btn d_flex"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                    <!-- <i class="fas fa-filter"></i> -->
                </div>

                <table>
                    <thead>
                        <tr>
                            <th></th>
                            <th>Driver</th>
                            <th>Create Date</th>
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
                <!-- <div class="pegination_box">
                    <ul class="page_list">
                        <li class="page_no">previous</li>
                        <li class="page_no">1</li>
                        <li class="page_no">2</li>
                        <li class="page_no">3</li>
                        <li class="page_no">4</li>
                        <li class="page_no">5</li>
                        <li class="page_no">next</i></li>
                    </ul>
                </div> -->
            </div>
        </div>
    </main>
</section>

<script src="assets/js/userlist.js" type="module"></script>

<?php require_once 'layout/footer.php'; ?>
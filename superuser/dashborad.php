<?php require_once 'layout/header.php'; ?>

<?php require_once 'layout/sidemenu.php'; ?>
<section class="content">
    <?php require_once 'layout/navbar.php'; ?>
    <main>
        <div class="head-title">
            <div class="left">
                <h1>Dashboard</h1>
                <ul class="breadcrumb">
                    <li>
                        <a href="dashborad.php" class="active">Dashboard</a>
                    </li>
                    <i class="fas fa-chevron-right"></i>
                    <!--<li>
                        <a href="#" class="active">Home</a>
                    </li> -->
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
                            <th>driver</th>
                            <th>Creat Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="user_list">
                        <!-- <tr>
                                <td>
                                    <img src="assets/img/profile.png" alt="" />
                                    <p>User Name</p>
                                </td>
                                <td>07-05-2023</td>
                                <td><span class="status pending">Pending</span></td>
                            </tr> -->
                    </tbody>
                </table>
            </div>

            <div class="todo">
                <div class="head">
                    <h3>Todos</h3>
                    <i class="fas fa-plus"></i>
                    <!-- <i class="fas fa-filter"></i> -->
                </div>

                <ul class="todo-list">
                    <li class="not-completed">
                        <p>Todo List</p>
                        <i class="fas fa-ellipsis-vertical"></i>
                    </li>
                    <li class="not-completed">
                        <p>Todo List</p>
                        <i class="fas fa-ellipsis-vertical"></i>
                    </li>
                    <li class="completed">
                        <p>Todo List</p>
                        <i class="fas fa-ellipsis-vertical"></i>
                    </li>
                    <li class="completed">
                        <p>Todo List</p>
                        <i class="fas fa-ellipsis-vertical"></i>
                    </li>
                    <li class="completed">
                        <p>Todo List</p>
                        <i class="fas fa-ellipsis-vertical"></i>
                    </li>
                </ul>
            </div>
        </div>
    </main>
</section>

<script src="assets/js/dashborad.js"></script>
<?php require_once 'layout/footer.php'; ?>
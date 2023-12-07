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
                            <a href="#">Dashboard</a>
                        </li>
                        <i class="fas fa-chevron-right"></i>
                        <li>
                            <a href="#" class="active">Home</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="box-info">
                <li>
                    <i class="bx bxs-user bg-label-primary"></i>
                    <span class="text">
                        <h3>1.5K</h3>
                        <p>total users</p>
                    </span>
                </li>
                <li>
                    <i class="bx bxs-user-check  bg-label-danger"></i>
                    <span class="text">
                        <h3>1M</h3>
                        <p>Clients</p>
                    </span>
                </li>
                <li>
                    <i class="bx bx-group bg-label-success"></i>
                    <span class="text">
                        <h3>$900k</h3>
                        <p>Turnover</p>
                    </span>
                </li>
            </div>

            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3>Recent Orders</h3>
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
                                <th>User</th>
                                <th>Order Date</th>
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
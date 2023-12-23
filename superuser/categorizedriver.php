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
                        <a href="dashborad.php">Dashboard</a>
                    </li>
                    <i class="fas fa-chevron-right"></i>
                    <li>
                        <a href="#" class="active">user</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="table-data">
            <div class="order">
                <div class="head">
                    <h3><i class="fas fa-chevron-left back_btn"></i>driver list</h3>
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
        </div>
    </main>
</section>
<script src="assets/js/categorize.js"></script>
<?php require_once 'layout/footer.php'; ?>
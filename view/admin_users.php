<?php

use CitInterests\controllers\User;

require_once 'controllers/user.php';

$user_dao = new User();

if (isset($_POST['submit_modify_user'])) { // if modifications are submitted
    $user_dao->EditUser();
} else if (isset($_POST['submit_delete_user'])) { // if user delete is submitted
    $user_dao->DeleteUser();
} else if (isset($_POST['delete_all_posts'])) { // if delete all selected user's posts is submitted
    $user_dao->DeleteUserPosts();
}
?>

<!DOCTYPE html>
<html>

<head>
    <?php require_once 'controllers/head.php' // -- head -- 
    ?>
</head>

<body id="page-top">
    <div id="wrapper">
        <?php require_once 'controllers/navbar_admin.php' // -- navbar top --  
        ?>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <?php require_once 'controllers/navbar_top.php' // -- navbar top --  
                ?>
                <div class="container-fluid" id="main-content">
                    <h3 class="text-dark mb-4 mt-5">Gestion des utilisateurs</h3>
                    <?php
                    // display message
                    if (isset($_SESSION['error-message']) && isset($_GET['message'])) {
                        echo $_SESSION['error-message'];
                    }
                    ?>
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 font-weight-bold">Utilisateurs</p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                                <table class="table my-0" id="dataTable">
                                    <thead class="text-dark">
                                        <tr>
                                            <?php
                                            // display column names
                                            $counter = 0;
                                            foreach ($column_names as $col) {
                                                echo "<th>" . $column_names_fr[$counter] . "</th>";
                                                $counter++;
                                            }
                                            ?>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($users as $user) { ?>
                                            <form method="POST">
                                                <!-- Administration Area -->
                                                <tr onclick="ShowAdminOptions('toggle_user<?= $user['id'] ?>')" style="cursor: pointer;">
                                                    <?php
                                                    foreach ($column_names as $column) { ?>
                                                        <td>
                                                            <?php
                                                            if ($column == 'image') { ?>
                                                                <img class="rounded-circle mr-2" width="30" height="30" src="assets/img/profile_icon/<?= $user[$column] ?>" style="object-fit: cover">
                                                            <?php
                                                            } else if ($column == 'admin') {
                                                                if ($user[$column] == '1') {
                                                                    echo "<div style='color:green'>OUI</div>";
                                                                } else {
                                                                    echo "<div style='color:red'>NON</div>";
                                                                }
                                                            } else if ($column == 'banned') {
                                                                if ($user[$column] == '1') {
                                                                    echo "<div style='color:green'>OUI</div>";
                                                                } else {
                                                                    echo "<div style='color:red'>NON</div>";
                                                                }
                                                            } else if ($column == 'account_delete_requested') {
                                                                if ($user[$column] == '1') {
                                                                    echo "<div style='color:green'>OUI</div>";
                                                                } else {
                                                                    echo "<div style='color:red'>NON</div>";
                                                                }
                                                            } else {
                                                                echo $user[$column];
                                                            }
                                                            ?>
                                                        </td>
                                                    <?php
                                                    }
                                                    ?>
                                                    <div id="unclickable">
                                                        <td>
                                                            <input type="text" name="id_user" value="<?= $user['id'] ?>" hidden>
                                                            <!-- Edit User -->
                                                            <button type="submit" class="btn" name="submit_modify_user" style="box-shadow: none;"><i class="fas fa-check" style="color: green;"></i></button>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if ($_SESSION['connected_user_id'] != $user['id']) { ?>
                                                                <!-- Delete User -->
                                                                <a id="<?= $user['id'] ?>" style="box-shadow: none;" data-toggle="modal" data-target="#confirm_delete_user" class="open-modal mr-3"><i class="fas fa-times" style="color: red;"></i></a>
                                                            <?php
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <!-- Delete User Posts-->
                                                            <a id="<?= $user['id'] ?>" style="box-shadow: none;" data-toggle="modal" data-target="#confirm_delete_user_posts" class="open-modal-2"><i class="far fa-calendar-times" style="color: red;"></i></a>
                                                        </td>
                                                    </div>
                                                </tr>
                                                <tr class="table-warning">
                                                    <td>
                                                        <!-- ID -->
                                                        <div class="toggle_user<?= $user['id'] ?>" style="display:none;">
                                                            -
                                                        </div>
                                                    </td>
                                                    <td style="width:6%">
                                                        <!-- Lastname -->
                                                        <div class="toggle_user<?= $user['id'] ?>" style="display:none;">
                                                            <input type="text" class="form-control" placeholder="First name" aria-label="First name" value="<?= $user['lastname'] ?>" name="lastname_<?= $user['id'] ?>">
                                                        </div>
                                                    </td>
                                                    <td style="width:8%">
                                                        <!-- Firstname -->
                                                        <div class="toggle_user<?= $user['id'] ?>" style="display:none;">
                                                            <input type="text" class="form-control" placeholder="First name" aria-label="First name" value="<?= $user['firstname'] ?>" name="firstname_<?= $user['id'] ?>">
                                                        </div>
                                                    </td>
                                                    <td style="width:20%">
                                                        <!-- Email -->
                                                        <div class="toggle_user<?= $user['id'] ?>" style="display:none;">
                                                            <input type="text" class="form-control" placeholder="First name" aria-label="First name" value="<?= $user['email'] ?>" name="email_<?= $user['id'] ?>">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <!-- Password -->
                                                        <div class="toggle_user<?= $user['id'] ?>" style="display:none;">
                                                            -
                                                        </div>
                                                    </td>
                                                    <td style="width:7%">
                                                        <!-- Status -->
                                                        <div class="form-check toggle_user<?= $user['id'] ?>" style="display:none;">
                                                            <input class="form-check-input" type="radio" name="status_<?= $user['id'] ?>" id="rbActive<?= $user['id'] ?>" value="active" <?= ($user['status'] == 'active' ? 'checked' : '') ?>>
                                                            <label class="form-check-label" for="rbActive<?= $user['id'] ?>">
                                                                Active
                                                            </label>
                                                        </div>
                                                        <div class="form-check toggle_user<?= $user['id'] ?>" style="display:none;">
                                                            <input class="form-check-input" type="radio" name="status_<?= $user['id'] ?>" id="rbArchived<?= $user['id'] ?>" value="archived" <?= ($user['status'] == 'archived' ? 'checked' : '') ?>>
                                                            <label class="form-check-label" for="rbArchived<?= $user['id'] ?>">
                                                                Archived
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <!-- Admin -->
                                                        <div class="form-check toggle_user<?= $user['id'] ?>" style="display:none;">
                                                            <input class="form-check-input" type="checkbox" value="1" id="cbAdmin<?= $user['id'] ?>" name="is_admin_<?= $user['id'] ?>" <?= ($user['admin'] == '1' ? 'checked' : '') ?>>
                                                            <label class="form-check-label" for="cbAdmin<?= $user['id'] ?>">
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <!-- Banned -->
                                                        <div class="form-check toggle_user<?= $user['id'] ?>" style="display:none;">
                                                            <input class="form-check-input" type="checkbox" value="1" id="cbBanned<?= $user['id'] ?>" name="is_banned_<?= $user['id'] ?>" <?= ($user['banned'] == '1' ? 'checked' : '') ?>>
                                                            <label class="form-check-label" for="cbBanned<?= $user['id'] ?>">
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <!-- Image -->
                                                        <div class="toggle_user<?= $user['id'] ?>" style="display:none;">
                                                            -
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <!-- Account delete requested -->
                                                        <div class="form-check toggle_user<?= $user['id'] ?>" style="display:none;">
                                                            <input class="form-check-input" type="checkbox" value="1" id="cbRequested<?= $user['id'] ?>" name="is_requested_<?= $user['id'] ?>" <?= ($user['account_delete_requested'] == '1' ? 'checked' : '') ?>>
                                                            <label class="form-check-label" for="cbRequested<?= $user['id'] ?>">
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                    </td>
                                                    <td>
                                                    </td>
                                                    <td>
                                                    </td>
                                                </tr>
                                            </form>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-6 align-self-center">
                                    <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Showing 1 to 10 of <?= $count_users ?></p>
                                </div>
                                <div class="col-md-6">
                                    <nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">
                                        <ul class="pagination">
                                            <li class="page-item disabled"><a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
                                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                                            <li class="page-item"><a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">»</span></a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Delete User -->
            <div class="modal fade" id="confirm_delete_user" tabindex="-1" role="dialog" aria-labelledby="Modal1CenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <form method="POST">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="Modal1CenterTitle">Supprimer</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Êtes-vous sûr de vouloir supprimer cet utilisateur ?
                                <input type="hidden" id="modal_delete_user_id" name="delete_user_id">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                <button type="submit" class="btn btn-danger" name="submit_delete_user">Supprimer</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Modal delete all user posts -->
            <div class="modal fade" id="confirm_delete_user_posts" tabindex="-1" role="dialog" aria-labelledby="Modal2CenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <form method="POST">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="Modal2CenterTitle">Supprimer les publications</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Êtes-vous sûr de vouloir supprimer tous les publications de cet utilisateur ?
                                <input type="hidden" id="modal_delete_user_posts_id" name="delete_user_id">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                <button type="submit" class="btn btn-danger" name="delete_all_posts">Supprimer</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php include_once 'controllers/footer.php'?>
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/chart.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
    <script src="assets/js/theme.js"></script>
    <script src="assets/js/alert-timeout.js"></script>
    <script>
        // shows the div for admin
        function ShowAdminOptions(divId) {
            $("." + divId).toggle();

        }

        // when modal is opened, get the modal's trigger's id (=user id)
        // change the hidden input's value in the modal with the user id
        $(".open-modal").click(function(event) {
            var userId = $(this).attr('id');
            $("#modal_delete_user_id").val(userId);
        });

        $(".open-modal-2").click(function(event) {
            var userId = $(this).attr('id');
            $("#modal_delete_user_posts_id").val(userId);
        });
    </script>
</body>

</html>
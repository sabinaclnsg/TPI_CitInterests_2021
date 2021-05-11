<?php
require_once 'controllers/admin_users_controller.php';
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Table - Brand</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="assets/css/custom.css">
    <!-- fade animation on load -->
    <link rel="stylesheet" href="assets/css/load-animation.css">
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
                            <div class="row">
                                <div class="col-md-6 text-nowrap">
                                    <div id="dataTable_length" class="dataTables_length" aria-controls="dataTable"><label>Show&nbsp;<select class="form-control form-control-sm custom-select custom-select-sm">
                                                <option value="10" selected="">10</option>
                                                <option value="25">25</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                            </select>&nbsp;</label></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="text-md-right dataTables_filter" id="dataTable_filter"><label><input type="search" class="form-control form-control-sm" aria-controls="dataTable" placeholder="Search"></label></div>
                                </div>
                            </div>
                            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                                <table class="table my-0" id="dataTable">
                                    <thead>
                                        <tr>
                                            <?php
                                            // display column names
                                            foreach ($column_names as $col) {
                                                echo "<th>$col</th>";
                                            }
                                            ?>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($users as $user) { ?>
                                            <form method="POST">
                                                <tr onclick="ShowAdminOptions('toggle_user<?= $user['id'] ?>')" style="cursor: pointer;">
                                                    <?php
                                                    foreach ($column_names as $column) { ?>
                                                        <td>
                                                            <?php
                                                            if ($column == 'image') { ?>
                                                                <img class="rounded-circle mr-2" width="30" height="30" src="assets/img/profile_icon/<?= $user[$column] ?>">
                                                            <?php
                                                            } else {
                                                                echo $user[$column];
                                                            }
                                                            ?>
                                                        </td>
                                                    <?php
                                                    }
                                                    ?>

                                                    <td id="unclickable">
                                                        <input type="text" name="id_user" value="<?= $user['id'] ?>" hidden>
                                                        <!-- Edit User -->
                                                        <button type="submit" class="btn" name="submit_modify_user" style="box-shadow: none;"><i class="fas fa-user-check" style="color: green;"></i></button>
                                                        <?php
                                                        if (!$_SESSION['connected_user_id'] != $user['id']) { ?>
                                                            <!-- Delete User -->
                                                            <a id="<?= $user['id'] ?>" style="box-shadow: none;" data-toggle="modal" data-target="#confirm_delete_user" class="open-modal mr-3"><i class="fas fa-user-minus" style="color: red;"></i></a>
                                                        <?php
                                                        }
                                                        ?>
                                                        <!-- Delete User Posts-->
                                                        <a id="<?= $user['id'] ?>" style="box-shadow: none;" data-toggle="modal" data-target="#confirm_delete_user_posts" class="open-modal-2"><i class="fas fa-trash-alt" style="color: red;"></i></a>
                                                    </td>
                                                </tr>
                                                <tr class="table-warning">
                                                    <td>
                                                        <!-- ID -->
                                                        <div class="toggle_user<?= $user['id'] ?>" style="display:none;">
                                                            -
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <!-- Lastname -->
                                                        <div class="toggle_user<?= $user['id'] ?>" style="display:none;">
                                                            <input type="text" class="form-control" placeholder="First name" aria-label="First name" value="<?= $user['lastname'] ?>" name="lastname_<?= $user['id'] ?>">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <!-- Firstname -->
                                                        <div class="toggle_user<?= $user['id'] ?>" style="display:none;">
                                                            <input type="text" class="form-control" placeholder="First name" aria-label="First name" value="<?= $user['firstname'] ?>" name="firstname_<?= $user['id'] ?>">
                                                        </div>
                                                    </td>
                                                    <td>
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
                                                    <td>
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
                                                                Admin
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <!-- Banned -->
                                                        <div class="form-check toggle_user<?= $user['id'] ?>" style="display:none;">
                                                            <input class="form-check-input" type="checkbox" value="1" id="cbBanned<?= $user['id'] ?>" name="is_banned_<?= $user['id'] ?>" <?= ($user['banned'] == '1' ? 'checked' : '') ?>>
                                                            <label class="form-check-label" for="cbBanned<?= $user['id'] ?>">
                                                                Banned
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
                                                                Requested
                                                            </label>
                                                        </div>
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
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright"><span>Copyright © Brand 2021</span></div>
                </div>
            </footer>
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
<?php
require_once 'controllers/admin_categories_controller.php';
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
                    <h3 class="text-dark mb-4 mt-5">Gestion des centres d'intérêt</h3>
                    <?php
                    // display message
                    if (isset($_SESSION['error-message']) && isset($_GET['message'])) {
                        echo $_SESSION['error-message'];
                    }
                    ?>
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 font-weight-bold">Centres d'intérêt</p>
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
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($sights as $sight) { ?>
                                            <form method="POST" enctype="multipart/form-data">
                                                <tr onclick="ShowAdminOptions('toggle_sight<?= $sight['id'] ?>')" style="cursor: pointer;">
                                                    <?php
                                                    foreach ($column_names as $column) { ?>
                                                        <td>
                                                            <?php
                                                            if ($column == 'image') { ?>
                                                                <img class="mr-2" width="50" height="50" src="assets/img/sights/<?= $sight[$column] ?>" style="object-fit: cover">
                                                            <?php
                                                            } else if ($column == 'canton') {
                                                                echo "<div style='width:85px'>$sight[$column]</div>";
                                                            } else if ($column == 'description') {
                                                                echo "<div class='col-9 text-truncate'  style='width:350px'>$sight[$column]</div>";
                                                            } else if ($column == 'price') {
                                                                echo "<div class='text-center' style='width:20px'>$sight[$column]</div>";
                                                            } else if ($column == 'validated') {
                                                                if ($sight[$column] == '1') {
                                                                    echo "<div class='text-center' style='color:green'>OUI</div>";
                                                                } else {
                                                                    echo "<div class='text-center' style='color:red'>NON</div>";
                                                                }
                                                            } else if ($column == 'sights_delete_requested') {
                                                                if ($sight[$column] == '1') {
                                                                    echo "<div class='text-center' style='color:green'>OUI</div>";
                                                                } else {
                                                                    echo "<div class='text-center' style='color:red'>NON</div>";
                                                                }
                                                            } else if ($column == 'sight_showed') {
                                                                if ($sight[$column] == '1') {
                                                                    echo "<div class='text-center' style='color:green'>OUI</div>";
                                                                } else {
                                                                    echo "<div class='text-center' style='color:red'>NON</div>";
                                                                }
                                                            } else {
                                                                echo $sight[$column];
                                                            }
                                                            ?>
                                                        </td>
                                                    <?php
                                                    }
                                                    ?>

                                                    <td id="unclickable" class="">
                                                        <input type="text" name="id_sight" value="<?= $sight['id'] ?>" hidden>
                                                        <!-- Edit sight -->
                                                        <button type="submit" class="btn" name="submit_modify_sight" style="box-shadow: none;"><i class="fas fa-check" style="color: green;"></i></button>
                                                    </td>
                                                </tr>
                                                <tr class="table-warning">
                                                    <td style="width: 5%" colspan="6">
                                                        <!-- Age -->
                                                        <div class="toggle_sight<?= $sight['id'] ?>" style="display:none;">
                                                            <div class="btn-group-toggle col-lg-10 col-md-12" data-toggle="buttons">
                                                                <?php
                                                                for ($i = 0; $i < $age_limits_count; $i++) {
                                                                ?>
                                                                        <label class="btn btn-secondary active px-1 my-1" style="height:29px; font-size:15px; padding:2px;">
                                                                            <input type="checkbox" autocomplete="off" name="age_limit[]" value="<?= $age_limits[$i]['name'] ?>"> <?= $age_limits[$i]['name'] ?>
                                                                        </label>
                                                                <?php
                                                                    
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td style="width: 10%" colspan="6">
                                                        <!-- Categories -->
                                                        <div class="toggle_sight<?= $sight['id'] ?>" style="display:none;">
                                                            <div class="btn-group-toggle col-lg-10 col-md-12" data-toggle="buttons">
                                                                <?php
                                                                for ($i = 0; $i < $categories_count; $i++) { ?>
                                                                    <label class="btn btn-secondary active btn-tag px-1 my-1" style="height:29px; font-size:15px; padding:2px;">
                                                                        <input type="checkbox" autocomplete="off" name="category[]" value="<?= $categories[$i]['name'] ?>"> <?= $categories[$i]['name'] ?>
                                                                    </label>
                                                                <?php
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
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
                                    <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Showing 1 to 10 of <?= $count_sights ?></p>
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

            <!-- Modal Delete sight -->
            <div class="modal fade" id="confirm_delete_sight" tabindex="-1" role="dialog" aria-labelledby="Modal1CenterTitle" aria-hidden="true">
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
                                Êtes-vous sûr de vouloir supprimer ce centre d'intérêt ?
                                <input type="hidden" id="modal_delete_sight_id" name="delete_sight_id">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                <button type="submit" class="btn btn-danger" name="submit_delete_sight">Supprimer</button>
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

        // when modal is opened, get the modal's trigger's id (=sight id)
        // change the hidden input's value in the modal with the sight id
        $(".open-modal").click(function(event) {
            var sightId = $(this).attr('id');
            $("#modal_delete_sight_id").val(sightId);
        });

        $(".open-modal-2").click(function(event) {
            var sightId = $(this).attr('id');
            $("#modal_delete_sight_posts_id").val(sightId);
        });
    </script>
</body>

</html>
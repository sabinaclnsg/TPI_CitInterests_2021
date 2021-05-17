<?php
require_once 'controllers/admin_sights_controller.php';
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
                                            <th></th>
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
                                                    <td>
                                                        <!-- Edit sight -->
                                                        <button type="submit" class="btn" name="submit_modify_sight" style="box-shadow: none;"><i class="fas fa-check" style="color: green;"></i></button>
                                                    </td>
                                                    <td>
                                                        <!-- Delete sight -->
                                                        <a id="<?= $sight['id'] ?>" style="box-shadow: none;" data-toggle="modal" data-target="#confirm_delete_sight" class="open-modal mr-3"><i class="fas fa-minus" style="color: red;"></i></a>
                                                    </td>
                                                    </td>
                                                </tr>
                                                <tr class="table-warning">
                                                    <td style="width: 5%">
                                                        <!-- ID -->
                                                        <div class="toggle_sight<?= $sight['id'] ?>" style="display:none;">
                                                            #
                                                        </div>
                                                    </td>
                                                    <td style="width: 10%">
                                                        <!-- Name -->
                                                        <div class="toggle_sight<?= $sight['id'] ?>" style="display:none;">
                                                            <input type="text" class="form-control" placeholder="First name" aria-label="Name" value="<?= $sight['name'] ?>" name="name_<?= $sight['id'] ?>">
                                                        </div>
                                                    </td>
                                                    <td style="width: 5%">
                                                        <!-- Canton -->
                                                        <div class="toggle_sight<?= $sight['id'] ?>" style="display:none; width: 30px; margin:0">
                                                            <select class="form-select" aria-label="Canton" name="canton_<?= $sight['id'] ?>">
                                                                <option selected>Cantons :</option>
                                                                <?php
                                                                foreach ($cantons as $canton) {
                                                                    if ($canton == $sight['canton']) {
                                                                        echo "<option value=\"$canton\" selected>$canton</option>";
                                                                    } else {
                                                                        echo "<option value=\"$canton\">$canton</option>";
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td style="width: 15%">
                                                        <!-- Adress -->
                                                        <div class="toggle_sight<?= $sight['id'] ?>" style="display:none;">
                                                            <input type="text" class="form-control" placeholder="Adress" aria-label="Adress" value="<?= $sight['adress'] ?>" name="adress_<?= $sight['id'] ?>">
                                                        </div>
                                                    </td>
                                                    <td style="width: 10%">
                                                        <!-- Description -->
                                                        <div class="toggle_sight<?= $sight['id'] ?>" style="display:none; width: 300px; margin:0">
                                                            <textarea class="form-control" placeholder="Description" aria-label="Description" name="description_<?= $sight['id'] ?>"><?= $sight['description'] ?></textarea>
                                                        </div>
                                                    </td>
                                                    <td style="width: 5%">
                                                        <!-- Price -->
                                                        <div class="toggle_sight<?= $sight['id'] ?>" style="display:none; width: 20px; margin:0">
                                                            <input style="width: 50px;" type="number" class="form-control" placeholder="Price" aria-label="Price" value="<?= $sight['price'] ?>" name="price_<?= $sight['id'] ?>">
                                                        </div>
                                                    </td>
                                                    <td style="width: 10%">
                                                        <!-- Image -->
                                                        <div class="form-check toggle_sight<?= $sight['id'] ?>" style="display:none;">
                                                            <div class="image-upload">
                                                                <label for="file-input<?= $sight['id'] ?>">
                                                                    <i class="fas fa-images" style="cursor:pointer;color:blue"></i>
                                                                </label>
                                                                <input id="file-input<?= $sight['id'] ?>" type="file" name="image_<?= $sight['id'] ?>" accept="image/*" hidden />
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td style="width: 5%">
                                                        <!-- Validated -->
                                                        <div class="form-check toggle_sight<?= $sight['id'] ?>" style="display:none;">
                                                            <input class="form-check-input" type="checkbox" value="1" id="cbValidated<?= $sight['id'] ?>" name="is_validated_<?= $sight['id'] ?>" <?= ($sight['validated'] == '1' ? 'checked' : '') ?>>
                                                        </div>
                                                    </td>
                                                    <td style="width: 5%">
                                                        <!-- Delete Requested -->
                                                        <div class="form-check toggle_sight<?= $sight['id'] ?>" style="display:none;">
                                                            <input class="form-check-input" type="checkbox" value="1" id="cbDeleteRequested<?= $sight['id'] ?>" name="is_requested_<?= $sight['id'] ?>" <?= ($sight['sights_delete_requested'] == '1' ? 'checked' : '') ?>>
                                                        </div>
                                                    </td>
                                                    <td style="width: 5%">
                                                        <!-- Showed -->
                                                        <div class="form-check toggle_sight<?= $sight['id'] ?>" style="display:none;">
                                                            <input class="form-check-input" type="checkbox" value="1" id="cbShowed<?= $sight['id'] ?>" name="is_showed_<?= $sight['id'] ?>" <?= ($sight['sight_showed'] == '1' ? 'checked' : '') ?>>
                                                        </div>
                                                    </td>
                                                    <td style="width: 10%">
                                                        <!-- ID User -->
                                                        <div class="form-check toggle_sight<?= $sight['id'] ?>" style="display:none; width:100px;margin:0">
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
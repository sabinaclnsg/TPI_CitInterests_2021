<?php

use CitInterests\models\SightsDAO;
use CitInterests\models\UserDAO;

require_once 'controllers/filter_controller.php';
require_once 'controllers/sights_controller.php';


?>
<!DOCTYPE html>
<html>

<head>
<?php require_once 'controllers/head.php' // -- head -- 
?>
    <!-- Google Captcha -->
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body>

    <div id="wrapper">
        <div class="d-flex flex-column" id="content-wrapper">
            <?php
            require_once 'controllers/navbar_top.php';
            ?>
            <div class="container pb-5" id="main-content">
                <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent">
                        <li class="breadcrumb-item"><a href="index.php?page=homepage">Page d'accueil</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Proposer un centre d'intérêt</li>
                    </ol>
                </nav>
                <div class="row justify-content-center d-flex h-75 align-items-center">

                    <div class="col-md-9 col-lg-12 col-xl-10">
                        <?php
                        if (isset($_SESSION['error-message']) && isset($_GET['message'])) {
                            echo $_SESSION['error-message'];
                        }
                        ?>
                        <section class="py-5 text-center container">
                            <div class="row py-lg-5">
                                <div class="col-lg-6 col-md-8 mx-auto">
                                    <h1 class="fw-light">Proposer</h1>
                                    <p class="lead text-muted">La proposition doit être validé par un admin avant d'être publié.</p>
                                </div>
                            </div>
                            <hr>
                        </section>
                        <form method="POST" enctype="multipart/form-data">
                            <div class="form-row">
                                <!-- NAME -->
                                <div class="form-group col-lg-10">
                                    <label for="inputName">Nom du centre d'intérêt</label>
                                    <input type="text" name="sights_name" class="form-control" id="inputName" placeholder="Nom">
                                </div>
                                <!-- PRICE -->
                                <div class="form-group col-lg-2 input-group">
                                    <label for="inputPrice" style="width: 100%;">Prix</label>
                                    <input type="number" class="form-control" aria-label="" name="price" id="inputPrice" min="1">
                                    <div class="input-group-append">
                                        <span class="input-group-text">CHF</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group float-right">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="priceFree" name="price_free">
                                    <label class="form-check-label" for="priceFree">
                                        Gratuit
                                    </label>
                                </div>
                            </div>
                            <!-- DESCRIPTION -->
                            <div class="form-group">
                                <label for="inputDescription">Description</label>
                                <textarea class="form-control" id="inputDescription" rows="3" name="description"></textarea>
                            </div>
                            <div class="form-row">
                                <!-- ADRESS -->
                                <div class="form-group col-lg-6">
                                    <label for="inputAddress">Addresse</label>
                                    <input type="text" class="form-control" id="inputAddress" placeholder="Rue, numéro" name="adress">
                                </div>
                                <!-- CANTON -->
                                <div class="form-group col-lg-6">
                                    <label for="inputCanton">Canton</label>
                                    <select id="inputCanton" class="form-control" name="canton">
                                        <option selected>Choisir un canton...</option>
                                        <?php
                                        for ($i = 0; $i < $cantons_count; $i++) { ?>
                                            <option value="<?= $cantons[$i] ?>"><?= $cantons[$i] ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <!-- IMG INPUT -->
                            <div class="form-group mb-5">
                                <label for="inputImage" class="form-label">Choisir l'image</label>
                                <input class="form-control" type="file" id="inputImage" name="image_file" accept="image/*">
                            </div>
                            <hr>
                            <div class="form-row">
                                <!-- FULL HOURS -->
                                <div class="form-group col-md-6">
                                    <h3><b>Horaires : </b></h3>
                                </div>
                                <div class="form-group col-md-6 text-right">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1" id="open24h" name="open_24h">
                                        <label class="form-check-label" for="open24h">
                                            Ouvert h24
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!-- OPENING/CLOSING HOURS -->
                            <?php
                            for ($i = 0; $i < 7; $i++) { ?>
                                <div class="row full_hours">
                                    <div class="md-form mb-1 col-2 text-right">
                                        <b><?= $days[$i + 7] ?></b>
                                    </div>
                                    <div class="md-form mb-1 col-4">
                                        <input type="time" id="input_opening_hours_<?= $days[$i] ?>" class="form-control" name="<?= $days[$i] ?>_opening_hours" value="00:00" min="00:00">
                                    </div>
                                    <div class="md-form mb-1 col-1 text-center">
                                        <div>-</div>
                                    </div>
                                    <div class="md-form mb-1 col-4">
                                        <input type="time" id="input_closing_hours_<?= $days[$i] ?>" class="form-control" name="<?= $days[$i] ?>_closing_hours" value="00:00" min="00:00">
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                            <hr>
                            <div class="row mt-5">
                                <h5 class="col-lg-2 col-md-12"><b>Tranche âge :</b></h5>
                                <div class="btn-group-toggle col-lg-10 col-md-12" data-toggle="buttons">
                                    <?php
                                    for ($i = 0; $i < $age_limits_count; $i++) { ?>
                                        <label class="btn btn-secondary active px-1 my-1" style="height:29px; font-size:15px; padding:2px;">
                                            <input type="checkbox" autocomplete="off" name="age_limit[]" value="<?= $age_limits[$i]['name'] ?>"> <?= $age_limits[$i]['name'] ?>
                                        </label>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="row">
                                <h5 class="col-lg-2 col-md-12"><b>Catégories :&nbsp;</b></h5>
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
                            <div class="row">
                                <button type="submit" class="btn btn-yellow col-md-6 mx-auto my-5" name="submit">Envoyer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright"><span>Copyright © Brand 2021</span></div>
                </div>
            </footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
    <script src="assets/js/theme.js"></script>

    <script src="assets/js/alert-timeout.js"></script>

    <script>
        // verifies if "Price_free" checkbox is checked
        // disables "price" input
        $('#priceFree').on('change', function() {
            if ($('#priceFree').prop('checked')) {
                $('#inputPrice').prop('disabled', true);
                $('#inputPrice').val('');
            } else {
                $('#inputPrice').prop('disabled', false);
            }
        });

        $('#open24h').on('change', function() {
            if ($('#open24h').prop('checked')) {
                $('input[type=time]').prop('disabled', true);
                $('input[type=time]').val('00:00');
            } else {
                $('input[type=time]').prop('disabled', false);
            }
        });
    </script>
</body>

</html>
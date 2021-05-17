<?php
require_once './models/sightsDAO.php';
require_once './controllers/filter_controller.php';

use CitInterests\controllers\Filter;
use CitInterests\models\SightsDAO;

$sights_dao = new SightsDAO();

$count_validated_sights = $sights_dao->CountValidatedSightsAmount()[0];
$sights = $sights_dao->GetValidatedSights();

$result = "";
$sights_dao->ResetSightShow();

?>

<!DOCTYPE html>
<html>

<head>
<?php require_once 'controllers/head.php' // -- head -- 
?>
</head>

<body id="page-top">
    <div id="wrapper">
        <div class="d-flex flex-column" id="content-wrapper">
            <?php require_once 'controllers/navbar_top.php' // -- navbar top -- 
            ?>
            <div id="main-content">
                <section class="py-5 text-center container">
                    <?php
                    if (isset($_SESSION['error-message']) && isset($_GET['message'])) {
                        echo $_SESSION['error-message'];
                    }
                    ?>
                    <div class="row py-lg-5">
                        <div class="col-lg-6 col-md-8 mx-auto">
                            <h1 class="font-weight-bold">Centres d'intérêt</h1>
                            <p class="lead text-muted">Something short and leading about the collection below—its contents, the creator, etc. Make it short and sweet, but not too short so folks don’t simply skip over it entirely.</p>
                            <p>
                                <a href="index.php?page=create_sights" class="btn btn-yellow my-2">Proposer un centre d'intérêt</a>
                            </p>
                        </div>
                    </div>
                    <?php require_once 'controllers/filter.php' // -- navbar top -- 
                    ?>
                    <hr>
                </section>
                <div class="container-fluid">
                    <form method="POST" class="form-inline d-none d-sm-inline-block ml-5 my-2 my-md-0 mw-100 navbar-search" style="width: 500px;">
                        <div class="input-group"><input id="search" class="bg-light form-control border small" type="text" name="search" placeholder="Search for ..." <?= ($_GET['page'] != 'homepage' ? 'hidden' : '') ?>>
                        </div>
                    </form>
                </div>
                <div class="row row-cols-1 row-cols-md-4 g-4 m-0 m-md-5" id="output">
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
        $(document).ready(function() {
            // checks all category checkbox when parent is checked
            $('#parent').on('change', function() {
                $('.child').prop('checked', $(this).prop('checked'));
            });

            GetData("cantons[]");
            GetData("categories[]");
            GetData("age_limits[]");
            GetData("budgets[]");
            GetSearchData();

            $.ajax({
                url: "controllers/get_filtered_sights.php",
                method: "POST",
                data: {
                    filter_data: 'empty'
                },
                success: function(data) {
                    $('#output').html(data);
                }
            });

            function GetSearchData() {
                $('#search').on('input', function() {
                    var search_input = $('#search').val();

                    $.ajax({
                        url: "controllers/get_filtered_sights.php",
                        method: "POST",
                        data: {
                            search_data: search_input
                        },
                        success: function(data) {
                            $('#output').html(data);
                        }
                    });
                });
            }

            function GetData(inputName) {

                $('input[name="' + inputName + '"]').on('change', function() {
                    var filter_list = [];
                    $(":checkbox").each(function() {
                        var ischecked = $(this).is(":checked");
                        if (ischecked) {
                            filter_list.push($(this).val());
                        }
                    });
                    $.ajax({
                        url: "controllers/get_filtered_sights.php",
                        method: "POST",
                        data: {
                            filter_data: filter_list
                        },
                        success: function(data) {
                            $('#output').html(data);
                        }
                    });
                });

            }
        });
    </script>
</body>

</html>
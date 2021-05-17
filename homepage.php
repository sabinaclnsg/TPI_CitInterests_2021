<?php
require_once './models/sightsDAO.php';

use CitInterests\models\SightsDAO;

$count_validated_sights = SightsDAO::CountValidatedSightsAmount()[0];
$sights = SightsDAO::GetValidatedSights();

//var_dump(SightsDAO::GetCategoryIdByName('Place de pique-nique')[0]);
?>

<!DOCTYPE html>
<html>

<?php require_once 'controllers/head.php' // -- head -- 
?>

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
                <div class="row row-cols-1 row-cols-md-4 g-4 m-0 m-md-5" id="output">
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
        $(document).ready(function() {
            // checks all category checkbox when parent is checked
            $('#parent').on('change', function() {
                $('.child').prop('checked', $(this).prop('checked'));
            });

            GetData("cantons[]");
            GetData("categories[]");
            GetData("age_limits[]");
            GetData("budgets[]");

            $.ajax({
                url: "controllers/get_data_ajax.php",
                method: "POST",
                data: {
                    filter_data: 'empty'
                },
                success: function(data) {
                    $('#output').html(data);
                }
            });

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
                        url: "controllers/get_data_ajax.php",
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
<?php
require_once 'filter_controller.php';
?>
<div class="container">
    <button type="button" class="btn shadow-none" data-toggle="collapse" data-target="#filter-panel">
        <span class="glyphicon glyphicon-cog"></span> Filtrer par <i class="fas fa-angle-down"></i>
    </button>
    <div id="filter-panel" class="collapse filter-panel">
        <div class="panel panel-default mt-3">
            <div class="panel-body">
                <form class="form row text-left" role="form">
                    <!-- CANTON -->
                    <div class="form-group col-3">
                        <label class="filter-col" style="margin-right:0;" for="pref-perpage">Cantons : </label>

                        <?php for ($i = 0; $i < $cantons_count; $i++) { // start for (canton) 
                        ?>
                            <div class="form-check">
                                <input class="form-check-input" name="1" type="checkbox" value="<?= $categories[$i] ?>" id="category<?= $cantons[$i] ?>">
                                <label class="form-check-label" for="category<?= $categories[$i] ?>">
                                    <?= $categories[$i]['name'] ?>
                                </label>
                            </div>
                        <?php
                        } // end for (canton)
                        ?>

                    </div> <!-- form group [rows] -->
                    <!-- CATÉGORIE -->
                    <div class="form-group col-3">
                        <label class="filter-col" style="margin-right:0;" for="pref-perpage">Catégories : </label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="parent">
                            <label class="form-check-label" for="categoryAll">
                                Tout
                            </label>
                        </div>
                        <?php for ($i = 0; $i < $categories_count; $i++) { // start for (categories) 
                        ?>
                            <div class="form-check">
                                <input class="form-check-input child" name="1" type="checkbox" value="<?= $categories[$i]['name'] ?>" id="category<?= $categories[$i]['name'] ?>">
                                <label class="form-check-label" for="category<?= $categories[$i]['name'] ?>">
                                    <?= $categories[$i]['name'] ?>
                                </label>
                            </div>
                        <?php
                        } // end for (categories)
                        ?>
                    </div> <!-- form group [rows] -->
                    <!-- ÂGE -->
                    <div class="form-group col-3">
                        <label class="filter-col" style="margin-right:0;" for="pref-perpage">Âge : </label>
                        <?php for ($i = 0; $i < $age_limits_count; $i++) { // start for (age limit) 
                        ?>
                            <div class="form-check">
                                <input class="form-check-input" name="1" type="checkbox" value="<?= $categories[$i]['name'] ?>" id="category<?= $age_limits[$i]['name'] ?>">
                                <label class="form-check-label" for="category<?= $categories[$i]['name'] ?>">
                                    <?= $age_limits[$i]['name'] ?>
                                </label>
                            </div>
                        <?php
                        } // end for (age limit)
                        ?>
                    </div> <!-- form group [rows] -->
                    <!-- BUDGET -->
                    <div class="form-group col-3">
                        <label class="filter-col" style="margin-right:0;" for="pref-perpage">Budget : </label>
                        <?php for ($i = 0; $i < $budget_count; $i++) { // start for (age limit) 
                        ?>
                            <div class="form-check">
                                <input class="form-check-input" name="1" type="checkbox" value="<?= $categories[$i]['name'] ?>" id="category<?= $budget[$i] ?>">
                                <label class="form-check-label" for="category<?= $budget[$i] ?>">
                                    <?= $budget[$i] ?>
                                </label>
                            </div>
                        <?php
                        } // end for (age limit)
                        ?>
                    </div> <!-- form group [rows] -->
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // checks all category checkbox when parent is checked
    $(function() {
        $('#parent').on('change', function() {
            $('.child').prop('checked', $(this).prop('checked'));
        });
    });
</script>
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
                                <input class="form-check-input" name="cantons[]" type="checkbox" value="<?= $cantons[$i] ?>" id="canton_<?= $cantons[$i] ?>">
                                <label class="form-check-label" for="canton_<?= $cantons[$i] ?>">
                                    <?= $cantons[$i] ?>
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
                            <input class="form-check-input" type="checkbox" value="" id="parent" name="categories[]">
                            <label class="form-check-label" for="parent">
                                Tout
                            </label>
                        </div>
                        <?php for ($i = 0; $i < $categories_count; $i++) { // start for (categories) 
                        ?>
                            <div class="form-check">
                                <input class="form-check-input child" name="categories[]" type="checkbox" value="<?= $categories[$i]['name'] ?>" id="category_<?= $categories[$i]['name'] ?>">
                                <label class="form-check-label" for="category_<?= $categories[$i]['name'] ?>">
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
                                <input class="form-check-input" name="age_limits[]" type="checkbox" value="<?= $age_limits[$i]['name'] ?>" id="age_limit_<?= $age_limits[$i]['name'] ?>">
                                <label class="form-check-label" for="age_limit_<?= $age_limits[$i]['name'] ?>">
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
                                <input class="form-check-input" name="budgets[]" type="checkbox" value="<?= $budget[$i] ?>" id="budget_<?= $budget[$i] ?>">
                                <label class="form-check-label" for="budget_<?= $budget[$i] ?>">
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

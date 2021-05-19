<?php
if (isset($_GET['page'])) {
    if ($_GET['page'] != 'homepage' && !str_contains($_GET['page'], 'admin') && $_GET['page'] != 'create_sights') {
        $sticky = 'fixed-bottom';
    } else {
        $sticky = '';
    }
}
?>
<footer class="bg-white sticky-footer <?=$sticky?>">
    <div class="container my-auto">
        <div class="text-center my-auto copyright"><span>Copyright © CitInterests 2021</span></div>
    </div>
</footer>
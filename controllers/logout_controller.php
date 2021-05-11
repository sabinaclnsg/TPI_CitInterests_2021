<?php
if (isset($_POST['logout'])) {
    $_SESSION['connected'] = false;
    $_SESSION['connected_user_id'] = 0;
}
?>
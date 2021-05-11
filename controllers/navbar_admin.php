<nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0">
    <div class="container-fluid d-flex flex-column p-0">
        <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="index.php?page=homepage">
            <div class="sidebar-brand-icon"><img class="img-profile" style="width: 50px; height: 50px;" src="assets/img/other/LogoCitInterests.svg"></div>
            <div class="sidebar-brand-text mx-3"><span>CitInterests</span></div>
        </a>
        <hr class="sidebar-divider my-0">
        <ul class="navbar-nav text-light" id="accordionSidebar">
            <li class="nav-item"><a class="nav-link <?=($_GET['page'] == 'admin' ? 'active' : '')?>" href="index.php?page=admin"><i class="fas fa-table"></i><span>Administration</span></a></li>
            <li class="nav-item"><a class="nav-link <?=($_GET['page'] == 'admin_users' ? 'active' : '')?>" href="index.php?page=admin_users"><i class="fas fa-user"></i><span>Utilisateurs</span></a></li>
            <li class="nav-item"><a class="nav-link <?=($_GET['page'] == 'admin_sights' ? 'active' : '')?>" href="index.php?page=admin_sights"><i class="fas fa-tachometer-alt"></i><span>Centres d'intérêt</span></a></li>
        </ul>
        <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button></div>
    </div>
</nav>
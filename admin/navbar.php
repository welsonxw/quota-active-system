<?php
// admin/navbar.php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Quota System Admin</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'dashboard.php' ? 'active' : '' ?>" href="dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'view_applications.php' ? 'active' : '' ?>" href="view_applications.php">View Applications</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'rankings.php' ? 'active' : '' ?>" href="rankings.php">Rankings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'edit_criteria.php' ? 'active' : '' ?>" href="edit_criteria.php">Edit Criteria</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'manage_questions.php' ? 'active' : '' ?>" href="manage_questions.php">Edit/Manage Questions</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
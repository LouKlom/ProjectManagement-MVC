<?php ob_start(); ?>

<h1>Admin Pannel</h1>

<ul>
    <li><a href="/index.php?route=admin&action=listUsers">User Management</a></li>
    </ul>

<?php $content = ob_get_clean(); ?>
<?php include '../views/layout.php'; ?>
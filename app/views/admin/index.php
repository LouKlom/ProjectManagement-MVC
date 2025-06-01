<?php ob_start(); ?>

<h1>Admin Pannel</h1>

<ul>
    <li><a href="/index.php?route=admin&action=listUsers">User Management</a></li>
    <li><a href="/?route=admin&action=viewActivityLogs">Voir l'historique d'activité</a></li> 
</ul>

<?php $content = ob_get_clean(); ?>
<?php include '../views/layout.php'; ?>
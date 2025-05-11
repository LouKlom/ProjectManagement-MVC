<?php ob_start(); ?>

<h1>Profile</h1>

<?php if ($user): ?>
    <p><strong>Username :</strong> <?= htmlspecialchars($user['username']); ?></p>
    <p><strong>Role :</strong> <?= htmlspecialchars($user['role']); ?></p>

    <h2>Actions</h2>
    <ul>
        <li><a href="#">Edit password</a></li>
        </ul>
<?php else: ?>
    <p>User not found.</p>
<?php endif; ?>

<?php $content = ob_get_clean(); ?>
<?php include '../views/layout.php'; ?>
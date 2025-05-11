<?php ob_start(); ?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1em;">
    <h1>User Management</h1>
    <a href="/public/index.php?route=admin&action=index" class="button-secondary">Back to Administration Pannel</a>
</div>

<?php if (!empty($users)): ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>UserName</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['id']); ?></td>
                    <td><?= htmlspecialchars($user['username']); ?></td>
                    <td><?= htmlspecialchars($user['role']); ?></td>
                    <td>
                        <a href="/public/index.php?route=admin&action=editUser&id=<?= $user['id']; ?>">Edit</a>
                        <?php if ($user['id'] != $_SESSION['user_id']): ?>
                            <a href="/public/index.php?route=admin&action=deleteUser&id=<?= $user['id']; ?>" onclick="return confirm('Are you sure you want to delete this user ?');">Delete</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No user found.</p>
<?php endif; ?>

<?php $content = ob_get_clean(); ?>
<?php include '../views/layout.php'; ?>
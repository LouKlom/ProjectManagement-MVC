<?php ob_start(); ?>

<h1>Edit User</h1>

<?php if ($user): ?>
    <form method="post" action="/index.php?route=admin&action=updateUser&id=<?= htmlspecialchars($user['id']); ?>">
        <div>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['username']); ?>" required>
        </div>
        <div>
            <label for="role">Role:</label>
            <select id="role" name="role">
                <option value="admin" <?= ($user['ADMIN'] === 'ADMIN') ? 'selected' : ''; ?>>Admin</option>
                <option value="user" <?= ($user['role'] === 'user') ? 'selected' : ''; ?>>User</option>
            </select>
        </div>
        <button type="submit">Save</button>
    </form>
    <p><a href="/index.php?route=admin&action=listUsers">Back</a></p>
<?php else: ?>
    <p>User not found.</p>
<?php endif; ?>

<?php $content = ob_get_clean(); ?>
<?php include '../views/layout.php'; ?>
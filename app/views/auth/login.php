<?php ob_start(); ?>

<h1>Sign In</h1>

<?php if (isset($error)): ?>
    <p style="color: red;"><?= htmlspecialchars($error); ?></p>
<?php endif; ?>

<form method="post" action="index.php?route=auth&action=login">
    <div>
        <label for="username">UserName:</label>
        <input type="text" id="username" name="username" required>
    </div>
    <div>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
    </div>
    <button type="submit">Sign In</button>
</form>

<p>No account? <a href="index.php?route=auth&action=register">Sign Up</a></p>

<?php $content = ob_get_clean() ?>
<?php include __DIR__ . '/../layout.php'; ?>
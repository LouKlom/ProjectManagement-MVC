<?php ob_start(); ?>

<h1>Sign Up</h1>

<?php if (isset($error)): ?>
    <p style="color: red;"><?= htmlspecialchars($error); ?></p>
<?php endif; ?>

<form method="post" action="/public/index.php?route=auth&action=register">
    <div>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
    </div>
    <div>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
    </div>
    <div>
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirmPassword" name="confirmPassword" required>
    </div>
    <button type="submit">Sign up</button>
</form>

<p>Have an account? <a href="/public/index.php?route=auth&action=login">Sign In</a></p>

<?php $content = ob_get_clean(); ?>
<?php include __DIR__ . '/../layout.php'; ?>
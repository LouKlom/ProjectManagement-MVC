<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Management</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <header>
        <div class="header-left">
            <img src="/img/logo.png" alt="Logo Gestion Projets" class="logo">
            <h1 class="appTitle">Project Management</h1>
        </div>
        <nav>
            <ul>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="/index.php?route=projects&action=list">Project</a></li>
                    <li><a href="/index.php?route=user&action=profile">Profile</a></li>
                    <?php if (has_role('ADMIN')): ?>
                        <li><a href="/index.php?route=admin&action=index">Administration</a></li>
                    <?php endif; ?>
                    <li><a href="/index.php?route=auth&action=logout">Logout</a></li>
                <?php else: ?>
                    <li><a href="/index.php?route=auth&action=login">Sign in</a></li>
                    <li><a href="/index.php?route=auth&action=register">Sign up</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main>
        <?= $content ?? ''; ?>
    </main>
    <footer>
        <p>&copy; <?= date('Y'); ?> Mon Application de Gestion de Projets</p>
    </footer>
</body>
</html>
<?php ob_start(); ?>

<h1>List of projects</h1>

<?php if (!empty($projects)): ?>
    <ul>
        <?php foreach ($projects as $project): ?>
            <li>
                <a href="/index.php?route=projects&action=details&id=<?= $project['id']; ?>"><?= htmlspecialchars($project['name']); ?></a>
                <?= htmlspecialchars($project['start_date']); ?> - <?= htmlspecialchars($project['end_date']); ?>
                <a href="/index.php?route=projects&action=edit&id=<?= $project['id']; ?>">Edit</a>
                <a href="/index.php?route=projects&action=delete&id=<?= $project['id']; ?>" onclick="return confirm('Are you sure you want to delete this project ?');">Delete</a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No project found.</p>
<?php endif; ?>

<p><a href="/index.php?route=projects&action=create">Create a new project</a></p>


<?php $content = ob_get_clean(); ?>
<?php include '../views/layout.php'; ?>
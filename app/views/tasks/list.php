<?php ob_start(); ?>

<h1>Project's Tasks</h1>

<?php if (!empty($tasks)): ?>
    <ul>
        <?php foreach ($tasks as $task): ?>
            <li>
                <?= htmlspecialchars($task['title']); ?>
                <?php if ($task['assigned_user']): ?>
                    (Assigned to : <?= htmlspecialchars($task['assigned_user']); ?>)
                <?php endif; ?>
                - Status : <?= htmlspecialchars($task['status']); ?>
                <a href="/index.php?route=tasks&action=edit&id=<?= $task['id']; ?>">Edit</a>
                <a href="/index.php?route=tasks&action=delete&id=<?= $task['id']; ?>" onclick="return confirm('Are you sure you want to delete this task ?');">Delete</a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No tasks for this project.</p>
<?php endif; ?>

<p><a href="/index.php?route=tasks&action=create&project_id=<?= htmlspecialchars($_GET['project_id'] ?? ''); ?>">Create a new task</a></p>
<p><a href="/index.php?route=projects&action=details&id=<?= htmlspecialchars($_GET['project_id'] ?? ''); ?>">Back to project details</a></p>


<?php $content = ob_get_clean(); ?>
<?php include '../views/layout.php'; ?>
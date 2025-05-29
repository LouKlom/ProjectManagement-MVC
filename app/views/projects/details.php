<?php ob_start(); ?>

<h2>Project details : <?= htmlspecialchars($project['name'] ?? 'Projet inconnu'); ?></h2>

<?php if ($project): ?>
    <p><strong>Description :</strong> <?= htmlspecialchars($project['description'] ?? 'Aucune description'); ?></p>
    <p><strong>Start date :</strong> <?= htmlspecialchars($project['start_date'] ?? 'Non définie'); ?></p>
    <p><strong>End date :</strong> <?= htmlspecialchars($project['end_date'] ?? 'Non définie'); ?></p>

    <h2>Tasks</h2>
    <p><a href="/index.php?route=tasks&action=create&project_id=<?= $project['id']; ?>">Créer une nouvelle tâche</a></p>

    <?php if (!empty($tasks)): ?>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Priority</th>
                    <th>Due date</th>
                    <th>Assigned to</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tasks as $task): ?>
                    <tr>
                        <td><?= htmlspecialchars($task['title']); ?></td>
                        <td><?= htmlspecialchars($task['status']); ?></td>
                        <td><?= htmlspecialchars($task['priority'] ?? 'Non définie'); ?></td>
                        <td><?= htmlspecialchars($task['due_date'] ?? 'Non définie'); ?></td>
                        <td><?= htmlspecialchars($task['assigned_user'] ?? 'Non assigné'); ?></td>
                        <td>
                            <a href="/index.php?route=tasks&action=edit&id=<?= $task['id']; ?>">Edit</a>
                            <a href="/index.php?route=tasks&action=delete&id=<?= $task['id']; ?>" onclick="return confirm('Are you sure you want to delete this task ?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No tasks found.</p>
    <?php endif; ?>

    <p><a href="/index.php?route=projects&action=edit&id=<?= $project['id']; ?>">Edit this project</a></p>
    <p><a href="/index.php?route=projects&action=list">Back to Project List</a></p>
<?php else: ?>
    <p>This project didn't exist.</p>
<?php endif; ?>

<?php $content = ob_get_clean(); ?>
<?php include '../views/layout.php'; ?>
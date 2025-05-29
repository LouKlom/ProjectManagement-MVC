<?php ob_start(); ?>

<h2>List of projects</h2>

<?php if (!empty($projects)): ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>End Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($projects as $project): ?>
                <tr>
                    <td><?= htmlspecialchars($project['id']); ?></td>
                    <td><a href="/index.php?route=projects&action=details&id=<?= $project['id']; ?>"><?= htmlspecialchars($project['name']); ?></a></td>
                    <td><?= htmlspecialchars($project['end_date']); ?></td>
                    <td>
                <a href="/index.php?route=projects&action=edit&id=<?= $project['id']; ?>">Edit</a>
                <a href="/index.php?route=projects&action=delete&id=<?= $project['id']; ?>" onclick="return confirm('Are you sure you want to delete this project ?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No project found.</p>
<?php endif; ?>

<p><a href="/index.php?route=projects&action=create">Create a new project</a></p>


<?php $content = ob_get_clean(); ?>
<?php include '../views/layout.php'; ?>

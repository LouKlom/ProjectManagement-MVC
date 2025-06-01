<?php ob_start(); ?>

<h1>Tâches pour le projet : <?= htmlspecialchars($project['name']); ?></h1>

<p><a href="/?route=tasks&action=create&project_id=<?= $project['id']; ?>">Créer une nouvelle tâche pour ce projet</a></p>

<?php if (!empty($tasks)): ?>
    <table>
        <thead>
            <tr>
                <th>Titre</th>
                <th>Statut</th>
                <th>Priorité</th>
                <th>Échéance</th>
                <th>Assigné à</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tasks as $task): ?>
                <tr>
                    <td><a href="/?route=tasks&action=details&id=<?= $task['id']; ?>"><?= htmlspecialchars($task['title']); ?></a></td>
                    <td><?= htmlspecialchars($task['status']); ?></td>
                    <td><?= htmlspecialchars($task['priority'] ?? 'Non définie'); ?></td>
                    <td><?= htmlspecialchars($task['due_date'] ?? 'Non définie'); ?></td>
                    <td><?= htmlspecialchars($task['assigned_user'] ?? 'Non assigné'); ?></td>
                    <td>
                        <a href="/?route=tasks&action=edit&id=<?= $task['id']; ?>">Modifier</a>
                        <a href="/?route=tasks&action=delete&id=<?= $task['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette tâche ?');">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Aucune tâche pour ce projet.</p>
<?php endif; ?>

<p><a href="/?route=projects&action=list">Retour à la liste des projets</a></p>

<?php $content = ob_get_clean(); ?>
<?php include '../views/layout.php'; ?>
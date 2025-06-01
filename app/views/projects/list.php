<?php ob_start(); ?>

<h1>Projets en cours</h1>

<p><a href="/?route=projects&action=create">Créer un nouveau projet</a></p>

<?php if (!empty($ongoingProjects)): ?>
    <table>
        <thead>
            <tr>
                <th>Nom du projet</th>
                <th>Dates</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ongoingProjects as $project): ?>
                <tr>
                <td><a href="/?route=projects&action=tasksList&id=<?= $project['id']; ?>"><?= htmlspecialchars($project['name']); ?></a></td>
                    <td><?= htmlspecialchars($project['start_date']); ?> - <?= htmlspecialchars($project['end_date']); ?></td>
                    <td>
                        <a href="/?route=projects&action=edit&id=<?= $project['id']; ?>">Modifier</a>
                        <?php if (has_role('ADMIN')): ?>
                            <a href="/?route=projects&action=markAsFinishedAction&id=<?= $project['id']; ?>" onclick="return confirm('Marquer ce projet comme terminé ?');">Terminer</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Aucun projet en cours pour le moment.</p>
<?php endif; ?>

<br><br>
<h2>Projets terminés</h2>

<?php if (!empty($finishedProjects)): ?>
    <table>
        <thead>
            <tr>
                <th>Nom du projet</th>
                <th>Dates</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($finishedProjects as $project): ?>
                <tr>
                <td><a href="/?route=projects&action=tasksList&id=<?= $project['id']; ?>"><?= htmlspecialchars($project['name']); ?></a></td>
                    <td><?= htmlspecialchars($project['start_date']); ?> - <?= htmlspecialchars($project['end_date']); ?></td>
                    <td>
                        <?php if (has_role('ADMIN')): ?>
                            <a href="/?route=projects&action=markAsOngoingAction&id=<?= $project['id']; ?>" onclick="return confirm('Marquer ce projet comme en cours ?');">Remettre en cours</a>
                            <a href="/?route=projects&action=delete&id=<?= $project['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce projet terminé ?');">Supprimer</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Aucun projet terminé pour le moment.</p>
<?php endif; ?>

<?php $content = ob_get_clean(); ?>
<?php include '../views/layout.php'; ?>
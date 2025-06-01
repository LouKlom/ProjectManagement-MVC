<?php ob_start(); ?>

<h1>Détails de la tâche : <?= htmlspecialchars($task['title']); ?></h1>

<?php if ($task): ?>
    <div class="task-detail-card">
        <p><strong>Projet :</strong> <a href="/?route=projects&action=tasksList&id=<?= $project['id']; ?>"><?= htmlspecialchars($project['name']); ?></a></p>
        <p><strong>Statut :</strong> <?= htmlspecialchars($task['status']); ?></p>
        <p><strong>Priorité :</strong> <?= htmlspecialchars($task['priority'] ?? 'Non définie'); ?></p>
        <p><strong>Échéance :</strong> <?= htmlspecialchars($task['due_date'] ?? 'Non définie'); ?></p>
        <p><strong>Assigné à :</strong> <?= htmlspecialchars($task['assigned_user'] ?? 'Non assigné'); ?></p>
        <p><strong>Description :</strong> <?= htmlspecialchars($task['description'] ?? 'Aucune description'); ?></p>

        <div class="task-actions">
            <a href="/?route=tasks&action=edit&id=<?= $task['id']; ?>">Modifier la tâche</a>
            <a href="/?route=tasks&action=delete&id=<?= $task['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette tâche ?');">Supprimer la tâche</a>
        </div>
    </div>

    <div class="comments-section">
        <h4>Commentaires (<?= count($comments); ?>)</h4>
        <?php if (!empty($comments)): ?>
            <?php foreach ($comments as $comment): ?>
                <div class="comment-item">
                    <p class="comment-meta">
                        <strong><?= htmlspecialchars($comment['username']); ?></strong> le
                        <?= htmlspecialchars(date('d/m/Y à H:i', strtotime($comment['created_at']))); ?>
                    </p>
                    <p class="comment-content"><?= nl2br(htmlspecialchars($comment['content'])); ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun commentaire pour le moment.</p>
        <?php endif; ?>

        <div class="add-comment-form">
            <h5>Ajouter un commentaire</h5>
            <form action="/?route=tasks&action=addComment" method="post">
                <input type="hidden" name="task_id" value="<?= $task['id']; ?>">
                <div>
                    <label for="comment_content">Votre commentaire :</label>
                    <textarea id="comment_content" name="comment_content" rows="4" required></textarea>
                </div>
                <button type="submit">Poster le commentaire</button>
            </form>
        </div>
    </div>

    <p><a href="/?route=projects&action=tasksList&id=<?= $task['project_id']; ?>">Retour à la liste des tâches du projet</a></p>

<?php else: ?>
    <p>Tâche non trouvée ou vous n'avez pas l'autorisation d'y accéder.</p>
<?php endif; ?>

<?php $content = ob_get_clean(); ?>
<?php include '../views/layout.php'; ?>
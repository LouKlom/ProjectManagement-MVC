<?php ob_start(); ?>

<h1>Détails du projet : <?= htmlspecialchars($project['name'] ?? 'Projet inconnu'); ?></h1>

<?php if ($project): ?>
    <p><strong>Description :</strong> <?= htmlspecialchars($project['description'] ?? 'Aucune description'); ?></p>
    <p><strong>Date de début :</strong> <?= htmlspecialchars($project['start_date'] ?? 'Non définie'); ?></p>
    <p><strong>Date de fin prévue :</strong> <?= htmlspecialchars($project['end_date'] ?? 'Non définie'); ?></p>

    <h2>Tâches associées</h2>
    <p><a href="/?route=tasks&action=create&project_id=<?= $project['id']; ?>">Créer une nouvelle tâche</a></p>

    <?php if (!empty($tasks)): ?>
        <?php foreach ($tasks as $task): ?>
            <div class="task-card" id="task-<?= $task['id']; ?>"> <h3><?= htmlspecialchars($task['title']); ?></h3>
                <p><strong>Statut :</strong> <?= htmlspecialchars($task['status']); ?></p>
                <p><strong>Priorité :</strong> <?= htmlspecialchars($task['priority'] ?? 'Non définie'); ?></p>
                <p><strong>Échéance :</strong> <?= htmlspecialchars($task['due_date'] ?? 'Non définie'); ?></p>
                <p><strong>Assigné à :</strong> <?= htmlspecialchars($task['assigned_user'] ?? 'Non assigné'); ?></p>
                <p><strong>Description :</strong> <?= htmlspecialchars($task['description'] ?? 'Aucune description'); ?></p>

                <div class="task-actions">
                    <a href="/?route=tasks&action=edit&id=<?= $task['id']; ?>">Modifier</a>
                    <a href="/?route=tasks&action=delete&id=<?= $task['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette tâche ?');">Supprimer</a>
                </div>

                <h4>Commentaires (<?= count($task['comments']); ?>)</h4>
                <div class="comments-section">
                    <?php if (!empty($task['comments'])): ?>
                        <?php foreach ($task['comments'] as $comment): ?>
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
                                <label for="comment_content_<?= $task['id']; ?>">Votre commentaire :</label>
                                <textarea id="comment_content_<?= $task['id']; ?>" name="comment_content" rows="4" required></textarea>
                            </div>
                            <button type="submit">Poster le commentaire</button>
                        </form>
                    </div>
                </div>
            </div>
            <hr> <?php endforeach; ?>
    <?php else: ?>
        <p>Aucune tâche pour ce projet.</p>
    <?php endif; ?>

    <p><a href="/?route=projects&action=edit&id=<?= $project['id']; ?>">Modifier ce projet</a></p>
    <p><a href="/?route=projects&action=list">Retour à la liste des projets</a></p>
<?php else: ?>
    <p>Ce projet n'existe pas.</p>
<?php endif; ?>

<?php $content = ob_get_clean(); ?>
<?php include '../views/layout.php'; ?>
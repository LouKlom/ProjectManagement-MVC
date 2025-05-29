<?php ob_start(); ?>

<h1>Edit Task</h1>

<form method="post" action="/index.php?route=tasks&action=update">
    <input type="hidden" name="id" value="<?= htmlspecialchars($task['id'] ?? ''); ?>">
    <div>
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="<?= htmlspecialchars($task['title'] ?? ''); ?>" required>
    </div>
    <div>
        <label for="description">Description:</label>
        <textarea id="description" name="description"><?= htmlspecialchars($task['description'] ?? ''); ?></textarea>
    </div>
    <div>
        <label for="due_date">Duie date:</label>
        <input type="date" id="due_date" name="due_date" value="<?= htmlspecialchars($task['due_date'] ?? ''); ?>">
    </div>
    <div>
        <label for="status">Status:</label>
        <select id="status" name="status">
            <option value="à faire" <?= (isset($task['status']) && $task['status'] === 'à faire') ? 'selected' : ''; ?>>À faire</option>
            <option value="en cours" <?= (isset($task['status']) && $task['status'] === 'en cours') ? 'selected' : ''; ?>>En cours</option>
            <option value="terminé" <?= (isset($task['status']) && $task['status'] === 'terminé') ? 'selected' : ''; ?>>Terminé</option>
            <option value="bloqué" <?= (isset($task['status']) && $task['status'] === 'bloqué') ? 'selected' : ''; ?>>Bloqué</option>
        </select>
    </div>
    <div>
        <label for="priority">Priority:</label>
        <select id="priority" name="priority">
            <option value="">-- Choose --</option>
            <option value="haute" <?= (isset($task['priority']) && $task['priority'] === 'haute') ? 'selected' : ''; ?>>Haute</option>
            <option value="moyenne" <?= (isset($task['priority']) && $task['priority'] === 'moyenne') ? 'selected' : ''; ?>>Moyenne</option>
            <option value="basse" <?= (isset($task['priority']) && $task['priority'] === 'basse') ? 'selected' : ''; ?>>Basse</option>
        </select>
    </div>
    <div>
        <label for="assigned_to">Assign to:</label>
        <select id="assigned_to" name="assigned_to">
            <option value="">-- Non assigné --</option>
        </select>
    </div>
    <button type="submit">Modifier la tâche</button>
</form>

<?php if (isset($task['project_id'])): ?>
    <p><a href="/index.php?route=projects&action=details&id=<?= htmlspecialchars($task['project_id']); ?>">Retour aux détails du projet</a></p>
<?php endif; ?>

<?php $content = ob_get_clean(); ?>
<?php include '../views/layout.php'; ?>
<?php ob_start(); ?>

<h1>Create a new task</h1>

<form method="post" action="/index.php?route=tasks&action=store">
    <input type="hidden" name="project_id" value="<?= htmlspecialchars($_GET['project_id'] ?? ''); ?>">
    <div>
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>
    </div>
    <div>
        <label for="description">Description:</label>
        <textarea id="description" name="description"></textarea>
    </div>
    <div>
        <label for="due_date">Due date:</label>
        <input type="date" id="due_date" name="due_date">
    </div>
    <div>
        <label for="status">Status:</label>
        <select id="status" name="status">
            <option value="à faire">To do</option>
            <option value="en cours">In progress</option>
            <option value="terminé">End</option>
            <option value="bloqué">Bloqued</option>
        </select>
    </div>
    <div>
        <label for="priority">Priority:</label>
        <select id="priority" name="priority">
            <option value="">-- Choose --</option>
            <option value="haute">High</option>
            <option value="moyenne">Average</option>
            <option value="basse">Low</option>
        </select>
    </div>
    <div>
        <label for="assigned_to">Assign to:</label>
        <select id="assigned_to" name="assigned_to">
            <option value="">-- No assigned --</option>
        </select>
    </div>
    <button type="submit">Create Task</button>
</form>

<p><a href="/index.php?route=tasks&action=list&project_id=<?= htmlspecialchars($_GET['project_id'] ?? ''); ?>">Back to Task list</a></p>

<?php $content = ob_get_clean(); ?>
<?php include '../views/layout.php'; ?>
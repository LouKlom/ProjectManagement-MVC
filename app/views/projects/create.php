<?php ob_start(); ?>

<h1>Create a new Project</h1>

<form method="post" action="/index.php?route=projects&action=store">
    <div>
        <label for="name">Project name:</label>
        <input type="text" id="name" name="name" required>
    </div>
    <div>
        <label for="description">Description:</label>
        <textarea id="description" name="description"></textarea>
    </div>
    <div>
        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date">
    </div>
    <div>
        <label for="end_date">End date:</label>
        <input type="date" id="end_date" name="end_date">
    </div>
    <button type="submit">Create Project</button>
</form>

<p><a href="/index.php?route=projects&action=list">Get Back to Projects List</a></p>

<?php $content = ob_get_clean(); ?>
<?php include '../views/layout.php'; ?>
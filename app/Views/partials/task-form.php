<?php
declare(strict_types=1);

$task = $task ?? [];
$errors = $errors ?? [];
$submitLabel = $submitLabel ?? 'Save Task';
?>
<div class="row g-3">
    <div class="col-12">
        <label for="title" class="form-label">Title</label>
        <input
            id="title"
            name="title"
            type="text"
            class="form-control<?= ! empty($errors['title']) ? ' is-invalid' : '' ?>"
            value="<?= htmlspecialchars((string) ($task['title'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"
            placeholder="Task title"
        >
        <?php if (! empty($errors['title'])): ?>
            <div class="invalid-feedback"><?= htmlspecialchars($errors['title'], ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>
    </div>
    <div class="col-12">
        <label for="description" class="form-label">Description</label>
        <textarea
            id="description"
            name="description"
            rows="4"
            class="form-control<?= ! empty($errors['description']) ? ' is-invalid' : '' ?>"
            placeholder="Describe the task"
        ><?= htmlspecialchars((string) ($task['description'] ?? ''), ENT_QUOTES, 'UTF-8') ?></textarea>
        <?php if (! empty($errors['description'])): ?>
            <div class="invalid-feedback"><?= htmlspecialchars($errors['description'], ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>
    </div>
    <div class="col-md-4">
        <label for="status" class="form-label">Status</label>
        <select id="status" name="status" class="form-select<?= ! empty($errors['status']) ? ' is-invalid' : '' ?>">
            <?php foreach (['todo' => 'To Do', 'in_progress' => 'In Progress', 'done' => 'Done'] as $value => $label): ?>
                <option value="<?= $value ?>"<?= (($task['status'] ?? 'todo') === $value) ? ' selected' : '' ?>><?= $label ?></option>
            <?php endforeach; ?>
        </select>
        <?php if (! empty($errors['status'])): ?>
            <div class="invalid-feedback"><?= htmlspecialchars($errors['status'], ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>
    </div>
    <div class="col-md-4">
        <label for="priority" class="form-label">Priority</label>
        <select id="priority" name="priority" class="form-select<?= ! empty($errors['priority']) ? ' is-invalid' : '' ?>">
            <?php foreach (['low' => 'Low', 'medium' => 'Medium', 'high' => 'High', 'urgent' => 'Urgent'] as $value => $label): ?>
                <option value="<?= $value ?>"<?= (($task['priority'] ?? 'medium') === $value) ? ' selected' : '' ?>><?= $label ?></option>
            <?php endforeach; ?>
        </select>
        <?php if (! empty($errors['priority'])): ?>
            <div class="invalid-feedback"><?= htmlspecialchars($errors['priority'], ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>
    </div>
    <div class="col-md-4">
        <label for="due_date" class="form-label">Due date</label>
        <input
            id="due_date"
            name="due_date"
            type="date"
            class="form-control<?= ! empty($errors['due_date']) ? ' is-invalid' : '' ?>"
            value="<?= htmlspecialchars((string) ($task['due_date'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"
        >
        <?php if (! empty($errors['due_date'])): ?>
            <div class="invalid-feedback"><?= htmlspecialchars($errors['due_date'], ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>
    </div>
</div>
<div class="d-flex gap-2 mt-4">
    <button type="submit" class="btn btn-primary"><?= htmlspecialchars($submitLabel, ENT_QUOTES, 'UTF-8') ?></button>
    <a href="/tasks" class="btn btn-outline-secondary">Cancel</a>
</div>

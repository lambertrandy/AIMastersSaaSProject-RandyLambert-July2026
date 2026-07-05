<?php
declare(strict_types=1);
?>
<section class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">
    <div>
        <span class="badge rounded-pill text-bg-warning-subtle text-warning-emphasis mb-2">Task List Placeholder</span>
        <h1 class="h2 mb-1">Tasks</h1>
        <p class="text-secondary mb-0">Prompt 4 and Prompt 6 will turn this scaffold into CRUD, filtering, and sorting.</p>
    </div>
    <button type="button" class="btn btn-primary">Create Task Placeholder</button>
</section>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <label class="form-label">Search</label>
                <input type="text" class="form-control" placeholder="Search tasks">
            </div>
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select class="form-select">
                    <option>All statuses</option>
                    <option>To Do</option>
                    <option>In Progress</option>
                    <option>Done</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Priority</label>
                <select class="form-select">
                    <option>All priorities</option>
                    <option>Low</option>
                    <option>Medium</option>
                    <option>High</option>
                    <option>Urgent</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Sort</label>
                <select class="form-select">
                    <option>Due date</option>
                    <option>Created date</option>
                    <option>Priority</option>
                </select>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Task</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Due Date</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Draft dashboard cards</td>
                        <td><span class="badge text-bg-primary">In Progress</span></td>
                        <td><span class="badge text-bg-warning">High</span></td>
                        <td>2026-07-08</td>
                        <td class="text-end"><a href="/kanban" class="btn btn-sm btn-outline-secondary">View Workflow</a></td>
                    </tr>
                    <tr>
                        <td>Plan database migrations</td>
                        <td><span class="badge text-bg-secondary">To Do</span></td>
                        <td><span class="badge text-bg-info">Medium</span></td>
                        <td>2026-07-10</td>
                        <td class="text-end"><a href="/calendar" class="btn btn-sm btn-outline-secondary">See Calendar</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

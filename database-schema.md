# Database Schema

This document defines the initial database schema for version 1 of the to-do list tracker SaaS application. It is intended to guide Codex while building the database layer and related PHP code.

## Database Overview

- Database engine: MariaDB
- Database name: `ai_db`
- Application type: multi-user SaaS to-do list tracker
- Version scope: version 1 only

Version 1 uses a minimal schema focused on:

- users
- tasks

## Design Principles

- Keep the schema simple and tutorial-friendly
- Support secure multi-user data isolation
- Support the core version 1 product features only
- Avoid premature normalization unless it clearly improves clarity

## Tables

### `users`

Purpose:

- Store authenticated application users

Columns:

- `id`
  - Type: `INT UNSIGNED`
  - Attributes: primary key, auto-increment

- `name`
  - Type: `VARCHAR(100)`
  - Attributes: not null

- `email`
  - Type: `VARCHAR(255)`
  - Attributes: not null, unique

- `password_hash`
  - Type: `VARCHAR(255)`
  - Attributes: not null

- `created_at`
  - Type: `DATETIME`
  - Attributes: not null

- `updated_at`
  - Type: `DATETIME`
  - Attributes: not null

Constraints:

- Primary key on `id`
- Unique index on `email`

### `tasks`

Purpose:

- Store tasks owned by individual users

Columns:

- `id`
  - Type: `INT UNSIGNED`
  - Attributes: primary key, auto-increment

- `user_id`
  - Type: `INT UNSIGNED`
  - Attributes: not null

- `title`
  - Type: `VARCHAR(255)`
  - Attributes: not null

- `description`
  - Type: `TEXT`
  - Attributes: nullable

- `status`
  - Type: `VARCHAR(50)`
  - Attributes: not null
  - Allowed values for version 1:
  - `todo`
  - `in_progress`
  - `done`

- `priority`
  - Type: `VARCHAR(50)`
  - Attributes: not null
  - Allowed values for version 1:
  - `low`
  - `medium`
  - `high`
  - `urgent`

- `due_date`
  - Type: `DATE`
  - Attributes: nullable

- `completed_at`
  - Type: `DATETIME`
  - Attributes: nullable

- `created_at`
  - Type: `DATETIME`
  - Attributes: not null

- `updated_at`
  - Type: `DATETIME`
  - Attributes: not null

Constraints:

- Primary key on `id`
- Foreign key from `user_id` to `users.id`

## Relationships

- One user can own many tasks
- Each task belongs to exactly one user

Relationship summary:

- `users.id` -> `tasks.user_id`

## Required Indexes

### `users`

- Primary key index on `id`
- Unique index on `email`

### `tasks`

- Primary key index on `id`
- Index on `user_id`
- Index on `status`
- Index on `due_date`
- Composite index on `user_id, status`
- Composite index on `user_id, due_date`

These indexes support common version 1 queries:

- get all tasks for one user
- get tasks for one user by status
- get overdue tasks for one user
- get tasks due today for one user
- render kanban columns efficiently
- render calendar views efficiently

## Suggested SQL Schema

```sql
CREATE TABLE users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at DATETIME NOT NULL,
  updated_at DATETIME NOT NULL
);

CREATE TABLE tasks (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  title VARCHAR(255) NOT NULL,
  description TEXT NULL,
  status VARCHAR(50) NOT NULL,
  priority VARCHAR(50) NOT NULL,
  due_date DATE NULL,
  completed_at DATETIME NULL,
  created_at DATETIME NOT NULL,
  updated_at DATETIME NOT NULL,
  CONSTRAINT fk_tasks_user
    FOREIGN KEY (user_id) REFERENCES users(id)
    ON DELETE CASCADE
);

CREATE INDEX idx_tasks_user_id ON tasks(user_id);
CREATE INDEX idx_tasks_status ON tasks(status);
CREATE INDEX idx_tasks_due_date ON tasks(due_date);
CREATE INDEX idx_tasks_user_status ON tasks(user_id, status);
CREATE INDEX idx_tasks_user_due_date ON tasks(user_id, due_date);
```

## Application Rules Mapped To Schema

### Authentication

- `users.email` must be unique
- `users.password_hash` stores the hashed password, never the raw password

### Task Ownership

- every task must include a `user_id`
- all task queries must be filtered by `user_id`
- users must never access or mutate tasks they do not own

### Task Completion

- `status = done` indicates a completed task
- `completed_at` should be set when a task is marked complete
- `completed_at` may be cleared if a completed task is moved back to an incomplete status

## Query Use Cases

The schema should support these common version 1 queries:

- get user by email for login
- create a new user during registration
- get all tasks for the authenticated user
- get tasks by status for kanban columns
- get tasks due today for dashboard
- get overdue tasks for dashboard
- get upcoming tasks for dashboard
- get tasks in a date range for calendar
- get one task by `id` and `user_id`

## Data Validation Expectations

The database schema supports the structure, but application code should enforce:

- required title
- valid email format
- valid allowed status values
- valid allowed priority values
- secure password rules

## Optional Future Schema Extensions

These are not required for version 1, but may be added later:

- `projects` table
- `task_comments` table
- `tags` and `task_tags` tables
- `activity_logs` table
- `password_resets` table
- `user_settings` table

## Version 1 Recommendation

For the tutorial project, keep the schema to:

- `users`
- `tasks`

Do not add more tables until the core user authentication and task management flows are working end to end.

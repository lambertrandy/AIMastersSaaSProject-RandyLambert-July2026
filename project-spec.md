# Project Spec

This document defines the concrete implementation scope for version 1 of the to-do list tracker SaaS application. It is intended to guide Codex during development.

## Project Summary

- Product: SaaS to-do list tracker
- Architecture: server-rendered PHP application
- Frontend enhancement: HTMX and Alpine.js
- UI framework: Bootstrap 5.3
- Backend stack: PHP 8.2, Apache, MariaDB
- Deployment target for development: Docker Compose

## Development Environment

- Version 1 development should assume the application runs through `docker compose`
- Apache serves the application from `/var/www/html`
- Local project files are mounted into the web container from `./www`
- Application database connections should use Docker service host `db`, not `localhost`
- The default database target for application code is:
- Host: `db`
- Port: `3306`
- Database: `ai_db`
- Username: `app_user`
- Password: `app_password`

## Version 1 Goal

Build a simple, usable multi-user to-do application with:

- user registration and login
- personal task management
- a dashboard
- a kanban board
- a calendar view
- task create, edit, view, complete, and delete flows

Version 1 should prioritize clarity, maintainability, and tutorial-friendly structure over advanced features.

## MVP Scope

The following features are included in version 1:

- User registration
- User login/logout
- Session-based authentication
- Protected application pages
- User-specific task ownership
- Dashboard view
- Task list view
- Kanban board view
- Calendar view
- Task detail view
- Create task
- Edit task
- Mark task complete
- Delete task
- Basic filtering and sorting

The following features are explicitly out of scope for version 1:

- Team collaboration
- Shared task boards
- File uploads
- Notifications
- Email verification
- Password reset
- Recurring tasks
- Drag-and-drop kanban interactions
- Real-time multi-user updates

## Application Structure

Version 1 should be organized around the following top-level areas:

- Public authentication pages
- Authenticated application pages
- Reusable layout components
- Reusable task partials for HTMX updates

## Primary Pages and Routes

The application should include the following pages or route targets.

### Public Routes

- `/`
- Purpose: redirect authenticated users to dashboard and unauthenticated users to login

- `/login`
- Purpose: display login form and process login

- `/register`
- Purpose: display registration form and process registration

- `/logout`
- Purpose: end authenticated session

### Authenticated Routes

- `/dashboard`
- Purpose: task overview and summary metrics

- `/tasks`
- Purpose: standard task list view with filters and sorting

- `/tasks/create`
- Purpose: create task form or create endpoint

- `/tasks/{id}`
- Purpose: task detail view

- `/tasks/{id}/edit`
- Purpose: task edit form or edit endpoint

- `/kanban`
- Purpose: kanban board grouped by task status

- `/calendar`
- Purpose: calendar view by due date

HTMX endpoints may reuse these routes or introduce partial-specific endpoints if needed.

## Authentication Spec

### Registration

Users must be able to register with:

- name
- email
- password
- password confirmation

Registration rules:

- email must be unique
- password must be hashed securely using PHP password hashing
- validation errors must be shown clearly

### Login

Users must be able to log in with:

- email
- password

Login rules:

- invalid credentials must show a clear error
- successful login must create a secure session

### Logout

- logout must destroy the current session
- users must be redirected to login or home page after logout

### Authorization

- all task routes must require authentication
- users must only access tasks they own
- server-side checks must enforce ownership before viewing or mutating tasks

## Task Domain Spec

### Version 1 Task Fields

Each task must support:

- `id`
- `user_id`
- `title`
- `description`
- `status`
- `priority`
- `due_date`
- `created_at`
- `updated_at`
- `completed_at` nullable

Optional version 1 field:

- `category` or `project_name`

If categories/projects add complexity, defer them until after the core app works.

### Required Task Statuses

Version 1 should use these statuses:

- `todo`
- `in_progress`
- `done`

Optional later statuses:

- `backlog`
- `review`
- `blocked`

### Required Task Priorities

Version 1 should use these priorities:

- `low`
- `medium`
- `high`
- `urgent`

## Dashboard Spec

The dashboard is the main landing page after login.

### Dashboard Must Include

- summary cards
- tasks due today
- upcoming tasks
- overdue tasks
- recently completed tasks
- quick link or quick form to create a task

### Dashboard Summary Metrics

Show at minimum:

- total tasks
- completed tasks
- open tasks
- overdue tasks
- due today count

### Dashboard Behavior

- all data must be scoped to the logged-in user
- if no tasks exist, show an empty state with a create-task call to action

## Task List Spec

The task list view provides a structured list/table interface.

### Task List Must Include

- task title
- status
- priority
- due date
- action controls

### Task List Controls

- filter by status
- filter by priority
- filter by due-date state
- sort by due date
- sort by created date
- sort by priority

## Kanban Spec

The kanban board is a status-based visual task management page.

### Kanban Layout

Required columns:

- To Do
- In Progress
- Done

### Kanban Card Content

Each task card should show:

- title
- priority
- due date if available
- short description excerpt if available

### Kanban Behavior

- users must be able to change task status from the board
- status changes may be implemented initially with buttons or dropdowns rather than drag-and-drop
- card updates should use HTMX when practical

## Calendar Spec

The calendar view organizes tasks by due date.

### Calendar Requirements

- monthly view for version 1
- navigation between months
- tasks appear on the correct due dates
- clicking a date shows tasks due on that date
- tasks without a due date do not appear in the calendar grid

### Calendar Behavior

- overdue tasks should be distinguishable
- completed tasks should be visually distinct
- users must be able to open a task detail from the calendar

## Task Detail Spec

The task detail page or modal should support full task management.

### Task Detail Must Show

- title
- description
- status
- priority
- due date
- created date
- updated date
- completed state

### Task Actions

- edit task
- mark complete
- mark incomplete if desired
- delete task with confirmation

## HTMX Spec

HTMX should be used selectively for common interactions that benefit from partial updates.

Recommended HTMX interactions:

- create task form submission
- edit task form submission
- status updates
- completion toggles
- task deletion with list refresh
- dashboard task widgets refresh
- task list filters and sorting updates

HTMX is not required for every action. Standard full-page form handling is acceptable where simpler.

## Alpine.js Spec

Alpine.js should be used only for lightweight UI state.

Recommended Alpine.js usage:

- modal open/close state
- collapsible filter areas
- simple interactive toggles
- small client-side UI helpers

Avoid building the application as a client-heavy SPA.

## UI Spec

### Layout

The authenticated app should use:

- a top navigation bar
- optional sidebar on desktop
- a consistent page header area
- responsive layouts across views

### Bootstrap Usage

- use Bootstrap 5.3 components and utilities first
- use patterns and examples from `https://getbootstrap.com/`
- keep custom CSS limited and purposeful

## Data Isolation Spec

- every task record must belong to a specific user
- all queries for tasks must be filtered by the authenticated user ID
- direct access to another user's task ID must be rejected

## Error Handling Spec

Version 1 should include clear handling for:

- invalid form submission
- unauthorized access
- missing task records
- failed login attempts
- empty states when no tasks exist

## Initial Database Entities

Version 1 should plan for at least:

- `users`
- `tasks`

No additional entities are required unless categories/projects are added in version 1.

## Suggested Build Order

Codex should implement version 1 in this order:

1. base project structure and shared layout
2. database connection and migrations or schema SQL
3. authentication system
4. task CRUD
5. dashboard
6. task list filtering/sorting
7. kanban board
8. calendar view
9. HTMX enhancements
10. UI polish

## Acceptance Criteria For Version 1

Version 1 is complete when:

- a user can register, log in, and log out
- a logged-in user can create, view, edit, complete, and delete tasks
- users cannot access each other’s tasks
- the dashboard shows correct user-specific metrics and task groupings
- the kanban board groups tasks by status and allows status changes
- the calendar shows tasks by due date
- the UI is responsive and uses Bootstrap 5.3 patterns
- HTMX and Alpine.js improve interaction without unnecessary complexity

# Codex Prompts

This document contains implementation prompts for Codex to build version 1 of the to-do list tracker SaaS application in a controlled sequence.

Each prompt assumes Codex has access to these project documents:

- `tech-stack.md`
- `design-notes.md`
- `requirements.md`
- `project-spec.md`
- `database-schema.md`
- `user-stories.md`

## Prompt 1: Project Scaffold And Routing

Build the initial PHP application scaffold for this project using the guidance in `tech-stack.md`, `design-notes.md`, `requirements.md`, and `project-spec.md`.

Requirements:

- Build a simple server-rendered PHP 8.2 application that runs under Apache from the `www/` directory
- Create a clean folder structure for configuration, shared layout, authentication, tasks, and reusable partials
- Add a front controller or routing approach suitable for a tutorial project
- Create initial routes for `/`, `/login`, `/register`, `/logout`, `/dashboard`, `/tasks`, `/kanban`, and `/calendar`
- Add a shared Bootstrap 5.3 layout with a responsive top navigation
- Load Bootstrap 5.3, jQuery, HTMX, and Alpine.js from CDNs for now
- Use Bootstrap patterns inspired by `getbootstrap.com`
- Keep the structure simple and maintainable

Deliverables:

- initial folder structure
- shared layout template
- placeholder pages for all main routes
- clear routing/bootstrap entry point

## Prompt 2: Database Connection And SQL Setup

Using `database-schema.md` and `project-spec.md`, implement the database connection layer and schema setup for this project.

Requirements:

- Add a reusable MariaDB connection configuration using PHP PDO
- Create a SQL schema file for the `users` and `tasks` tables defined in `database-schema.md`
- Ensure the schema includes indexes and the foreign key relationship
- Add a simple database bootstrap/config approach appropriate for a tutorial app
- Add clear error handling for failed database connections
- Keep credentials configurable through a simple config file or environment-based approach if practical

Deliverables:

- database connection code
- schema SQL file
- clear instructions in code comments or README-style note if needed for importing schema

## Prompt 3: Authentication System

Implement the full version 1 authentication system using `requirements.md`, `project-spec.md`, and `user-stories.md`.

Requirements:

- Build user registration with name, email, password, and password confirmation
- Build login with email and password
- Use secure password hashing with PHP password hashing functions
- Use session-based authentication
- Protect authenticated routes so unauthenticated users are redirected to login
- Implement logout
- Prevent duplicate registration by email
- Show clear validation and authentication error messages
- Use Bootstrap 5.3 form styling

Deliverables:

- registration flow
- login flow
- logout flow
- authentication guard/helper logic
- authenticated navigation state

## Prompt 4: Task CRUD

Implement core task CRUD using `database-schema.md`, `requirements.md`, `project-spec.md`, and `user-stories.md`.

Requirements:

- Add create, read, update, and delete functionality for tasks
- Each task must belong to the authenticated user
- Task fields for version 1 must include title, description, status, priority, due date, created_at, updated_at, and completed_at
- Title is required
- Users must only be able to access and mutate their own tasks
- Build task creation and edit forms with Bootstrap 5.3
- Add delete confirmation
- Add task detail page

Deliverables:

- task list page
- create task page/form
- task detail page
- edit task page/form
- delete action

## Prompt 5: Dashboard

Build the authenticated dashboard using `design-notes.md`, `requirements.md`, `project-spec.md`, and `user-stories.md`.

Requirements:

- Make `/dashboard` the main post-login landing page
- Show summary cards for total tasks, completed tasks, open tasks, overdue tasks, and due today
- Show task sections for due today, upcoming, overdue, and recently completed
- Add a clear quick action to create a new task
- Use Bootstrap 5.3 cards, grid, spacing utilities, and responsive layout patterns
- Ensure all dashboard data is scoped to the authenticated user
- Add empty states when the user has no tasks

Deliverables:

- fully working dashboard page
- task summary queries
- empty-state handling

## Prompt 6: Task List Filters And Sorting

Enhance the task list using `requirements.md`, `project-spec.md`, and `user-stories.md`.

Requirements:

- Add filtering by status
- Add filtering by priority
- Add filtering by due-date state such as today, upcoming, overdue, and all
- Add sorting by due date, created date, and priority
- Preserve the current filter/sort state in the UI
- Use Bootstrap 5.3 forms and table/list presentation
- Keep the implementation simple and easy to follow

Deliverables:

- working filter controls
- working sort controls
- filtered/sorted task list behavior

## Prompt 7: Kanban Board

Build the kanban board using `design-notes.md`, `requirements.md`, `project-spec.md`, and `user-stories.md`.

Requirements:

- Create `/kanban` as a board view grouped by status
- Include columns for To Do, In Progress, and Done
- Show the authenticated user’s tasks in the correct columns
- Each task card should show title, priority, due date if present, and a short description excerpt if present
- Add a simple status-change control on each card instead of drag-and-drop
- Add a clear link or button to open task detail/edit
- Use Bootstrap 5.3 cards and responsive column layout

Deliverables:

- working kanban page
- grouped task queries
- status update behavior from the board

## Prompt 8: Calendar View

Build the calendar view using `design-notes.md`, `requirements.md`, `project-spec.md`, and `user-stories.md`.

Requirements:

- Create `/calendar` as a monthly task calendar
- Show tasks on their due dates
- Allow navigation between previous and next months
- Show a selected day’s tasks below the calendar or in a side panel
- Make completed tasks visually distinct
- Make overdue tasks visually distinct
- Exclude tasks with no due date from the calendar grid
- Add links to open task detail/edit from the selected date task list
- Use Bootstrap 5.3 layout and utilities for structure and clarity

Deliverables:

- working monthly calendar page
- month navigation
- per-day task display

## Prompt 9: HTMX Enhancements

Add HTMX enhancements to the application using `tech-stack.md`, `project-spec.md`, and `design-notes.md`.

Requirements:

- Use HTMX for task status changes where practical
- Use HTMX for task completion toggles where practical
- Use HTMX for task deletion refresh behavior where practical
- Use HTMX for task list filtering/sorting updates if it simplifies the UX
- Use partial templates where needed
- Keep full-page fallbacks functional
- Avoid overengineering or turning the app into a SPA

Deliverables:

- HTMX partials/endpoints where useful
- smoother task interactions
- preserved server-rendered architecture

## Prompt 10: Alpine And UI Polish

Polish the application UI using Bootstrap 5.3, Alpine.js, and `design-notes.md`.

Requirements:

- Use Alpine.js only for lightweight UI state such as toggles, modal visibility, dismissible sections, or collapsible filters
- Improve responsive navigation and layout consistency across dashboard, tasks, kanban, and calendar
- Refine spacing, headings, buttons, badges, empty states, and forms using Bootstrap 5.3 patterns
- Ensure status and priority colors are consistent across the app
- Ensure the UI remains accessible and readable
- Keep custom CSS minimal and purposeful

Deliverables:

- lightweight Alpine.js interactions
- polished Bootstrap-based UI
- consistent styling across all main screens

## Recommended Usage

Use these prompts in order. After each prompt:

- review the generated code
- run the application
- verify the feature works before moving to the next prompt

If needed, each prompt can be split further into smaller implementation prompts during development.

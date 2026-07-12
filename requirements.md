# Requirements

This document defines the functional requirements for the to-do list tracker SaaS application. It is intended to guide Codex while building the project.

## Product Overview

- Product type: SaaS to-do list tracker
- Primary purpose: help authenticated users manage tasks across list, kanban, calendar, and dashboard views
- Application style: server-rendered PHP application enhanced with HTMX and Alpine.js

## Core Application Requirements

- The application must support full user authentication
- Each user must be able to manage only their own tasks and related data unless future collaboration features are added
- The application must support task creation, viewing, editing, completion, and deletion
- The application must provide multiple task management views: dashboard, kanban board, calendar, and task detail
- The application must be responsive and usable on desktop and mobile devices

## Authentication Requirements

### User Registration

- Users must be able to create an account with at least:
- Name
- Email address
- Password

- Email addresses must be unique
- Passwords must be stored securely using password hashing
- Registration must validate required fields and input format

### User Login

- Users must be able to log in with email and password
- Invalid login attempts must display a clear error message
- Authenticated sessions must persist securely until logout or expiration

### User Logout

- Users must be able to log out explicitly
- Logout must destroy or invalidate the active session

### Access Control

- Unauthenticated users must not be able to access protected application pages
- Authenticated users must only access their own task data

## Data Requirements

Each task should support the following fields at minimum:

- Title
- Description
- Status
- Priority
- Due date
- Created date
- Updated date
- User ID owner reference

Optional fields that may be included if helpful:

- Project or category
- Notes
- Completed date
- Sort order

## Dashboard Requirements

The dashboard must provide a high-level overview of a user's tasks and activity.

### Functional Requirements

- The dashboard must be available only to authenticated users
- The dashboard must show summary metrics
- The dashboard must show tasks due today
- The dashboard must show upcoming tasks
- The dashboard must show overdue tasks
- The dashboard must show recently completed tasks
- The dashboard should support quick access to create a new task

### Summary Metrics

The dashboard should display:

- Total tasks
- Completed tasks
- Incomplete tasks
- Overdue tasks
- Tasks due today

## Kanban Board Requirements

The kanban board must allow users to manage tasks visually by status.

### Functional Requirements

- The kanban board must be available only to authenticated users
- The kanban board must group tasks into status columns
- The kanban board must display task cards inside each column
- Users must be able to move tasks between statuses
- Users must be able to open a task from the kanban board to view or edit details

### Required Status Columns

The initial kanban board should include:

- To Do
- In Progress
- Done

Additional optional statuses may include:

- Backlog
- Review
- Blocked

### Task Card Requirements

Each kanban card should display:

- Task title
- Priority
- Due date if present
- Short description or excerpt if present

## Calendar Requirements

The calendar view must allow users to see tasks by due date.

### Functional Requirements

- The calendar must be available only to authenticated users
- The calendar must show tasks on their due dates
- Users must be able to navigate between date ranges such as month-to-month
- Selecting a date should show tasks due on that date
- Users must be able to open a task from the calendar to view or edit details

### Calendar Behavior

- Tasks without a due date do not need to appear on the calendar
- Overdue tasks should be distinguishable from future tasks
- Completed tasks should be visually distinct from incomplete tasks

## Task Detail Requirements

The task detail area must support creating, viewing, and editing an individual task.

### Create Task

- Authenticated users must be able to create a new task
- Creating a task must require at least a title
- The system should allow optional description, priority, and due date
- After creation, the task should appear in the relevant views

### View Task

- Users must be able to open a task detail page or modal
- The detail view must display all task fields relevant to the user

### Edit Task

- Users must be able to edit title, description, status, priority, and due date
- Users must be able to mark a task complete
- Updating a task must update the `updated date`

### Delete Task

- Users must be able to delete a task
- Deletion should require confirmation

## Basic Filtering and Sorting Requirements

- Users should be able to filter tasks by status
- Users should be able to filter tasks by priority
- Users should be able to filter tasks by due date conditions such as today, upcoming, and overdue
- Users should be able to sort tasks by due date, creation date, or priority

## SaaS Requirements

- The application must support multiple registered users
- Each user's task data must be isolated from other users
- Authentication and task access must be enforced on the server side

## Non-Functional Requirements

- The application should be simple enough for a tutorial project
- The application should prioritize clarity and maintainability over advanced architecture
- The UI should be responsive and readable
- The application should use Bootstrap 5.3 for UI structure and styling
- The application should use HTMX and Alpine.js only where they simplify interaction

## Future Enhancements

The following are not required for the initial version but may be added later:

- Team collaboration
- Shared projects
- Email verification
- Password reset
- Notifications and reminders
- Drag-and-drop kanban interactions
- Recurring tasks
- Tags and labels

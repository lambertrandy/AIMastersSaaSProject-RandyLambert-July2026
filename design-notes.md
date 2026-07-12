# Design Notes

This document defines the design direction for the to-do list application. It is intended to guide Codex while building the interface and interaction patterns.

## Design Foundation

- Use Bootstrap 5.3 as the primary UI framework
- Use examples and component patterns from `https://getbootstrap.com/`
- Keep the application responsive for desktop, tablet, and mobile
- Prefer clean, practical layouts over decorative styling
- Use Bootstrap utility classes before adding custom CSS

## Product Type

- Application: To-do list manager
- Style: dashboard-oriented productivity app
- Interaction model: server-rendered PHP pages enhanced with HTMX and Alpine.js

## Core Screens

The application should include the following major views.

### Dashboard

Purpose:
- Give the user a quick overview of tasks, projects, deadlines, and progress

Recommended elements:
- Top navigation bar
- Summary cards for total tasks, completed tasks, overdue tasks, and upcoming tasks
- Recent activity section
- Today's tasks section
- Quick-add task form
- Project or category breakdown
- Progress bars for completion metrics

### Task List View

Purpose:
- Display tasks in a traditional list/table format for quick scanning and filtering

Recommended elements:
- Search input
- Filters for status, priority, due date, and project
- Sort controls
- Task rows with status, title, due date, priority, and actions
- Pagination or load-more behavior if needed

### Kanban Board

Purpose:
- Let users manage tasks visually by workflow status

Recommended columns:
- Backlog
- To Do
- In Progress
- Review
- Done

Recommended elements:
- Card-based tasks
- Column headers with task counts
- Priority badges
- Due date indicators
- Assignee or category labels if used
- Drag-and-drop can be deferred unless explicitly added later

### Calendar View

Purpose:
- Show tasks by due date and help users plan upcoming work

Recommended elements:
- Monthly calendar layout
- Optional weekly agenda section
- Task markers on dates
- Clickable dates to show tasks due that day
- Highlight overdue and current-day items clearly

### Task Detail / Edit View

Purpose:
- Create and edit tasks with clear forms

Recommended fields:
- Title
- Description
- Status
- Priority
- Due date
- Project or category
- Notes

## Common UI Components

Use Bootstrap 5.3 components where appropriate:

- Navbar
- Offcanvas or collapsible mobile navigation
- Cards
- Buttons and button groups
- Forms and input groups
- Modals
- Dropdowns
- Badges
- Alerts and toasts
- Tables
- Nav tabs or pills
- Progress bars
- List groups

## Visual Direction

- Clean and professional productivity-tool appearance
- Light theme by default
- Strong spacing and alignment
- Clear visual hierarchy for headings, task titles, and metadata
- Use color intentionally for status and priority

### Suggested Status Colors

- To Do: secondary or neutral
- In Progress: primary
- Review: warning
- Done: success
- Overdue: danger

### Suggested Priority Colors

- Low: secondary
- Medium: info or primary
- High: warning
- Urgent: danger

## Layout Guidance

- Use a container with a clear page header and action area
- Keep navigation consistent across dashboard, kanban, calendar, and task views
- On desktop, prefer a sidebar plus top bar layout if it improves productivity
- On mobile, collapse navigation cleanly and prioritize task creation and viewing

## Interaction Guidance

- Use HTMX for task creation, editing, deleting, filtering, and status updates without full page reloads
- Use Alpine.js for small UI behaviors such as modal state, toggle sections, filter visibility, and inline interactions
- Keep interactions fast and predictable
- Prefer progressive enhancement over heavy client-side complexity

## Dashboard Content Ideas

- Welcome header
- Summary metrics row
- Upcoming deadlines
- Tasks due today
- Recently completed tasks
- Project progress cards
- Quick-add task panel

## Kanban Content Ideas

- Each task card should show:
- Title
- Priority
- Due date
- Short description or excerpt
- Status
- Quick actions

## Calendar Content Ideas

- Show task counts per day
- Visually distinguish completed vs pending tasks
- Allow selecting a day to view its task list below the calendar

## Accessibility Notes

- Use semantic headings and form labels
- Ensure sufficient color contrast
- Do not rely on color alone for task status or priority
- Use clear focus states for interactive controls
- Keep forms keyboard accessible

## Custom Styling Guidance

- Add custom CSS only when Bootstrap utilities and components are not enough
- Keep custom styles minimal and organized
- Avoid introducing a design system that conflicts with Bootstrap

## Codex Build Guidance

When generating UI for this project:

- Prefer Bootstrap 5.3 layouts and components first
- Refer to `getbootstrap.com` examples for structure and spacing patterns
- Build dashboard, kanban, calendar, and task management views as first-class parts of the app
- Keep the design practical, readable, and maintainable
- Avoid overly complex JavaScript when HTMX and Alpine.js are sufficient

# AI Tutorial To-Do SaaS

A Docker-based SaaS-style task manager built with PHP, Apache, MariaDB, Bootstrap 5.3, HTMX, and Alpine.js.

This project was built to demonstrate more than coding output. It shows product planning, technical scoping, structured AI-assisted delivery, debugging, and iterative implementation in a real development environment using VS Code, GitHub, Codex, and GPT-5.4.

## Why This Project Matters

This repository represents a practical portfolio project for:

- project management with technical depth
- translating product ideas into requirements and implementation plans
- using AI coding tools in a controlled, prompt-by-prompt workflow
- debugging real infrastructure, runtime, and UI issues
- shipping a working application in Docker

It is both a working application and a record of how the application was planned and delivered.

## What The Application Does

The app is a multi-user to-do tracker with:

- user registration, login, logout, and session-based authentication
- user-scoped task ownership
- full task CRUD
- dashboard summaries and task sections
- kanban board by status
- monthly calendar view by due date
- task list filters and sorting
- HTMX-enhanced in-place interactions
- Alpine-powered lightweight UI behaviors

## Feature Summary

### Authentication

- Register with name, email, and password
- Secure password hashing
- Login and logout
- Protected routes

### Task Management

- Create tasks
- View task list
- Open task detail pages
- Edit tasks
- Mark tasks complete
- Delete tasks

### Dashboard

- Total tasks
- Completed tasks
- Open tasks
- Overdue tasks
- Due today tasks
- Due today section
- Upcoming section
- Overdue section
- Recently completed section

### Task List

- Filter by status
- Filter by priority
- Filter by due date state
- Sort by created date
- Sort by due date
- Sort by priority

### Kanban

- To Do, In Progress, and Done columns
- Status updates directly from the board
- Detail and edit access from each card

### Calendar

- Monthly calendar layout
- Previous and next month navigation
- Clickable day selection
- Selected-day task panel
- Visual distinction for completed and overdue tasks

### Interaction Enhancements

- HTMX in-place task filtering and sorting
- HTMX in-place complete and delete actions
- HTMX in-place kanban updates
- Alpine dismissible alerts
- Alpine collapsible filter panel

## Tech Stack

### Backend

- PHP 8.2
- Apache
- MariaDB
- PDO with `pdo_mysql`
- Server-rendered PHP architecture

### Frontend

- Bootstrap 5.3
- jQuery
- HTMX
- Alpine.js
- Custom CSS

### Infrastructure And Tooling

- Docker Compose
- Linux host environment
- VS Code
- Git and GitHub
- Codex
- GPT-5.4

## Architecture

The application runs in Docker with two services:

- `web`
  - custom PHP 8.2 Apache image
  - serves the app from `/var/www/html`
- `db`
  - MariaDB

Application code is organized into:

- `app/`
  - routes, repositories, views, auth/session helpers, config
- `www/`
  - Apache document root and public assets
- `database/`
  - schema and DB setup notes
- `docker/`
  - Docker build and Apache configuration

## Planning And Delivery Artifacts

This project includes a full planning layer used to guide implementation:

- [tech-stack.md](./tech-stack.md)
- [design-notes.md](./design-notes.md)
- [requirements.md](./requirements.md)
- [project-spec.md](./project-spec.md)
- [database-schema.md](./database-schema.md)
- [user-stories.md](./user-stories.md)
- [codex-prompts.md](./codex-prompts.md)

Those documents were used to break the build into scoped milestones and reduce ambiguity before implementation started.

## Running The Project

Start the containers:

```bash
sudo docker compose up --build -d
```

Import the schema:

```bash
sudo docker compose exec -T db mariadb -uapp_user -papp_password ai_db < database/schema.sql
```

Open the app:

```text
http://localhost
```

## Runtime Configuration

Important defaults:

- web port: `80`
- database port: `3306`
- DB host inside the app: `db`
- DB name: `ai_db`
- DB user: `app_user`
- DB password: `app_password`
- app timezone: `America/Toronto`

MariaDB data is stored in a named Docker volume for persistence.

## Useful Commands

Start:

```bash
sudo docker compose up -d
```

Rebuild:

```bash
sudo docker compose up --build -d
```

Stop:

```bash
sudo docker compose down
```

Check status:

```bash
sudo docker compose ps
```

View logs:

```bash
sudo docker compose logs
```

Inspect tables:

```bash
sudo docker compose exec db mariadb -uapp_user -papp_password -e "USE ai_db; SHOW TABLES;"
```

Inspect task data:

```bash
sudo docker compose exec db mariadb -uapp_user -papp_password -e "USE ai_db; SELECT id, title, status, priority, due_date FROM tasks ORDER BY id;"
```

## What This Project Demonstrates

This build demonstrates the ability to:

- define product scope before writing code
- create structured planning artifacts
- work inside a Docker-based development environment
- build incrementally with AI-assisted prompts
- validate work after each milestone
- debug issues across application, infrastructure, Git, and UI layers
- keep implementation aligned with requirements and user stories

## Roadblocks We Hit And Solved

This was not a frictionless build, which is part of why it is valuable as a portfolio project.

Real issues included:

- malformed `docker-compose.yml` image and env values
- Docker daemon permission issues on Linux
- Apache `403 Forbidden` from an empty web root
- Git/GitHub authentication and transport issues
- missing container mounts for application code
- missing `pdo_mysql` support in the PHP container
- route scope bugs
- stale form-state bug leaking values between task edits
- calendar layout issues
- timezone mismatch affecting dashboard date logic

Those issues were diagnosed and resolved during development using Codex and GPT-5.4, with manual verification after each fix.

## AI-Assisted Development Note

This application was built with Codex and GPT-5.4 as active delivery tools, not as a replacement for technical judgment.

AI was used to help with:

- planning documents
- implementation prompts
- scaffolding
- feature delivery
- debugging
- UI refinement

The important part of the process was disciplined use:

- define scope
- implement one milestone at a time
- test each milestone
- fix issues before moving forward

## Current Status

The application is a working SaaS-style MVP with:

- authentication
- task CRUD
- dashboard
- kanban
- calendar
- HTMX interactivity
- Alpine-based UI polish

## Potential Next Steps

- automated testing
- stronger validation and error handling
- projects or categories
- tags
- reminders
- password reset
- email verification
- deployment setup
- team collaboration features

## Portfolio Positioning

This project is a strong example of:

- technical project ownership
- AI-assisted software delivery
- product-minded planning
- debugging and iterative improvement
- full-stack thinking across backend, frontend, infrastructure, and workflow

It was intentionally built in a way that shows both execution and process. This is not just a code sample; it is a delivery sample.

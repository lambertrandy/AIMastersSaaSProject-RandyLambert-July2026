# Tech Stack

This document defines the technology stack for the to-do list tracker application. It is intended to guide Codex while building the project.

## Operating System

- Host OS: Linux
- Container OS: Linux via Docker images

## Backend Stack

The backend runs in Docker using a LAMP-style stack defined in `docker-compose.yml`.

### Docker Services

- Web server container: `php:8.2-apache`
- Database container: `mariadb:latest`

### Backend Technologies

- Linux: provided by the Docker container base images
- Apache: web server running inside the `php:8.2-apache` container
- PHP: PHP 8.2 running with Apache
- MariaDB: relational database server

### Backend Notes

- Application files are mounted from `./www` to `/var/www/html`
- Apache serves the PHP application from `/var/www/html`
- PHP application code should connect to MariaDB using Docker service host `db`, not `localhost`
- Default database connection target for application code:
- Host: `db`
- Port: `3306`
- Database: `ai_db`
- Username: `app_user`
- Password: loaded from local `.env`
- MariaDB is exposed on port `3306`
- Apache is exposed on port `80`
- Database name: `ai_db`
- MariaDB data should persist through a named Docker volume

## Frontend Stack

The frontend for the to-do list tracker should use the following libraries and approach.

### Frontend Technologies

- Bootstrap for layout, components, and styling
- jQuery for Bootstrap JavaScript behavior
- HTMX for server-driven interactivity
- Alpine.js for lightweight client-side state and UI behavior

### Frontend Source

- Bootstrap design and component patterns: `https://getbootstrap.com/`

### Frontend Notes

- Use Bootstrap as the primary UI framework
- Use jQuery where needed for Bootstrap JavaScript functionality
- Use HTMX for partial page updates and AJAX-style interactions without building a SPA
- Use Alpine.js for small interactive behaviors such as toggles, inline edits, and local UI state

## Application Type

- Application: To-do list tracker
- Architecture: Server-rendered PHP application enhanced with HTMX and Alpine.js

## Codex Build Guidance

When building this application, prefer:

- PHP 8.2 with Apache for server-rendered pages and form handling
- MariaDB for persistence
- Docker Compose as the local development runtime
- Bootstrap-based layouts and components
- HTMX for CRUD interactions such as creating, editing, completing, and deleting tasks
- Alpine.js only for small client-side interactions
- Simple, maintainable structure suitable for a tutorial project

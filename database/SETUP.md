# Database Setup

This project uses MariaDB in Docker Compose.

## Connection Defaults

- Host: `db`
- Port: `3306`
- Database: `ai_db`
- Username: `app_user`
- Password: `app_password`

These values are passed into the PHP container through `docker-compose.yml` and are also the defaults in `app/Config/database.php`.

## Import The Schema

Run this from the project root after the containers are up:

```bash
sudo docker compose exec -T db mariadb -uapp_user -papp_password ai_db < database/schema.sql
```

## Verify The Tables

```bash
sudo docker compose exec db mariadb -uapp_user -papp_password -e "USE ai_db; SHOW TABLES;"
```

## Notes

- If the `app_user` account does not exist because the MariaDB volume was initialized before these credentials were added, recreate the DB volume and start the containers again.
- Prompt 2 adds the PDO connection layer only. Authentication and data access logic are implemented in later prompts.

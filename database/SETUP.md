# Database Setup

This project uses MariaDB in Docker Compose. Database credentials are loaded from the local `.env` file, which is intentionally ignored by Git.

## Connection Defaults

- Host: `db`
- Port: `3306`
- Database: `ai_db`
- Username: `app_user`
- Password: loaded from local `.env` as `APP_DB_PASSWORD`

These values are passed into the PHP container through `docker-compose.yml` and are also the defaults in `app/Config/database.php`.

## Import The Schema

Run this from the project root after the containers are up:

```bash
sudo docker compose exec -T db sh -c 'mariadb -u"$MYSQL_USER" -p"$MYSQL_PASSWORD" "$MYSQL_DATABASE"' < database/schema.sql
```

## Verify The Tables

```bash
sudo docker compose exec db sh -c 'mariadb -u"$MYSQL_USER" -p"$MYSQL_PASSWORD" -e "USE $MYSQL_DATABASE; SHOW TABLES;"'
```

## Notes

- If the `app_user` account does not exist because the MariaDB volume was initialized before these credentials were added, recreate the DB volume and start the containers again.
- Prompt 2 adds the PDO connection layer only. Authentication and data access logic are implemented in later prompts.

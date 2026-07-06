<?php
declare(strict_types=1);

namespace App\Repositories;

use PDO;

final class TaskRepository
{
    public function __construct(
        private readonly PDO $database,
    ) {
    }

    public function allForUser(int $userId): array
    {
        $statement = $this->database->prepare(
            'SELECT * FROM tasks WHERE user_id = :user_id ORDER BY created_at DESC'
        );
        $statement->execute(['user_id' => $userId]);

        return $statement->fetchAll();
    }

    public function findForUser(int $taskId, int $userId): ?array
    {
        $statement = $this->database->prepare(
            'SELECT * FROM tasks WHERE id = :id AND user_id = :user_id LIMIT 1'
        );
        $statement->execute([
            'id' => $taskId,
            'user_id' => $userId,
        ]);

        $task = $statement->fetch();

        return is_array($task) ? $task : null;
    }

    public function create(int $userId, array $data): int
    {
        $statement = $this->database->prepare(
            'INSERT INTO tasks (user_id, title, description, status, priority, due_date, completed_at, created_at, updated_at)
             VALUES (:user_id, :title, :description, :status, :priority, :due_date, :completed_at, :created_at, :updated_at)'
        );

        $timestamp = date('Y-m-d H:i:s');
        $statement->execute([
            'user_id' => $userId,
            'title' => $data['title'],
            'description' => $data['description'],
            'status' => $data['status'],
            'priority' => $data['priority'],
            'due_date' => $data['due_date'] ?: null,
            'completed_at' => $data['status'] === 'done' ? $timestamp : null,
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ]);

        return (int) $this->database->lastInsertId();
    }

    public function update(int $taskId, int $userId, array $data): void
    {
        $statement = $this->database->prepare(
            'UPDATE tasks
             SET title = :title,
                 description = :description,
                 status = :status,
                 priority = :priority,
                 due_date = :due_date,
                 completed_at = :completed_at,
                 updated_at = :updated_at
             WHERE id = :id AND user_id = :user_id'
        );

        $timestamp = date('Y-m-d H:i:s');
        $statement->execute([
            'id' => $taskId,
            'user_id' => $userId,
            'title' => $data['title'],
            'description' => $data['description'],
            'status' => $data['status'],
            'priority' => $data['priority'],
            'due_date' => $data['due_date'] ?: null,
            'completed_at' => $data['status'] === 'done' ? ($data['completed_at'] ?: $timestamp) : null,
            'updated_at' => $timestamp,
        ]);
    }

    public function delete(int $taskId, int $userId): void
    {
        $statement = $this->database->prepare(
            'DELETE FROM tasks WHERE id = :id AND user_id = :user_id'
        );
        $statement->execute([
            'id' => $taskId,
            'user_id' => $userId,
        ]);
    }

    public function markComplete(int $taskId, int $userId): void
    {
        $statement = $this->database->prepare(
            'UPDATE tasks
             SET status = :status,
                 completed_at = :completed_at,
                 updated_at = :updated_at
             WHERE id = :id AND user_id = :user_id'
        );

        $timestamp = date('Y-m-d H:i:s');
        $statement->execute([
            'id' => $taskId,
            'user_id' => $userId,
            'status' => 'done',
            'completed_at' => $timestamp,
            'updated_at' => $timestamp,
        ]);
    }
}

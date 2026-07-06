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

    public function dashboardSummary(int $userId): array
    {
        $today = date('Y-m-d');

        $statement = $this->database->prepare(
            'SELECT
                COUNT(*) AS total_tasks,
                SUM(CASE WHEN status = "done" THEN 1 ELSE 0 END) AS completed_tasks,
                SUM(CASE WHEN status <> "done" THEN 1 ELSE 0 END) AS open_tasks,
                SUM(CASE WHEN status <> "done" AND due_date IS NOT NULL AND due_date < :overdue_today THEN 1 ELSE 0 END) AS overdue_tasks,
                SUM(CASE WHEN due_date = :due_today THEN 1 ELSE 0 END) AS due_today_tasks
             FROM tasks
             WHERE user_id = :user_id'
        );
        $statement->execute([
            'overdue_today' => $today,
            'due_today' => $today,
            'user_id' => $userId,
        ]);

        $summary = $statement->fetch();

        return [
            'total_tasks' => (int) ($summary['total_tasks'] ?? 0),
            'completed_tasks' => (int) ($summary['completed_tasks'] ?? 0),
            'open_tasks' => (int) ($summary['open_tasks'] ?? 0),
            'overdue_tasks' => (int) ($summary['overdue_tasks'] ?? 0),
            'due_today_tasks' => (int) ($summary['due_today_tasks'] ?? 0),
        ];
    }

    public function dueTodayForUser(int $userId, int $limit = 5): array
    {
        return $this->tasksForDateCondition(
            'user_id = :user_id AND status <> "done" AND due_date = :today',
            ['user_id' => $userId, 'today' => date('Y-m-d')],
            $limit
        );
    }

    public function upcomingForUser(int $userId, int $limit = 5): array
    {
        return $this->tasksForDateCondition(
            'user_id = :user_id AND status <> "done" AND due_date > :today',
            ['user_id' => $userId, 'today' => date('Y-m-d')],
            $limit
        );
    }

    public function overdueForUser(int $userId, int $limit = 5): array
    {
        return $this->tasksForDateCondition(
            'user_id = :user_id AND status <> "done" AND due_date IS NOT NULL AND due_date < :today',
            ['user_id' => $userId, 'today' => date('Y-m-d')],
            $limit
        );
    }

    public function recentlyCompletedForUser(int $userId, int $limit = 5): array
    {
        $statement = $this->database->prepare(
            'SELECT * FROM tasks
             WHERE user_id = :user_id AND status = "done"
             ORDER BY completed_at DESC, updated_at DESC
             LIMIT :limit'
        );
        $statement->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
        $statement->execute();

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

    private function tasksForDateCondition(string $whereClause, array $parameters, int $limit): array
    {
        $statement = $this->database->prepare(
            'SELECT * FROM tasks
             WHERE ' . $whereClause . '
             ORDER BY due_date ASC, created_at DESC
             LIMIT :limit'
        );

        foreach ($parameters as $key => $value) {
            $statement->bindValue(':' . $key, $value);
        }

        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }
}

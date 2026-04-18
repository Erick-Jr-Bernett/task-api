<?php

namespace App\Services;

use App\Models\Task;
use App\Enums\TaskStatus;

class TaskService
{
    public function list(array $filters)
    {
        $query = Task::query();

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['search'])) {
            $query->where('title', 'like', '%' . $filters['search'] . '%');
        }

        return $query->paginate(10);
    }

    public function create(array $data): Task
    {
        $data['status'] = $data['status'] ?? TaskStatus::PENDING;

        return Task::create($data);
    }

    public function update(Task $task, array $data): Task
    {
        if (!isset($data['status'])) {
            unset($data['status']);
        }

        $task->update($data);

        return $task;
    }

    public function delete(Task $task): void
    {
        $task->delete();
    }
}
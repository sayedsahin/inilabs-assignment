<?php

namespace App\Services;

use App\Models\Task;

class TaskService
{

    public function getPaginated(int $perPage = 10)
    {
        return Task::latest()
            ->where('user_id', auth('sanctum')->id())
            ->paginate($perPage);
    }


    public function create(array $data)
    {
        return Task::create([
            'user_id'     => auth('sanctum')->id(),
            'title'       => $data['title'],
            'description' => $data['description'] ?? null,
            'status'      => $data['status']
        ]);
    }


    public function update(Task $task, array $data)
    {
        $task->update([
            'title'       => $data['title'] ?? $task->title,
            'description' => $data['description'] ?? $task->description,
            'status'      => $data['status'] ?? $task->status,
        ]);

        return $task;
    }


    public function delete(Task $task)
    {
        return $task->delete();
    }
}

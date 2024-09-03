<?php

namespace App\Repositories;

use App\Interfaces\TaskRepositoryInterface;
use App\Models\Task;

class TaskRepository implements TaskRepositoryInterface
{
    public function all()
    {
        return Task::all();
    }

    public function find($id)
    {
        return Task::findOrFail($id);
    }

    public function create(array $attributes)
    {
        return Task::create($attributes);
    }

    public function update($id, array $attributes)
    {
        $task = $this->find($id);
        $task->update($attributes);
        return $task;
    }

    public function delete($id)
    {
        $task = $this->find($id);
        $task->delete();
    }
}

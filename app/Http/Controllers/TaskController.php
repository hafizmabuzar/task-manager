<?php

namespace App\Http\Controllers;

use App\Interfaces\TaskRepositoryInterface as InterfacesTaskRepositoryInterface;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    protected $taskRepository;

    public function __construct(InterfacesTaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function index()
    {
        $tasks = $this->taskRepository->all();

        return response()->json([
            'status' => 'success',
            'tasks' => $tasks
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:3|max:100',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in-progress,completed',
            'due_date' => 'nullable|date',
            'is_active' => 'nullable|string',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $task = $this->taskRepository->create($request->all());
        return response()->json([
            'status' => 'success',
            'task' => $task
        ], 200);
    }

    public function show($id)
    {
        return $this->taskRepository->find($id);
    }

    public function update(Request $request, $id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Task not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:3|max:100',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in-progress,completed',
            'due_date' => 'nullable|date',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $task = $this->taskRepository->update($id, $request->all());
        return response()->json([
            'status' => 'success',
            'task' => $task
        ], 200);
    }

    public function destroy($id)
    {
        $this->taskRepository->delete($id);
        return response()->json([
            'status' => 'success'
        ], 200);
    }
}


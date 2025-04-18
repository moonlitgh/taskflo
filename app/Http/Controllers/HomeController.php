<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $userId = Auth::id();
        
        // Debug user info
        Log::info('Current User:', ['user_id' => $userId]);

        // Get all tasks for current user
        $tasks = Task::where('user_id', $userId)
                    ->whereNotNull('due_date')
                    ->get()
                    ->map(function ($task) {
                        return [
                            'id' => $task->id,
                            'title' => $task->title,
                            'description' => $task->description,
                            'date' => $task->due_date->format('Y-m-d'),
                            'status' => $task->status,
                            'priority' => $task->priority,
                            'is_completed' => (bool)$task->is_completed
                        ];
                    });

        // Debug tasks
        Log::info('Tasks found:', [
            'count' => $tasks->count(),
            'tasks' => $tasks->toArray()
        ]);

        // Calculate statistics
        $totalTasks = $tasks->count();
        $doneTasks = $tasks->where('status', 'done')->count();
        $delayTasks = $tasks->where('status', 'delay')->count();

        return view('home', [
            'tasks' => $tasks,
            'totalTasks' => $totalTasks,
            'doneTasks' => $doneTasks,
            'delayTasks' => $delayTasks
        ]);
    }
}
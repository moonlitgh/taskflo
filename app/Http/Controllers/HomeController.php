<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $totalTasks = Task::where('user_id', $user->id)->count();
        $doneTasks = Task::where('user_id', $user->id)->where('status', 'done')->count();
        $delayTasks = Task::where('user_id', $user->id)->where('status', 'delay')->count();

        // Fetch tasks for the calendar
        $tasks = Task::where('user_id', $user->id)
                     ->whereIn('status', ['delay', 'process', 'done']) // Show delayed, process, and done tasks
                     ->select('id', 'title', 'description', 'due_date', 'status', 'priority') // Added id for logging
                     ->get();

        // Log raw tasks fetched from DB
        Log::info('Raw tasks fetched from DB:', $tasks->toArray()); 

        // Format tasks for the calendar
        $calendarTasks = $tasks->map(function ($task) {
            // Convert the date to YYYY-MM-DD format
            $formattedDate = optional($task->due_date)->toDateString(); // Use optional() for safety
            
            Log::info('Task date check:', [
                'task_id' => $task->id ?? 'N/A', 
                'original_date' => $task->due_date,
                'formatted_date' => $formattedDate,
                'status' => $task->status // Log status
            ]);
            
            // Skip tasks without a valid date
            if (!$formattedDate) {
                return null;
            }

            return [
                'title' => $task->title,
                'description' => $task->description,
                'date' => $formattedDate,
                'status' => $task->status,
                'priority' => $task->priority
            ];
        })->filter()->values()->toArray(); // Add filter() to remove nulls and values() to reindex

        // Debug log
        Log::info('Final Calendar Tasks (after formatting):', $calendarTasks);

        return view('home', [
            'totalTasks' => $totalTasks,
            'doneTasks' => $doneTasks,
            'delayTasks' => $delayTasks,
            'tasks' => $calendarTasks
        ]);
    }
} 
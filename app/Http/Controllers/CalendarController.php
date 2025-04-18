<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function index()
    {
        try {
            // Get authenticated user
            $user = Auth::user();
            
            // Get all tasks for the authenticated user
            $tasks = Task::where('user_id', Auth::id())->get();
            
            // Group tasks by date
            $tasksByDate = [];
            foreach ($tasks as $task) {
                // Make sure due_date is a DateTime object before calling format()
                if ($task->due_date) {
                    $date = $task->due_date instanceof \DateTime 
                        ? $task->due_date->format('Y-m-d')
                        : date('Y-m-d', strtotime($task->due_date));
                        
                    if (!isset($tasksByDate[$date])) {
                        $tasksByDate[$date] = [];
                    }
                    $tasksByDate[$date][] = $task;
                }
            }
            
            return view('calendar.index', compact('tasksByDate', 'user'));
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Calendar error: ' . $e->getMessage());
            
            // Return with empty data to prevent errors
            $user = Auth::user();
            return view('calendar.index', ['tasksByDate' => [], 'user' => $user]);
        }
    }
    
    public function getTasksByDate(Request $request)
    {
        try {
            $date = $request->date;
            $tasks = Task::where('user_id', Auth::id())
                        ->whereDate('due_date', $date)
                        ->get();
                        
            return response()->json($tasks);
        } catch (\Exception $e) {
            \Log::error('Calendar tasks error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to load tasks'], 500);
        }
    }
}
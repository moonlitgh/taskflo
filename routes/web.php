<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\SettingsController;
// Add back the calendar controller import
use App\Http\Controllers\CalendarController;

// Make the home page the main route with auth check
Route::get('/', function () {
    if (Auth::check()) {
        // Get the calendar data for the home page
        $user = Auth::user();
        $tasks = \App\Models\Task::where('user_id', Auth::id())->get();
        
        // Calculate task statistics
        $totalTasks = $tasks->count();
        $doneTasks = $tasks->where('is_completed', true)->count();
        $delayTasks = $tasks->where('is_completed', false)
            ->where('due_date', '<', now()->format('Y-m-d'))
            ->count();
        
        // Group tasks by date for the calendar
        $tasksByDate = [];
        foreach ($tasks as $task) {
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
        
        return view('home', compact('user', 'totalTasks', 'doneTasks', 'delayTasks', 'tasksByDate'));
    } else {
        return redirect()->route('login');
    }
})->name('root');

// Authentication Routes remain the same
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    // Update the home route to include calendar data
    Route::get('/home', function () {
        $user = Auth::user();
        $tasks = \App\Models\Task::where('user_id', Auth::id())->get();
        
        // Group tasks by date for the calendar
        $tasksByDate = [];
        foreach ($tasks as $task) {
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
        
        $totalTasks = 0;
        $doneTasks = 0;
        $delayTasks = 0;
        
        return view('home', compact('user', 'totalTasks', 'doneTasks', 'delayTasks', 'tasksByDate'));
    })->name('home');

    // Task routes
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::put('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');

    // Settings routes
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::post('/password/email', [SettingsController::class, 'sendResetLink'])->name('password.email');

    // Additional routes
    Route::get('/tambah-tugas', [TaskController::class, 'create'])->name('tambah-tugas');
    Route::get('/tugas', [TaskController::class, 'index'])->name('tugas');
    
    // Help route
    Route::get('/help', function () {
        $user = Auth::user();
        return view('help', compact('user'));
    })->name('help');

    // Add back the calendar routes
    Route::get('/calendar/tasks', [CalendarController::class, 'getTasksByDate'])->name('calendar.tasks');
});

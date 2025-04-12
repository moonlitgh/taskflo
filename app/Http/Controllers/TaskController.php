<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $tasks = Task::where('user_id', $user->id)
            ->orderByRaw("FIELD(priority, 'high', 'medium', 'low')")
            ->orderBy('due_date', 'asc')
            ->get();
            
        return view('tugas', compact('tasks', 'user'));
    }

    public function create()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }
        return view('tambah-tugas', compact('user'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'priority' => 'required|in:low,medium,high',
        ]);

        $task = new Task();
        $task->user_id = $user->id;
        $task->title = $validated['title'];
        $task->description = $validated['description'];
        $task->due_date = $validated['due_date'];
        $task->priority = $validated['priority'];
        $task->status = 'process';
        $task->is_completed = false;
        $task->save();

        return redirect()->route('tugas')->with('success', 'Tugas berhasil ditambahkan!');
    }

    public function show(Task $task)
    {
        $user = Auth::user();
        if (!$user || $task->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        return response()->json($task);
    }

    public function updateStatus(Request $request, Task $task)
    {
        if ($task->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'status' => 'required|in:process,done'
        ]);

        $task->update([
            'status' => $request->status
        ]);

        return response()->json(['success' => true]);
    }

    public function update(Request $request, Task $task)
    {
        $user = Auth::user();
        if (!$user || $task->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'due_date' => 'required|date',
                'priority' => 'required|in:low,medium,high',
            ]);

            $task->title = $validated['title'];
            $task->description = $validated['description'];
            $task->due_date = $validated['due_date'];
            $task->priority = $validated['priority'];
            $task->save();

            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy(Task $task)
    {
        $user = Auth::user();
        if (!$user || $task->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $task->delete();
        return response()->json(['success' => true]);
    }

    public function edit(Task $task)
    {
        $user = Auth::user();
        if (!$user || $task->user_id !== $user->id) {
            return redirect()->route('tugas')->with('error', 'Unauthorized access');
        }

        return view('edit-tugas', compact('task', 'user'));
    }
} 
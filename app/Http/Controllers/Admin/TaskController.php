<?php

namespace App\Http\Controllers\Admin;

use App\Events\TaskCompleted;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::where('user_id', Auth::user()->id)->get();
        return view('dashboard', compact('tasks'));
    }

    public function store(StoreTaskRequest $request)
    {

        try {
            $task = new Task();
            $task->user_id = Auth::user()->id;
            $task->title = $request->title;
            $task->description = $request->description;
            $task->status = $request->status;
            $task->due_date = $request->due_date;
            $task->save();
        
            return response()->json([
                'status' => 'success',
                'message' => 'Task created successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create task',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(StoreTaskRequest $request)
    {
        try {
            $task = Task::find($request->taskId);
        
            if (!$task) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Task not found'
                ], 404);
            }
        
            $task->title = $request->title;
            $task->description = $request->description;
            $task->status = $request->status;
            $task->due_date = $request->due_date;
            $task->save();
        
            return response()->json([
                'status' => 'success',
                'message' => 'Task updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update task',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function statusUpdate(Request $request){

        try {
            $task = Task::find($request->taskId);
    
            if (!$task) {
                return back()->with('error', 'Task not found');
            }
    
            $task->status = $request->status;
            $task->save();
    
            if ($task->status === 'completed') {
                event(new TaskCompleted($task));
            }
    
            return back()->with('success', 'Task status updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update task');
        }
    }

    public function edit(Request $request){
        $task = Task::find($request->taskId);
        return response()->json([
            'status' => 'success',
            'task' => $task
        ]);
    }

    public function destroy(Request $request, $id){
        $task = Task::find($id);
        $task->delete();
        return back()->with('success', 'Task deleted successfully');
    }

    public function taskFilter(Request $request){
        $tasks = Task::where('user_id', Auth::user()->id)->where('status', $request->status)->get();
        return view('dashboard', compact('tasks'));
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Events\TaskCompleted;
use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function taskList(Request $request)
    {
        $tasks = Task::where('user_id', Auth::user()->id)->get();
        return response()->json([
            'status' => 'success',
            'tasks' => $tasks
        ], 200);
    }

    public function taskCreate(Request $request)
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
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create task',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function taskUpdate(Request $request)
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
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update task',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function taskDelete(Request $request)
    {
        $task = Task::find($request->taskId);
        $task->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Task deleted successfully'
        ], 200);
    }

    public function taskStatusUpdate(Request $request)
    {
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
    
            return response()->json([
                'status' => 'success',
                'message' => 'Task status updated successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update task',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function insertTask(Request $request)
    {
        $request->validate([
            'task' => 'required',
        ]);
        $task = $request->task;
        $user = $request->session()->get('user');

        $t = new Task();
        $t->task = $task;
        $t->user_id = $user->id;
        $t->save();
        return $request;
        

    }
    public function status(Request $request)
    {
        $task = Task::find($request->task_id);
        $task->status = "done";
        $task->save();
        
    }
}

<?php

namespace App\Http\Controllers;

use App\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $toDoList = Todo::all();

        return view('todoapp.index', [
            'toDoList' => $toDoList,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (empty($request->task) && empty($request->owner)) {
            return redirect()->back()->with('msg_empty', 'Do not leave required fields empty');
        }

        $customer_name_exists = Todo::where([
            ['task', '=', $request->task],
            ['owner', '=', $request->owner],
        ])->first();

        if ($customer_name_exists === null) {
            $todo = new Todo();
            $todo->task = $request->task;
            $todo->owner = $request->owner;
            $todo->status = 'Working on';
            $todo->save();

            return redirect()->back()->with('msg', 'New task inserted');
        }

        return redirect()->back()->with([
            'msg' => true,
            'msg_duplicate' => 'Task is already on the list'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function edit(Todo $todo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required',
            'task' => 'required',
            'owner' => 'required',
            'status' => 'required',
        ]);

        Todo::whereId($request->id)->update($validatedData);

        return redirect()->back()->with('msg', 'Task updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->todo_id;
        $todo = Todo::findOrFail($id);
        $todo->delete();
        return back()->with('msg', 'Task deleted ID#:' . $id);
    }
}

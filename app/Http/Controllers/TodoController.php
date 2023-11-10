<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        $todo = Todo::when($status !== 'all', function ($query) use ($status) {
            return $query->where('status', $status);
        })->paginate(10);

        if ($request->ajax()) {
            return response()->json(['data' => $todo]);
        }

        return view('todo.index', compact('todo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('todo.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string',
                'description' => 'required|string',
                'due_date' => 'required|date|after_or_equal:today',
                'status' => 'required|in:pending,progress,completed',
            ]);

            if ($validator->fails()) {
                return redirect('todo/create')
                    ->withErrors($validator)
                    ->withInput();
            }

            $validated = $validator->validated();

            $todo = Todo::create([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'due_date' => $validated['due_date'],
                'status' => $validated['status'],
            ]);

            return redirect()->route('todo.index')->with('success', 'Todo Created successfully');
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $todo
     * @return \Illuminate\Http\Response
     */
    public function show($todo)
    {
        $todo = Todo::findOrFail($todo);
        return view('todo.show', compact('todo'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $todo
     * @return \Illuminate\Http\Response
     */
    public function edit(Todo $todo)
    {
        return view('todo.edit', compact('todo'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Todo $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Todo $todo)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'required|string',
            'due_date' => 'required|date|after_or_equal:today',
            'status' => 'required|in:pending,progress,completed',
        ]);

        if ($validator->fails()) {
            return redirect('todo/create')
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();
        $todo->update($validated);

        return redirect()->route('todo.show', ['todo' => $todo->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Todo $todo)
    {
        $todo->delete();

        if ($request->ajax()) {
            return response()->json(['message' => 'Todo deleted successfully.']);
        } else {
            return redirect()->route('todo.index')->with('success', 'Todo deleted successfully.');
        }
    }
}

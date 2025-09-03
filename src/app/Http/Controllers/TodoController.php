<?php

namespace App\Http\Controllers;

use App\Todo;

use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index()
    {
        $todo = new Todo();
        // dd($todo);
        // App\Todo
        
        $todos = $todo->all();
        // dd($todo);→App\Todo {#233 ▶}

        return view('todo.index', ['todos' => $todos]);
    }

    public function create()
    {
      return view('todo.create', ['todos' => 'TODO:']); 
    }

    public function store(Request $request)
    {
      $inputs = $request->all();

      // dd($inputs);
      // array:2 [▼
      //           "_token" => "Ht9P0bGoBeUkE4aRYLnMXxVQztveMnBjB8EFXIfN"
      //            "content" => "aa"
      //         ]

      $todo = new Todo();
      // dd($todo);
      // App\Todo {#232 ▶}
      $todo->content = $inputs['content'];
      // dd($inputs['content']);
      // "aa"
      $todo->fill($inputs);
      $todo->save();

      return redirect()->route('todo.index');

    }

}


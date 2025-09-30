<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoRequest;
use App\Todo;

// use Illuminate\Http\Request;

class TodoController extends Controller
{
    private $todo;

    public function __construct(Todo $todo)
    {
      $this->todo = $todo;
    }

    public function index()
    {
      $todos = $this->todo->all();
        return view('todo.index', ['todos' => $todos]);
    }
//Collectionクラスの利点・・・直感的な操作で意図が明確、Controller側のコードを加工するだけで表示するデータを柔軟に加工できる、メソッドチェーンで拡張しやすい
//view関数の引数・・・表示したいbladeファイルを第一引数(相対パス）で指定し、第二引数に渡したいデータを連想配列の形で渡す
// なぜ便利→返り値はレスポンスに変換されるので、処理を意識しなくていい
// 第一引数にtest.indexと書き換えた時同じ処理をするにはどうすれば良いか→読み込み先のbladeファイルを書き換える
    public function create()
    {
      return view('todo.create', ['todos' => 'TODO:']); 
    }

    public function store(TodoRequest $request)
    {

      $inputs = $request->all();

      // dd($inputs);
      // array:2 [▼
      //           "_token" => "Ht9P0bGoBeUkE4aRYLnMXxVQztveMnBjB8EFXIfN"
      //            "content" => "aa"
      //         ]
      // フォームから送られてきたデータを全て配列として取得
      $this->todo->fill($inputs);
      $this->todo->save();

      return redirect()->route('todo.index');
    }

    public function show($id)
    {
      $todo = $this->todo->find($id);
      return view('todo.show', ['todo' => $todo]);
    }

    public function edit($id)
    {
      $todo = $this->todo->find($id);
      
      return view('todo.edit', ['todo' => $todo]);
    }

    public function update(TodoRequest $request, $id)
    {
      $inputs = $request->all();
      $todo = $this->todo->find($id);
      $todo->fill($inputs)->save();

      return redirect()->route('todo.show', $todo->id);
    }

    public function messages()
    {
      return [
        'content.required' => 'ToDoが入力されていません。',
        'content.max' => 'ToDoは :max 文字以内で入力してください。',
        ];

    }

    public function delete($id)
    {
      $todo = $this->todo->find($id);
      $todo->delete();

      return redirect()->route('todo.index');
      
    }
}

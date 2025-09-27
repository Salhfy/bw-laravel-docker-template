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
        // dd($todos);→これもインスタンスを返している


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

    public function store(Request $request)
    {

      $inputs = $request->all();

      // dd($inputs);
      // array:2 [▼
      //           "_token" => "Ht9P0bGoBeUkE4aRYLnMXxVQztveMnBjB8EFXIfN"
      //            "content" => "aa"
      //         ]
      // フォームから送られてきたデータを全て配列として取得
      $todo = new Todo();
      // dd($todo);
      // App\Todo {#232 ▶}
      $todo->content = $inputs['content'];
      // dd($inputs['content']);
      // "aa"
      $todo->fill($inputs);//→マスアサインメント対策、指定されたカラムだけを挿入(ホワイトリスト方式)
      // dd($inputs);→array:2 [▶]
      $todo->save();//SQL文を実行、Eloquentクラスによってパラメータのバインドが自動で行われる


      return redirect()->route('test.index');
    }

    public function show($id)
    {
      $model = new Todo();
      $todo = $model->find($id);

      return view('todo.show', ['todo' => $todo]);
    }

}

<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Events\OrderStatusUpdate;
use App\Events\TaskCreated;
use App\Task;

class Order{
    public $id;
    public function __construct($id){
    $this->id=$id;
}
}

Route::get('/', function () {
  //(event = new order())
    return view('welcome');
});

Route::get('/update', function(){
    OrderStatusUpdate::dispatch(new Order(7));
});

Route::get('/tasks', function(){
    //latest = zorgt voor een descending order.
   return Task::latest()->pluck('body');
});
Route::post('/tasks', function(){
    //db aanmaak
    $task = Task::forceCreate(request(['body']));
    //laravel echo connection
    //afvuren van een event
    event((new TaskCreated($task))->dontBroadcastToCurrentUser());
});

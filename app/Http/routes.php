<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use Illuminate\Http\Request;
use App\Transactions;

Route::get('/', function () {
    try {
        $tarnsaction = App\Transactions::all();
    }catch (PDOException $e){
        return "ERROR: Don't connect DB";
    }
    $data = array(
        "transaction" => $tarnsaction
    );

    return view('welcome',$data);
});
Route::get("/show/{id}", function($id){
    $tarnsaction = App\Transactions::find($id);
    $data = array(
        "transaction" => $tarnsaction
    );
    $tax = $tarnsaction -> sum * 18/118;
    return view("transaction", $data, ["tax" => round($tax, 2)]);
});

Route::get("/delete/{id}", function ($id){
    $transaction = App\Transactions::find($id);
    $deleted = DB::delete("delete from transactions where id = ?", [$id]);
    if ($deleted == true){
        return redirect("/");
    }

});

Route::put("/", function (Request $request){
    $name = $request->input("name");
    $sum = $request->input("sum");
    $note = $request->input("note");

    $tansaction = new Transactions();
    $tansaction -> name = $name;
    $tansaction -> sum = $sum;
    $tansaction -> note = $note;
    $tansaction->save();


    //echo $tansaction;
});
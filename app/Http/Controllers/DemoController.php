<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DemoController extends Controller
{
    public function index(){
        return view("demoindex");
    }
    public function index2(){
        $data = "testDemo2";
        return view("demoindex2",compact("data"));
    }

    public function index3(){
        return response()->json([
            'status' => true,
            'data'=>[
                'name'=> 'Sản phẩm 1',
                'price'=> 24000
            ]
        ]);
    }

    public function index4($id){
        $data = "ABCDDDD";
        return view("demoindex4",compact("data",'id'));
    }

    public function index5($id = null){
        $data = "ABCDDDD";
        dump($id);
        #dd($id);
        return view("demoindex5",compact("data",'id'));
    }

    public function index6($id = null){
        $data = "Minh Dong";
        $pr1 = "MSSV";
        $pr2 = "2124110316";
        return view("demoindex6",compact("data",'id','pr1','pr2'));
    }
}

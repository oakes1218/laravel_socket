<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

use App\Http\Requests;

class MessageController extends Controller
{
    protected $player = array();
    protected $result = array();

    public function view() {

        return view('socket');
    }

    public function message(Request $request) {

        $name = $request->input("user");
        $msg = $request->input("msg");
        $doPlay = $request->input("doplay");
        DB::table('play_result')->insert(['name' => $name, 'doPlay' => $doPlay]);
        $this->result = DB::table('play_result')->orderBy('id', 'desc')->limit(2)->get();
//        dd($this->result);
        if (empty($this->result[1]) || floor($this->result[0]->id/2) != floor($this->result[1]->id/2)) {
            return;
        }
//        dd($this->result);
        if (count($this->result) == 2) {
            if ($this->result[0]->name == $this->result[1]->name) {
                $this->player['error'] = '同一人不可猜拳';
            } else {
                $this->player[$this->result[0]->name] = $this->result[0]->doPlay;
                $this->player[$this->result[1]->name] = $this->result[1]->doPlay;
                if ($this->player[$this->result[0]->name] == 'scissors' && $this->player[$this->result[1]->name] == 'scissors') {
                    $this->player['result'] = $this->result[0]->name.$this->result[1]->name.'平手';
                } else if ($this->player[$this->result[0]->name] == 'stone') {
//                    dd($this->player);
                    $this->player['result'] = $this->result[0]->name.'WIN'.$this->result[1]->name.'LOSE';
                } else {
                    $this->player['result'] = $this->result[0]->name.'LOSE'.$this->result[1]->name.'WIN';
                }
                if ($this->player[$this->result[0]->name] == 'stone' && $this->player[$this->result[1]->name] == 'stone') {
                    $this->player['result'] = $this->result[0]->name.$this->result[1]->name.'平手';
                } else if ($this->player[$this->result[0]->name] == 'paper') {
                    $this->player['result'] = $this->result[0]->name.'WIN'.$this->result[1]->name.'LOSE';
                } else {
                    $this->player['result'] = $this->result[0]->name.'LOSE'.$this->result[1]->name.'WIN';
                }

                if ($this->player[$this->result[0]->name] == 'paper' && $this->player[$this->result[1]->name] == 'paper') {
                    $this->player['result'] =$this->result[0]->name.$this->result[1]->name.'平手';
                } else if ($this->player[$this->result[0]->name] == 'scissors') {
                    $this->player['result'] = $this->result[0]->name.'WIN'.$this->result[1]->name.'LOSE';
                } else {
                    $this->player['result'] = $this->result[0]->name.'LOSE'.$this->result[1]->name.'WIN';
                }
            }
            event(new \App\Events\MyEventNameHere($name, $msg, (array)$this->player));
            unset($this->result);
            unset($this->player);
        }
    }
}

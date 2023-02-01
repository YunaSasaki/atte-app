<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Stamp;
use App\Models\Rest;
use App\Models\User;

class ViewController extends Controller
{
    public function home()
    {
        $user = Auth::user();
        $now = Carbon::now();

        // 勤務中か否か
        $stamp = Stamp::where('user_id', $user->id)
        ->where('stamp_date', $now->format('Y-m-d'))
        ->where('end_work', null)
        ->first();
        $work_flg = $stamp != null;

        // 休憩中か否か
        if ($work_flg) {
            $rest = Rest::where('stamp_id', $stamp->id)
                ->latest()
                ->where('rest_date', $now->format('Y-m-d'))
                ->where('end_rest', null)
                ->first();
            $rest_flg = $rest != null;
        }

        // ボタンのon/off切り替え
        $workSwitch = [
            'work_start' => $work_flg ? 'off' : 'on',
            'work_end' => $work_flg ? 'on' : 'off',
        ];
        if ($work_flg) {
            $restSwitch = [
                'rest_start' => $rest_flg ? 'off' : 'on',
                'rest_end' => $rest_flg ? 'on' : 'off',
            ];
        } else {
            $restSwitch = [
                'rest_start' => 'off',
                'rest_end' => 'off',
            ];
        }

        // メッセージの設定
        $message = [
            'clear' => '',
            'error' => '',
        ];

        $param = array_merge(['user' => $user], $message, $workSwitch, $restSwitch);

        return view('home', $param);
    }

    public function attendance()
    {   
        $stamps = Stamp::Paginate(5);

        // 勤務時間の計算
        $workTimes = array();
        foreach ($stamps as $stamp){
            $start_work = strtotime($stamp->stamp_date.$stamp->start_work);
            $end_work = strtotime($stamp->stamp_date.$stamp->end_work);
            $work_calc = $end_work - $start_work;
            $work_hour = floor($work_calc / 3600);
            $work_minute = floor(($work_calc % 3600) / 60);
            $work_second = ($work_calc % 3600) % 60;
            $workTime = sprintf('%02d', $work_hour). ':'. sprintf('%02d', $work_minute). ':'. sprintf('%02d', $work_second);
            array_push($workTimes, $workTime);
            unset($workTime);
        }

        // 休憩時間の計算・・・同じstamp_idでまとめたい
        $restTimes = array();
        foreach ($stamps as $stamp) {
            $start_rest = strtotime($stamp->rests->rest_date. $stamp->rests->start_rest);
            $end_rest = strtotime($stamp->rests->rest_date. $stamp->rests->start_rest);
            $rest_calc = $end_rest - $start_rest;
            $rest_hour = floor($rest_calc / 3600);
            $rest_minute = floor(($rest_calc % 3600) / 60);
            $rest_second = ($rest_calc % 3600) % 60;
            $restTime = sprintf('%02d', $rest_hour) . ':' . sprintf('%02d', $rest_minute) . ':' . sprintf('%02d', $rest_second);
            array_push($restTimes, $restTime);
            unset($restTime);
        }




        return view('attendance', ['stamps' => $stamps, 'workTimes' => $workTimes]);
    }
}

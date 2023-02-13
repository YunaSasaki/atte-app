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

    public function attendance(Request $request)
    {
        $stamp_date = $request['stamp_date'];
        $stamps = Stamp::where('stamp_date', $stamp_date)
            ->paginate(5);
        $stamps->appends(['stamp_date' => $stamp_date]);

        $restTimes = array();
        $workTimes = array();

        foreach ($stamps as $stamp) {
            // 休憩時間の計算
            $rests = Rest::where('stamp_id', $stamp->id)
                ->get();
            $restTime_array = array();
            foreach ($rests as $rest) {
                if (empty($rest->end_rest)){
                    $restTime_sub = 0;
                }else{
                    $start_rest = strtotime($rest->rest_date . $rest->start_rest);
                    $end_rest = strtotime($rest->rest_date . $rest->end_rest);
                    $restTime_sub = $end_rest - $start_rest;
                }
                array_push($restTime_array, $restTime_sub);
            }
            $restTime_total = array_sum($restTime_array);
            $restTime_h = floor($restTime_total / 3600);
            $restTime_i = floor(($restTime_total % 3600) / 60);
            $restTime_s = ($restTime_total % 3600) % 60;
            $restTime = sprintf('%02d', $restTime_h) . ':' . sprintf('%02d', $restTime_i) . ':' . sprintf('%02d', $restTime_s);
            array_push($restTimes, $restTime);


            // 勤務時間の計算
            if (empty($stamp->end_work)){
                $workTime = '00:00:00';
            }else{
            $start_work = strtotime($stamp->stamp_date . $stamp->start_work);
            $end_work = strtotime($stamp->stamp_date . $stamp->end_work);
            $workTime_sub = $end_work - $start_work - $restTime_total;
            $workTime_h = floor($workTime_sub / 3600);
            $workTime_i = floor(($workTime_sub % 3600) / 60);
            $workTime_s = ($workTime_sub % 3600) % 60;
            $workTime = sprintf('%02d', $workTime_h) . ':' . sprintf('%02d', $workTime_i) . ':' . sprintf('%02d', $workTime_s);
            }
            array_push($workTimes, $workTime);
        }

        return view('attendance', ['stamps' => $stamps, 'stamp_date' => $stamp_date, 'workTimes' => $workTimes, 'restTimes' => $restTimes]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Stamp;

class StampController extends Controller
{
    public function start()
    {
        $user = Auth::user();
        $now = Carbon::now();

        // 勤務開始が押せる条件
        // （１）出勤していない

        // （１）出勤していない
        $oldStamp = Stamp::where('user_id', $user->id)
            ->where('stamp_date', $now->format('Y-m-d'))
            ->first();
        $work_flg = $oldStamp == null;

        // 勤務開始の処理
        if ($work_flg) {
            $newStamp = [
                'user_id' => $user->id,
                'start_work' => $now->format('H:i:s'),
                'stamp_date' => $now->format('Y-m-d'),
            ];
            Stamp::create($newStamp);
        }

        // メッセージとボタンのon/off切り替え
        $message = [
            'clear' => $work_flg ? '出勤打刻が完了しました！' : '',
            'error' => $work_flg ? '' : 'すでに本日の出勤打刻がされています',
        ];
        $workSwitch = [
            'work_start' => 'off',
            'work_end' => 'on',
        ];
        $restSwitch = [
            'rest_start' => 'on',
            'rest_end' => 'off',
        ];

        $param = array_merge(['user' => $user], $message, $workSwitch, $restSwitch);

        return view('home', $param);
    }

    public function end()
    {
        $user = Auth::user();
        $now = Carbon::now();

        // 勤務終了が押せる条件
        // （１）出勤しており、退勤していない

        // （１）出勤しており、退勤していない
        $stamp = Stamp::where('user_id', $user->id)
            ->where('stamp_date', $now->format('Y-m-d'))
            ->where('end_work', null)
            ->first();
        $work_flg = $stamp != null;

        // 休憩終了の処理
        if ($work_flg) {
            $stamp->update(['end_work' => $now->format('H:i:s')]);
        }

        // メッセージとボタンのon/off切り替え
        $message = [
            'clear' => $work_flg ? '退勤打刻が完了しました！' : '',
            'error' => $work_flg ? '' : 'すでに退勤しているか、出勤していません',
        ];
        $workSwitch = [
            'work_start' => 'on',
            'work_end' => 'off',
        ];
        $restSwitch = [
            'rest_start' => 'off',
            'rest_end' => 'off',
        ];

        $param = array_merge(['user' => $user], $message, $workSwitch, $restSwitch);

        return view('home', $param);
    }
}

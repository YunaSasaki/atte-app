<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Stamp;
use App\Models\Rest;

class RestController extends Controller
{
    public function start()
    {
        $user = Auth::user();
        $now = Carbon::now();

        // 休憩開始が押せる条件
        // （１）出勤しており、退勤していない
        // （２）休憩終了していないデータがない

        // （１）出勤しており、退勤していない
        $stamp = Stamp::where('user_id', $user->id)
            ->where('stamp_date', $now->format('Y-m-d'))
            ->where('end_work', null)
            ->first();
        $work_flg = $stamp != null;

        // (２)休憩終了していないデータがない
        if ($work_flg) {
            $oldRest = Rest::where('stamp_id', $stamp->id)
                ->latest()
                ->where('rest_date', $now->format('Y-m-d'))
                ->where('end_rest', null)
                ->first();
            $rest_flg = $oldRest == null;
        }

        // 休憩開始の処理
        if ($work_flg && $rest_flg) {
            $newRest = [
                'stamp_id' => $stamp->id,
                'start_rest' => $now->format('H:i:s'),
                'rest_date' => $now->format('Y-m-d'),
            ];
            Rest::create($newRest);
        }

        // メッセージとボタンのon/off切り替え
        if ($stamp == null) {
            $message = [
                'clear' => '',
                'error' => 'すでに退勤しているか、出勤していません',
            ];
            $workSwitch = [
                'work_start' => 'on',
                'work_end' => 'off',
            ];
            $restSwitch = [
                'rest_start' => 'off',
                'rest_end' => 'off',
            ];
        }
        if ($work_flg) {
            $message = [
                'clear' => $rest_flg ? '休憩開始しました！' : '',
                'error' => $rest_flg ? '' : '休憩終了が押されていません',
            ];
            $workSwitch = [
                'work_start' => 'off',
                'work_end' => 'on',
            ];
            $restSwitch = [
                'rest_start' => 'off',
                'rest_end' => 'on',
            ];
        }

        $param = array_merge(['user' => $user], $message, $workSwitch, $restSwitch);

        return view('home', $param);
    }

    public function end()
    {
        $user = Auth::user();
        $now = Carbon::now();

        // 休憩開始が押せる条件
        // （１）出勤しており、退勤していない
        // （２）休憩終了していないデータがある

        // （１）出勤しており、退勤していない
        $stamp = Stamp::where('user_id', $user->id)
            ->where('stamp_date', $now->format('Y-m-d'))
            ->where('end_work', null)
            ->first();
        $work_flg = $stamp != null;

        // (２)休憩終了していないデータがある
        if ($work_flg) {
            $rest = Rest::where('stamp_id', $stamp->id)
                ->latest()
                ->where('rest_date', $now->format('Y-m-d'))
                ->where('end_rest', null)
                ->first();
            $rest_flg = $rest != null;
        }

        // 休憩終了の処理
        if ($work_flg && $rest_flg) {
            $rest->update(['end_rest' => $now->format('H:i:s')]);
        }

        // メッセージとボタンのon/off切り替え
        if ($stamp == null) {
            $message = [
                'clear' => '',
                'error' => 'すでに退勤しているか、出勤していません',
            ];
            $workSwitch = [
                'work_start' => 'on',
                'work_end' => 'off',
            ];
            $restSwitch = [
                'rest_start' => 'off',
                'rest_end' => 'off',
            ];
        }
        if ($work_flg) {
            $message = [
                'clear' => $rest_flg ? '休憩終了しました！' : '',
                'error' => $rest_flg ? '' : 'すでに休憩終了しているか、休憩開始していません',
            ];
            $workSwitch = [
                'work_start' => 'off',
                'work_end' => 'on',
            ];
            $restSwitch = [
                'rest_start' => 'on',
                'rest_end' => 'off',
            ];
        }

        $param = array_merge(['user' => $user], $message, $workSwitch, $restSwitch);

        return view('home', $param);
    }
}
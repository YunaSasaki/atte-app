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
        $stamps = Stamp::Paginate(1);
        return view('attendance', ['stamps' => $stamps]);
        

        
        
        

    }
}

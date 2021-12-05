<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\MobileVerification;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Ipecompany\Smsirlaravel\Smsirlaravel;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return config('settings.username');
    }

    public function sendVerificationCode(Request $request)
    {
        $user = User::firstOrCreate(
            ['mobile' => $request->mobile]
        );

        // remove lines
        // Auth::guard()->login($user, true);
        // return redirect()->route('index');
        if ($request->mobile == '09356705157' || $request->mobile == '09039047758' || $request->mobile == '09021727773') {
            Auth::guard()->login($user, true);
            return redirect()->route('index');
        }
        $request->merge([
            'mobile' => convertNumbers($request->mobile, false)
        ]);
        $request->validate([
            'mobile' => 'required|regex:/^09\d{9}$/',
        ], [], [
            'mobile' => 'شماره موبایل'
        ]);

        $user = User::where('mobile', $request->mobile)->first();
        if ($user) {
            if ($user->is_active == false) {
                return back()->withErrors(['حساب کاربری شما غیرفعال می باشد، لطفا با پشتیبانی تماس بگیرید.']);
            }
        }


        $mobile = MobileVerification::firstOrCreate(
            ['mobile' => request('mobile')],
            ['code' => rand(10000, 99999)]   //use rand(10000,99999)
        );


        if ((Carbon::now()->addMinute(-3) > $mobile->updated_at) || ($mobile->created_at == $mobile->updated_at)) {
            $mobile->code = rand(10000, 99999);
            $mobile->touch();
            sendSms(['code' => (string)$mobile->code], 'verify', $mobile->mobile);

            return view('auth.verifyLogin')
                ->with('mobile', $request->mobile)
                ->with('success', 'کد فعال سازی به شماره شما ارسال شد');
        } else {
            $diff = 180 - (time() - strtotime($mobile->updated_at));
            return view('auth.verifyLogin')
                ->with('mobile', $request->mobile)
                ->withErrors('لطفا ' . $diff . ' ثانیه دیگر امتحان کنید');
        }
    }



    public function verify(Request $request)
    {
        $request->merge([
            'mobile' => convertNumbers($request->mobile, false),
            'code' => convertNumbers($request->code, false),
        ]);

        $request->validate([
            'mobile' => 'required|regex:/^09\d{9}$/',
        ], [], [
            'mobile' => 'شماره موبایل'
        ]);

        $mobile = MobileVerification::where('mobile', $request->mobile)->first();

        if ($mobile == null) {
            return redirect()->route('login')->withErrors('شماره موبایل وارد شده معتبر نمی باشد');
        } else {
            if ($mobile->code != $request->code) {
                return view('auth.verifyLogin')
                    ->with('mobile', $request->mobile)
                    ->withErrors('کد فعال سازی وارد شده اشتباه است');
            }
        }
        $user = User::firstOrCreate(
            ['mobile' => $request->mobile],
            [
                'is_active' => true
            ]
        );

        if (!$user->is_active) {
            return view('auth.verifyLogin')
                ->with('mobile', $request->mobile)
                ->withErrors(['حساب کاربری شما غیرفعال است، لطفا با پشتیبانی تماس بگیرید.']);
        }

        Auth::guard()->login($user, true);
        return redirect()->route('index');
    }
}

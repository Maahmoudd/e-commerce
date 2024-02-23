<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Services\Frontend\OrderService;
use App\Models\CodSetting;
use App\Models\GeneralSetting;
use App\Models\RazorpaySetting;
use App\Models\StripeSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\FlareClient\Api;
use Stripe\Charge;
use Stripe\Stripe;

class OtherPaymentController extends Controller
{
    protected $orderService;
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function payWithStripe(Request $request)
    {

        // calculate payable amount depending on currency rate
        $stripeSetting = StripeSetting::first();
        $total = getFinalPayableAmount();
        $payableAmount = round($total * $stripeSetting->currency_rate, 2);

        Stripe::setApiKey($stripeSetting->secret_key);
        $response = Charge::create([
            "amount" => $payableAmount * 100,
            "currency" => $stripeSetting->currency_name,
            "source" => $request->stripe_token,
            "description" => "product purchase!"
        ]);

        if($response->status === 'succeeded'){
            $this->orderService->store('stripe', 1, $response->id, $payableAmount, $stripeSetting->currency_name);
            // clear session
            $this->orderService->clearSession();

            return redirect()->route('user.payment.success');
        }else {
            toastr('Something went wrong try again later!', 'error', 'Error');
            return redirect()->route('user.payment');
        }

    }

    /** Razorpay payment */
    public function payWithRazorPay(Request $request)
    {
        $razorPaySetting = RazorpaySetting::first();
        $api = new Api($razorPaySetting->razorpay_key, $razorPaySetting->razorpay_secret_key);

        // amount calculation
        $total = getFinalPayableAmount();
        $payableAmount = round($total * $razorPaySetting->currency_rate, 2);
        $payableAmountInPaisa = $payableAmount * 100;

        if($request->has('razorpay_payment_id') && $request->filled('razorpay_payment_id')){
            try{
                $response = $api->payment->fetch($request->razorpay_payment_id)
                    ->capture(['amount' => $payableAmountInPaisa]);
            }catch(\Exception $e){
                toastr($e->getMessage(), 'error', 'Error');
                return redirect()->back();
            }


            if($response['status'] == 'captured'){
                $this->orderService->store('razorpay', 1, $response['id'], $payableAmount, $razorPaySetting->currency_name);
                // clear session
                $this->orderService->clearSession();

                return redirect()->route('user.payment.success');
            }

        }
    }

    /** pay with cod */
    public function payWithCod(Request $request)
    {
        $codPaySetting = CodSetting::first();
        $setting = GeneralSetting::first();
        if($codPaySetting->status == 0){
            return redirect()->back();
        }

        // amount calculation
        $total = getFinalPayableAmount();
        $payableAmount = round($total, 2);


        $this->orderService->store('COD', 0, Str::random(10), $payableAmount, $setting->currency_name);
        // clear session
        $this->orderService->clearSession();

        return redirect()->route('user.payment.success');


    }

}

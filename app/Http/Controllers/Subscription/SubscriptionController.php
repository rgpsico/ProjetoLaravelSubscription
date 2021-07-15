<?php

namespace App\Http\Controllers\Subscription;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
   public function __construct()
   {
       $this->middleware(['auth']);
       
   }

   public function checkout(Request $request)
   {
       if(auth()->user()->subscribed('default'))
       {
        return view('subscription.premium');
       }
         
     return view('subscriptions.index',[
         'intent'=>auth()->user()->createSetupIntent()]
        );

    } 
       
       
   public function store(Request $request)
   {
       $request->user()
       ->newSubscription('default','price_1JDGUcBOmvZWJe0xm7x3YIvq')
       ->create($request->token);
       return redirect()->route('subscription.premium');
   }

   public function premium()
   {  
        return view('subscription.premium');
   }

   
   public function account()
   {
       $invoices = auth()->user()->invoices();
       return view('subscription.account',compact('invoices'));
   }

   public function invoiceDownload($invoiceID)
   {
       return Auth::user()->downloadInvoice($invoiceID,[
           'vendor' => config('app.name'),
           'product' => 'Assinatura Vip'
       ]);
     
   }

   public function cancel()
   {
        Auth::user()->subscription('default')->cancel();
        return redirect()->route('subscriptions.account');     
   }

   public function resume()
   {
        Auth::user()->subscription('default')->resume();
        return redirect()->route('subscriptions.account');     
   }
   


}

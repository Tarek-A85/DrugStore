<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;
use App\Models\Medicine;
use App\Models\Category;
use App\Models\Caliber;
use App\Models\Company;
use App\Models\Order;
use App\Models\Pharmacy;
use App\Models\User;
use App\Models\Status;
use Carbon\Carbon;
use App\Models\CompanyMedicie;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserNotification;
use App\Http\ResponseTrait;

use Auth;

class AdminController extends Controller
{
    use ResponseTrait;
    public function login(Request $request){
        $credits=$request->only('email','password');
        if(!Auth::attempt(['email'=>$request->email,'password'=>$request->password,'is_admin'=>true]))
        return $this->Error("There is No Admin With These Credentials");
      $user=Auth::user();
      $token=$user->createToken("myapptoken")->plainTextToken;
      return $this->Data("You Are Logged In ",['token'=>$token]);
    }

  

    public function insert(Request $request){
      $category=Category::where('name',$request->category)->first();
      $medicine=Medicine::where('scientific_name',$request->scientific_name)->first();
      if(!$medicine)
      $medicine=Medicine::create([
        "scientific_name"=>$request->scientific_name,
        "category_id"=>$category->id,
      ]);
      $company=Company::where('name',$request->company)->first();
      $full=CompanyMedicie::where('commercial_name',$request->commercial_name)->first();
      $caliber=null;
      if($full)
      $caliber=$full->calibers->where('caliber',$request->caliber)->first();
    else
    $full=CompanyMedicie::create([
     'commercial_name'=>$request->commercial_name,
     'medicine_id'=>$medicine->id,
     'company_id'=>$company->id,
    ]);
    if($caliber){
      $caliber->update([
        'company_medicine_id'=>$full->id,
        'price'=>$request->price,
        'quantity'=>$caliber->quantity+$request->quantity,
        'total_quantity'=>$caliber->total_quantity+$request->quantity,
        'expiration_date'=>$request->expiration_date,
      ]);
    }
    else{
     $caliber= Caliber::create([
        'company_medicine_id'=>$full->id,
        'caliber'=>$request->caliber,
        'price'=>$request->price,
        'quantity'=>$request->quantity,
        'total_quantity'=>$request->quantity,
        'expiration_date'=>$request->expiration_date,
      ]);
    }
     
  
      if(!$caliber||!$full||!$company||!$medicine||!$category)
      return $this->Error("Something Went Wrong");
    
    return $this->Success("The Medicine Has Been Inserted");
    }

   


    public function all_orders(){
      $orders=Order::with('details')->has('details')->get()->reverse()->values();
      foreach($orders as $ord){
        $phar=Pharmacy::find($ord->pharmacy_id);
        $status=Status::find($ord->status_id);
        $ord->status=$status->name;
        $street=$phar->address;
        $region=$street->parent;
        $city=$region->parent;
        $ord->pharmacy_name=$phar->name;
        $ord->street=$street->name;
        $ord->region=$region->name;
        $ord->city=$city->name;
      }
      return $this->Data(" ",$orders);
    }
 
    public function change_status(Request $request){
      
      $order=Order::find($request->order_id);
      $status=Status::where('name',$request->status)->first();
      $order->update(['status_id'=>$status->id]);
      if($status->name=='Sent'){
        $orders=$order->details;
        foreach($orders as $or){
          $caliber=Caliber::find($or->caliber_id);
          $caliber->update([
            'quantity'=>$caliber->quantity-$or->quantity
          ]);
        }
      }
      $id=$order->pharmacy->user_id;
      $user=User::find($id);
   
    $user->notify(new UserNotification($order->id,$status->name) );

      return $this->Success("Status Changed");
    }
    public function change_payment(Request $request){
      $order=Order::find($request->order_id);
      $pay=0;
      if($request->payment=='Paid')
      $pay=1;
      $order->update(['paid'=>$pay]);
      return $this->Success("Payment Changed");

    }

    public function admin_report(Request $request){
      $start=new Carbon($request->first_date);
      $start=$start->toDateString();
      $end=new Carbon($request->second_date);
      $end=$end->toDateString();
      $all=Order::get();
      $filtered=[];
      $recieved=0;
      $counter=0;
      $sent=0;
      $preparing=0;
      $sales=0;
      foreach($all as $a){
        $cr=$a->created_at->toDateString();
        if(($cr>=$start&&$cr<=$end)){
            $status=Status::find($a->status_id);
            $phar=Pharmacy::find($a->pharmacy_id);
            $a->status=$status->name;
            $a->status=$status->name;
            $street=$phar->address;
            $region=$street->parent;
            $city=$region->parent;
            $a->pharmacy_name=$phar->name;
            $a->street=$street->name;
            $a->region=$region->name;
            $a->city=$city->name;
            if($status->name=="Received")
            $recieved++;
           else if($status->name=="Sent")
           $sent++;
        else if($status->name=="Preparing")
        $preparing++;
            $counter++;
            $sales+=$a->price;
             $a->details;
             array_push($filtered,$a);
        }
}
  if(!count($filtered))
  return $this->Success("Nothing to show");

  

    return $this->Data("report",[
      "preparing"=>$preparing,
      "recieved"=>$recieved,
      "sent"=>$sent,
      "counter"=>$counter,
      "sales"=>$sales,
      "orders"=>$filtered,
    ]);
    }

  
   


}

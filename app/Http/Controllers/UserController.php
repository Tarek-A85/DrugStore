<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use App\Models\Pharmacy;
use App\Models\Address;
use App\Models\Category;
use App\Models\Medicine;
use App\Models\Caliber;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Favorite;
use App\Models\Status;
use Illuminate\Support\Facades\Notification;
use App\Models\CompanyMedicie;
use App\Notifications\UserNotification;
use App\Notifications\AdminNotification;
use Illuminate\Support\Facades\DB;
use App\Models\OrderDetails;
use Auth;
use Carbon\Carbon;
use App\Http\ResponseTrait;
use App\Http\Resources\CompanyResource;
use Illuminate\Validation\Rule;


class UserController extends Controller
{
    use ResponseTrait;
    public function register(Request $request){
        $validator=Validator::make($request->all(),[
            'phone_number'=>Rule::unique('users')->where(fn ($query) => $query->where('is_admin', false)),
            'password'=>'confirmed'
        ]);
        if($validator->fails()){
           return $this->Error($validator->errors());
        }
        $user=User::create([
            'name'=>$request->name,
            'phone_number'=>$request->phone_number,
            'password'=>bcrypt($request->password),
        ]);
        $pharmacy=Pharmacy::create([
            'name'=>$request->pharmacy_name,
            'user_id'=>$user->id,
            'address_id'=>Address::where('name',$request->street)->first()->id,
        ]);
        if(!$user||!$pharmacy)
        return $this->Error("Something Went Wrong");
        $token=$user->createToken('myapptoken')->plainTextToken;
        return $this->Data("User Successfully Registered",['token'=>$token]);
    }
    public function login(Request $request){
        $credits=$request->only(['phone_number','password']);
        if(!Auth::attempt(['phone_number'=>$request->phone_number,'password'=>$request->password,'is_admin'=>false]))
        return $this->Error("No User With These Credentials");
        $user=auth()->user();
        $token=$user->createToken('myapptoken')->plainTextToken;
        return $this->Data("You Are Logged In",['token'=>$token]);
    }


    public function Profile(){
        $user=Auth::user();
        $pharmacy=$user->pharmacy;
       $street=$user->pharmacy->address;
       $region=$street->parent;
       $city=$region->parent;

       $user->pharmacy_name=$user->pharmacy->name;
       $user->city=$city->name;
       $user->region=$region->name;
       $user->street=$street->name;
       
      $user=$user->only(['name','phone_number','token','city','region','street','pharmacy_name']);
      return $this->Data("Profile",$user);
    }

    
    public function Editprofile(Request $request){
      $user=auth()->user();
      $user->update([
            'name'=>$request->name,
            'phone_number'=>$request->phone_number,
      ]);
      $user->pharmacy->update([
            'name'=>$request->pharmacy_name,
            'user_id'=>$user->id,
            'address_id'=>Address::where('name',$request->street)->first()->id,
      ]);
      return $this->Success("Profile Edited");
    }


    public function add_favorite(Request $request){
        $user=auth()->user();
        $med=CompanyMedicie::where('commercial_name',$request->commercial_name)->first();
        $caliber=$med->calibers->where('caliber',$request->caliber)->first();
        $fav=Favorite::create([
            'user_id'=>$user->id,
            'caliber_id'=>$caliber->id,
        ]);
        return $this->Success("Medicine added to favorite");
    }

    public function favorites(){
        $user=auth()->user();
       $favs=Favorite::where('user_id',$user->id)->with('caliber')->get();
        return $this->Data(" ",$favs);
    }

    public function remove_favorite(Request $request){
        $user=auth()->user();
        $med=CompanyMedicie::where('commercial_name',$request->commercial_name)->first();
        $caliber=$med->calibers->where('caliber',$request->caliber)->first();
       $fav=Favorite::where([
        ['user_id',$user->id],
        ['caliber_id',$caliber->id]
        ])->first();
       $fav->delete();
        return $this->Success("Medicine Deleted");
    }


    public function to_cart(Request $request){
        $user=auth()->user();
        $id=auth()->user()->id;
        $added=$user->carts->where('commercial_name',$request->commercial_name)->where('caliber',$request->caliber)->first();
        if($added)
        return $this->Success('Medicine already added');
        $cart=Cart::create([
            'user_id'=>auth()->user()->id,
            'commercial_name'=>$request->commercial_name,
            'caliber'=>$request->caliber,
            'quantity'=>$request->quantity
        ]);
        if(!$cart)
        return $this->Error("Something Went Wrong");
        else
        return $this->Success("Medicine added to cart");
    }

    public function from_cart(){
        $id=auth()->user()->id;
        $user=User::find($id);
        $cart=$user->carts;
        return $this->Data("All medicines in cart",$cart);
    }
    public function delete_cart(Request $request){
        $cart=Cart::find($request->id);
        $cart->delete();
        return $this->Success("Medicine deleted from cart");
    }

    public function order(Request $request){
        $arr=$request->arr;
        $order=Order::create([
            'pharmacy_id'=>auth()->user()->pharmacy->id,
            'price'=>0,
            'status_id'=>Status::where('name','Preparing')->first()->id,
            'paid'=>false,
        ]);
        $total=0;
        foreach($arr as $element){
            $cart=Cart::find($element['id']);
           $med=CompanyMedicie::where('commercial_name',$cart->commercial_name)->first();
           $caliber=$med->calibers->where('caliber',$cart->caliber)->first();
           $details=OrderDetails::create([
            'order_id'=>$order->id,
            'quantity'=>$element['quantity'],
            'caliber_id'=>$caliber->id,
           ]);
           $total+=$element['quantity']*$caliber->price;
           $cart->delete();
        }
        $order->update(['price'=>$total]);
        $admins=User::where('is_admin',true)->get();
        $status=Status::find($order->status_id);
        Notification::send($admins,new UserNotification($order->id,$status->name));
        return $this->Success("Your Order has been sent");
    }
  
   
    
    public function show_orders(){
        $phar=auth()->user()->pharmacy;
        $all=$phar->orders;
        foreach($all as $a){
           $status=Status::find($a->status_id);
           $a->status=$status->name;
            $a->details;
        }
       $all= $all->reverse()->values();
        return $this->Data("User Orders",$all);

    }

    public function user_report(Request $request){
          $start=new Carbon($request->first_date);
          $start=$start->toDateString();
         $end=new Carbon($request->second_date);
         $end=$end->toDateString();
         $phar=auth()->user()->pharmacy;
         $all=$phar->orders;
         $filtered=[];
        $recieved=0;
        $counter=0;
        foreach($all as $a){
            $cr=$a->created_at->toDateString();
            if(($cr>=$start&&$cr<=$end)){
                $status=Status::find($a->status_id);
                $a->status=$status->name;
                if($status->name=="Received")
                $recieved++;
            
                $counter++;
                 $a->details;
                 array_push($filtered,$a);
            }
}
      if(!count($filtered))
      return $this->Success("Nothing to show");
        return $this->Data("report", [
            "recieved"=>$recieved,
            "counter"=>$counter,
           "orders"=> $filtered
    ]);
        
    }

  

   
   



  
   


   
   

    
   
}

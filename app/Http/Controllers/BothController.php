<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\ResponseTrait;
use App\Models\Category;
use App\Models\CompanyMedicie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
class BothController extends Controller
{
    use ResponseTrait;
    public function logout(){
        auth()->user()->tokens()->delete();
        return $this->Success("You Are Logged out");
    }
    public function all(){
        $categories=Category::with('commercial')->get();
        return $this->Data("Every Medicine ",$categories);
        }
    public function details(Request $request){
        $med=CompanyMedicie::where('commercial_name',$request->commercial_name)->first();
        $sceintific=$med->medicine->scientific_name;
        $comp=$med->my_company->name;
        $med->scientific_name=$sceintific;
        $med->company=$comp;
        $caliber=$med->calibers->where('caliber',$request->caliber)->first();
        $med->price=$caliber->price;
        $med->quantity=$caliber->quantity;
        $med->expiration_date=$caliber->expiration_date;
        $med->status=$caliber->status;
        $med=$med->only(['scientific_name','company','price','quantity','status','expiration_date']);
        return $this->Data("Medicine Info ",$med);
    }
    public function notifications(){
       $user=auth()->user();
       $notifications=$user->unreadNotifications;
       $counter=$notifications->count();
       $notifications=$notifications->pluck('data');
       $response=array();
       $response['counter']=$counter;
       $response['orders']=$notifications;
       return $this->Data("notifications",$response);
    }

    public function read(Request $request){
        $order_id=$request->order_id;
        $status=$request->status;
        $notification=DB::table('notifications')->where([
            ['notifiable_id',auth()->user()->id],
            ['data->order_id',$order_id],
            ['data->status',$status],
            ])->update(['read_at' => now()]);
        return $this->Success("notification marked read");
    }
}

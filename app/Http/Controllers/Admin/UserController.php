<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Hash;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    { 
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

	
	public function storeList(){
		
		$result=User::orderBy('id','DESC')->get();

		return view('admin.user.list',compact('result'));
	}
	

	public function addStore(Request $request){

		if($request->isMethod('post')){
			
			$rules=[
				'id'=>'numeric|required',
				'name'=>'required',
				'email' => 'unique:users,email,' . $request->post('id'),
				'domain'=>'required'
			];

			if(($request->post('id') ==0)){

				$rules['password']='required';
			}
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()){
				$message = "";
				$messages_l = json_decode(json_encode($validator->messages()), true);
				foreach ($messages_l as $msg) {
					$message= $msg[0];
					break;
				}
				
				return response(array('message'=>$message),403);
				
			}else{
				
				if((int) $request->post('id')>0){
					
					$user=User::find($request->post('id'));

				}else{
					
					$user=new User();
				
				}
				
				$user->name=$request->post('name');
				$user->email=$request->post('email');
				$user->status='1';
				$user->domain=$request->post('domain');

				if($request->post('password')){

					$user->password=Hash::make($request->post('password'));
				}
				
				$user->save();
				
				if((int) $request->post('id')==0){
					
					return response(array('message'=>'Store Created successfully.','reset'=>true),200);
				}else{
					
					return response(array('message'=>'Store updated successfully.','reset'=>false),200);
				
				} 
			}
			return response(array('message'=>'Data not found.'),403);
		}
		
		$result=[];
        return view('admin.user.add',compact('result'));
    }
	
	public function subadminList(){

		$result=User::orderBy('id','DESC')->get();
		
		return view('admin.user.list',compact('result'));
	}
	
	public function updateStore(Request $request,$id){
		
		$result=User::where([
			['id',$id]
		])->first();
		
		if($result){
			 
			return view('admin.user.add',compact('result'));
			
		}else{
			
			return redirect()->back()->with('5fernsadminerror','Something went wrong. Please try again.');
		}
		
	}
	
	public function deleteStore(Request $request,$id){
		
		$result=Testimonial::find($id);
		
		if($result){
			
			Testimonial::where('id',$id)->update(['recyclebin_status'=>'1','recyclebin_datetime'=>date('Y-m-d H:i:s')]);
			
			return redirect()->back()->with('5fernsadminsuccess','Testimonial deleted successfully.');
			
		}else{
			
			return redirect()->back()->with('5fernsadminerror','Something went wrong. Please try again.');
		}
		
	}
	
	public function changeStatus(Request $request){
		
		User::where('id',$request->post('id'))->update(['status'=>$request->post('status')]);

		return response(array('message'=>'Status changed successfully.'),200);
	}
	
	

}

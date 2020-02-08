<?php
namespace App\Http\Controllers\portal\Leaves;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LeaveMaster;
use App\Models\EmployeeProfile;
use App\Models\Portal;
use App\Models\EmployeeLeaveStatus;
use Session\session;
use Auth;
use App\User;
use Log;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index()
    {
        
            $portal=Portal::where('user_id',(Auth::user()->id))->first();
            $leave_list=LeaveMaster::where('portal_id',$portal->id)->where('is_active',1)->get();
            return view('portal.leaveType.index',compact('leave_list','portal'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function leaveStatus()
    {
    
        $portal=Portal::select('id')->where('user_id',Auth::id())->first();         
        $leave_data = EmployeeLeaveStatus::where('portal_id',$portal->id)->get();
        return view('portal.leaveType.leavestatus',compact('EmpData','leave_data'));
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   	
        
            $leave_type=$request->input('leave_type');
            $no_of_leaves=$request->input('no_of_leaves');
            $portal_id=Auth::user()->getPortal->id;
          
            $data=LeaveMaster::where('leave_type',$leave_type)->first();
            //dd($data);
            if(isset($data))
            {
                $request->session()->flash('error_message', 'Leave type is already exists');
                return back();
               
            }
           else {
                    $Save_leave=new LeaveMaster();
                    $Save_leave->portal_id=$portal_id;
                    $Save_leave->leave_type=$request->input('leave_type');
                    $Save_leave->number_of_leaves=$no_of_leaves;
                    $Save_leave->save();
                    $request->session()->flash('success_message', 'Leave created successful!');
                    return back();
            }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $updateData = $request->all();
       $leave_type=$request->input('leave_type');
        $number_of_leaves=$request->input('no_of_leaves');
        
       
        
		        $update_data = LeaveMaster::where('id',$updateData['update_id'])->update([
		        'leave_type'=>$leave_type,
		        'number_of_leaves'=>$number_of_leaves,
		        ]);
		        $request->session()->flash('success_message','Leave update Successfully!!');
		        return back();
		   }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $updateData = $request->all();
        //dd($updateData);
        $update_data = LeaveMaster::where('id',$updateData['delete_id'])->
        update(['is_active'=>0]);
        $request->session()->flash('error_message','Leave delete Successfully!!');
        return back();
    }


public function checkleave($leave_type,$no_of_leave)
    {
         
         
          $data = LeaveMaster::where('leave_type', $leave_type)->where('number_of_leaves',$no_of_leave)->where('is_active',1)->count();
          return response()->json($data);
          if($data > 0)
           echo 'not_unique';
          else
           echo 'unique';
          
         
    }
    // public function checkleaves($id,$company_id)
    // {

    //         $leave=LeaveMaster::where('company_id',NULL)->where('id',$id)->first();
    //        $leave_type= $leave->leave_type;
        
    //       $data = LeaveMaster::where('leave_type','=',$leave_type)->where('company_id','=',$company_id)->where('is_active',1)->count();
          
    //       if($data > 0)
    //        echo 'not_unique';
    //       else
    //        echo 'unique';
          
    //      }

          public function check($leavemaster,$portal_id)
        {

            $data=LeaveMaster::where('portal_id',$portal_id)->where('leave_type','=',$leavemaster)->where('is_active',1)->count(); 
           if($data > 0)
            echo 'not_unique';
           else
           echo 'unique';
          
         }


}



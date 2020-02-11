<?php
namespace App\Observers;

use App\Models\EmployeeProfile;
use App\Notifications\IndentNotify;
use App\Models\IndentMaster;
use App\User;

class IndentObserver
{

    /**
     * Called whenever a post is created
     * @param IndentMaster $indent
     */
    public function created(IndentMaster $indent)
    {

//        $user_id=EmployeeProfile::where('created',$indent->emp_id)->first();
        $user =User::findOrFail($indent->created_by);

        foreach ($user->followers as $follower) {
            $follower->notify(new IndentNotify($user, $indent));
        }
    }
}
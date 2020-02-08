<?php

namespace App;

use App\Models\Portal;
use Illuminate\Notifications\Notifiable;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function getPortal()
    { 
        if(Auth::user()->user_type=="employee"){
            return $this->hasOne('App\Models\EmployeeProfile','user_id','id');
        }
        if(Auth::user()->user_type=="vendor"){
            return $this->hasOne('App\Models\VishwaVendorsRegistration','user_id','id');
        }
        return $this->hasOne('App\Models\Portal','user_id','id');
    }
    public function getVendor()
    {
        return $this->hasOne('App\Models\VishwaVendorsRegistration','user_id','id');
    }

    public function getImage()
    {
        return $this->hasOne('App\Models\Portal','user_id','id');
    }

    public function getImageVendor()
    {
        return $this->hasOne('App\Models\VishwaVendorsRegistration','user_id','id');
    }
    public function getImageEmp()
    {
        return $this->hasOne('App\Models\EmployeeProfile','user_id','id');
    }
    public function getEmp()
    {
        return $this->hasOne('App\Models\EmployeeProfile','user_id','id');
    }
        public function projects()
    {
        return $this->belongsToMany('App\Entities\Projects\Project', 'jobs', 'worker_id')
            ->groupBy('worker_id')
            ->groupBy('project_id');
    }
  

    public function leads()
    {
        return $this->hasMany(Lead::class)->with('user', 'team');
    }

 

   




    public function teams()
    {
        return $this->belongsToMany(Team::class, 'memberships')->withPivot('admin');
    }
    

    public function settings()
    {
        //return UserSettings::firstOrCreate(["user_id" => $this->id]);
        return $this->hasOne(UserSettings::class)->withDefault();
    }

    public function teamsTickets()
    {
        return Ticket::join('memberships', 'tickets.team_id', '=', 'memberships.team_id')
                       ->where('memberships.user_id', $this->id)->select('tickets.*');
        //return $this->belongsToMany(Ticket::class, "memberships", "team_id", "team_id");
        //return $this->hasManyThrough(Ticket::class, Membership::class,"user_id","team_id")->with('requester','user','team');
    }

    public function teamsLeads()
    {
        return Lead::join('memberships', 'leads.team_id', '=', 'memberships.team_id')
                ->where('memberships.user_id', $this->id)->select('leads.*');
    }

    public function teamsMembers()
    {
        return User::join('memberships', 'users.id', '=', 'memberships.user_id')
                     ->whereIn('memberships.team_id', $this->teams->pluck('id'))->select('users.*');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function uncompletedTasks()
    {
        return $this->hasMany(Task::class)->where('completed', false);
    }

    public function todayTasks()
    {
        return $this->hasMany(Task::class)->where('completed', false)->where('datetime', '<', Carbon::tomorrow());
    }

    /**
     * @deprecated
     *
     * @param $notification
     */
    public static function notifyAdmins($notification)
    {
        Admin::notifyAll($notification);
    }

    /**
     * @deprecated
     *
     * @param $notification
     */
    public static function notifyAssistants($notification)
    {
        Assistant::notifyAll($notification);
    }

    public function getTeamsTicketsAttribute()
    {
        return $this->teamsTickets()->get();
    }

    public function getRocode(){

        if(Auth::user()->user_type=='admin' ||Auth::user()->user_type=='portal' ){

            $data= $this->hasOne(Portal::class,'user_id','id');

            $data=$data->join('users','users.id','=','vishwa_portals.user_id')
                ->select('user_id')
                ->first();

//            $a=$data->first();

            $rodata = $data->hasOne(User::class,'id','user_id');

            return $rodata;



        }else{
            return "error";
        }



    }


}

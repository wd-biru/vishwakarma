<?php

namespace App\Exports\Models;

use App\Models\EmployeeProfile;
use App\Entities\Projects\Project;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Excel;
use DB;

class EmployeeExport implements FromQuery,WithHeadings,Responsable,ShouldAutoSize,WithEvents,WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
     *
   */

    use Exportable;

    private $fileName = 'invoices.xlsx';

    private $writerType = Excel::XLSX;

    private $headers = [
        'Content-Type' => 'text/csv',
    ];


    public function headings(): array {
    return [

        "First Name",
        "Last Name",
        "Gender",
        "Status",
        "Phone"	,
        "Other Phone"	,
        "Address	",
        "Date Of Birth	",
        "Marital Status	",
        "Personal Email	",
        "Emergency Contact",
        "Emergency Telephone	",
        "Postal Code",
        "Town",
        "ID_Number",
        "Nationality"	,
        "Date Of Joining",
        "Department Name	",
        "Designation Name	",
        "Created At	",


    ];
    }

    public function query()
    {
        $portal_id=Auth::user()->getPortal->id;
        $employeeData=EmployeeProfile::query()
                    ->select('*')
                    ->join('vishwa_department_master','vishwa_employee_profile.department_id','=','vishwa_department_master.id')
                    ->join('vishwa_designation_master','vishwa_employee_profile.designation_id','=','vishwa_designation_master.id')
                    ->join('vishwa_portals','vishwa_employee_profile.portal_id','=','vishwa_portals.id')
                    ->where('vishwa_employee_profile.portal_id',$portal_id)
                    ->select('vishwa_employee_profile.*','vishwa_department_master.department_name as dep','vishwa_designation_master.designation as deg');



        return $employeeData;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:Z1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
            },
        ];
    }


    public function map($emp): array
    {
        
        return [

                        $emp-> first_name ,
                        $emp-> last_name,
                        $emp-> gender,
                        $emp-> status,
                        $emp->phone ,
                        $emp-> other_phone 	,
                        $emp-> address	 ,
                        $emp-> dob	 ,
                        $emp-> Marital_status	 ,
                        $emp-> Personal_email	 ,
                        $emp-> Emergency_contact ,
                        $emp-> Emergency_tel	 ,
                        $emp-> Postal_code	 ,
                        $emp-> Town	 ,
                        $emp-> Id_number ,
                        $emp-> Nationality 	,
                        $emp-> date_of_joining ,
                        $emp-> dep,
                        $emp-> deg	 ,
                        $emp-> created_at	 ,

        ];
    }
}

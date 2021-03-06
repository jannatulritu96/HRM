<?php

namespace App\Exports;

use App\Attendence;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AttendenceExport implements FromQuery, WithHeadings
{
    protected $user_id;
    public function __construct($user_id)
    {
        $this->user_id= $user_id;
    }

    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return Attendence::query()->select('id','date','in_time','out_time','status')->where('user_id',$this->user_id);
    }
    /*public function collection()
    {
        return Attendence::all();
    }*/
    public function headings(): array
    {
        return [
            'Serial',
            'Date',
            'In Time',
            'Out Time',
            'Status'
        ];
    }
}

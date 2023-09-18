<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UserList implements FromCollection,WithHeadings,WithMapping
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }
    public function headings(): array
    {
        $heading = [
            'Time Checkin',
            'Name',
            'Email',
            'Phone',
            'Đơn vị công tác',
            'Chức vụ',
            'Công Ty',
            'Booth done'
        ];
        return $heading;

    }

    public function map($data): array
    {
        $ops = [
            0 => '---',
            1 => 'Cơ quan nhà nước/ Chính phủ',
            2 => 'Media - đối tác truyền thông',
            3 => 'Cá nhân khác'
        ];
        $a = (int) optional($data->user)->organization;

        $map = [
            $data->created_at,
            optional($data->user)->name,
            optional($data->user)->email,
            optional($data->user)->phone,
            in_array($a, [0,1,2,3]) ? $ops[$a] : '',
            optional($data->user)->position,
            optional($data->user)->company,
            '99',
        ];

        return $map;
    }
}

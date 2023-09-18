<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Models\Event\{TaskEvent, UserJoinEvent};

class UserList implements FromCollection,WithHeadings,WithMapping
{
    protected $data;
    protected $index = 0;

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
            'No',
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

        $booth = TaskEvent::whereTaskId($data->task_id)->whereType(1)->first();
        $jobDone = 0;
        if ($booth) {
            $jobDone = UserJoinEvent::select('*')
                ->where('task_event_id', $booth->id)
                ->whereUserId($data->user_id)
                ->count();
        }

        $map = [
            ++$this->index,
            $data->created_at,
            optional($data->user)->name,
            optional($data->user)->email,
            optional($data->user)->phone,
            in_array($a, [0,1,2,3]) ? $ops[$a] : '',
            optional($data->user)->position,
            optional($data->user)->company,
            $jobDone,
        ];

        return $map;
    }
}

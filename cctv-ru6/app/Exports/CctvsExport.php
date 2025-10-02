<?php

namespace App\Exports;

use App\Models\Cctv;
use Maatwebsite\Excel\Concerns\FromCollection;

class CctvsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Cctv::select('id','name','rtsp_url','status','building_id','room_id','latitude','longitude','last_seen_at')->get();
    }
}

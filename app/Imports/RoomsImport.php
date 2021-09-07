<?php

namespace App\Imports;

use App\Models\HallRoom;
use Maatwebsite\Excel\Concerns\ToModel;

class RoomsImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model( array $row )
    {
        return new HallRoom( [
            'room_no'        => $row[1],
            'seat_count'     => $row[2],
            'available_seat' => $row[3],
        ] );
    }
}

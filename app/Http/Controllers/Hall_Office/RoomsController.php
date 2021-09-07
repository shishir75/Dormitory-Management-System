<?php

namespace App\Http\Controllers\Hall_Office;

use App\Http\Controllers\Controller;
use App\Imports\RoomsImport;
use App\Models\Hall;
use App\Models\HallRoom;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class RoomsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hall = Hall::where( 'name', Auth::user()->name )->first();

        $rooms = HallRoom::all();

        return view( 'hall_office.rooms.index', compact( 'hall', 'rooms' ) );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view( "hall_office.rooms.create" );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store( Request $request )
    {
        if ( $request->hasFile( 'file' ) ) {
            $file = $request->file( 'file' );

            $data = Excel::toArray( new RoomsImport(), $file );

            $hall = Hall::select( 'id' )->where( 'name', Auth::user()->name )->first();

            //$session_id = $request->session_id;

            if ( !empty( $data ) && count( $data ) > 0 ) {

                foreach ( $data as $rows ) {
                    foreach ( $rows as $key => $value ) {
                        if ( $key > 3 ) {
                            $hallRoom = new HallRoom();

                            $check = HallRoom::where( 'hall_id', $hall->id )->where( 'room_no', $value[1] )->count();

                            if ( $check > 0 ) {
                                continue;

                            } else {

                                $hallRoom->room_no = $value[1];
                                $hallRoom->seat_count = $value[2];
                                $hallRoom->available_seat = $value[3];
                                $hallRoom->hall_id = $hall->id;
                                $hallRoom->save();
                            }
                        }
                    }
                }

                Toastr::success( 'Rooms List added successfully', 'Success' );

                return redirect()->route( 'hall_office.rooms.index' );
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show( $id )
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit( $id )
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
    public function update( Request $request, $id )
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id )
    {
        //
    }
}

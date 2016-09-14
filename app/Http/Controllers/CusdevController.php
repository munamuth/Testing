<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\tbl_customer;
use App\tbl_cus_device;
use App\tbl_device;

class CusdevController extends Controller
{

    private $cus, $cus_dev, $dev, $join;
    public function __construct( tbl_cus_device $cus_dev, tbl_customer $cus, tbl_device $dev ){
        $this->cus_dev = $cus_dev;
        $this->join = $this->cus_dev
                        ->join('tbl_customers', 'tbl_cus_devices.cus_id_for', '=', 'tbl_customers.cus_id')
                        ->join('tbl_devices', 'tbl_cus_devices.dev_id_for', '=', 'tbl_devices.dev_id');
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $device = $request->all();
        $insert = $this->cus_dev->insert( $device );
        if( !$insert ){
            return Response()->json([
                'STATUS' => false,
                'MESSAGE' => 'Insert not success',
                'CODE' => 404
            ], 200);
        } else{
            return Response()->json([
                'STATUS' => true,
                'MESSAGE' => 'success',
                'CODE' => 200,
            ], 200);
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
        $device = $this->join->where('cus_dev_id', $id )->first();
        if( !$device ){
            return Response()->json([
                'STATUS' => false,
                'MESSAGE' => 'Data not found.',
                'CODE' => 404
            ], 200);
        } else {
            return Response()->json([
                'STATUS' => true,
                'MESSAGE' => 'success',
                'DATA' => $device,
            ], 200);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $update = $this->join->where('cus_dev_id', $id )->first();
        if( !$update ){
            return Response()->json([
                'STATUS' => false,
                'MESSAGE' => 'Insert not success',
                'CODE' => 404
            ], 200);
        } else {
            $this->cus_dev->where('cus_dev_id', $id )->update([
                'dev_id_for' => $request->get('dev_id_for'), 
                'local_ip' => $request->get('local_ip'), 
                'public_ip' => $request->get('public_ip'), 
                'port' => $request->get('port'), 
                'username' => $request->get('username'),
                'password' => $request->get('password'),
            ]);
            return Response()->json([
                'STATUS' => true,
                'MESSAGE' => 'success',
                'CODE' => 200,
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $device = $this->join->where('cus_dev_id', $id)->delete();
        if( !$device ){
            return Response()->json([
                'STATUS' => false,
                'MESSAGE' => 'DATA NOT FOUND',
                'CODE' => 404,
            ], 200);
        } else {
            return Response()->json([
                'STATUS' => true,
                'MESSAGE' => 'data founded',
                'CODE' => 200,
            ], 200);
        }
    }
    public function listCusDevices( $id, $page, $limit ){
        $page = preg_replace ( '#[^0-9]#', '', $page );
        $item = preg_replace ( '#[^0-9]#', '', $limit );
        $id = preg_replace ( '#[^0-9]#', '', $id );
        $offset = $page * $item - $item;        
        
        $count = $this->join->where('cus_id_for', $id )->count();
        $totalpage = 0;

        if ($count % $item > 0){
            $totalpage = floor( $count / $item ) + 1;
        }else {
            $totalpage = $count / $item ;
        }
        
        $pagination = [
        
                'TOTALPAGE'     => $totalpage ,
                'TOTALRECORD'   => $count ,
                'CURRENTPAGE'   => $page,
                'SHOWITEM'      => $item
        ];

        $cusDev = $this->join
                        ->where('cus_id_for', $id)
                        ->orderBy('cus_dev_id', 'desc')
                        ->skip($offset)
                        ->take( $item )
                        ->get();
        if( !$cusDev || $page > $totalpage ){
            return Response()->json([
                'STATUS' => false,
                'MESSAGE' => 'Insert not success',
                'CODE' => 404
            ], 200);
        } else {
            return Response()->json([
                'STATUS' => true,
                'MESSAGE' => 'success',
                'DATA' => $cusDev,
                'PAGINATION' => $pagination,
            ], 200);
        }

    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\tbl_device;
class DeviceController extends Controller
{
	private $dev;
   	public function __construct( tbl_device $dev )
   	{
   		$this->dev = $dev;
   	}
   	public function index()
   	{
   		return view('app.device');
   	}

   	public function store(Request $request)
   	{
   		$device = $request->all();
        $insert = $this->dev->insert( $device );
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

   	public function update(Request $request, $id)
    {
        $update = $this->dev->where('dev_id', $id)->first();
        if( !$update ){
            return Response()->json([
                'STATUS' => false,
                'MESSAGE' => 'Insert not success',
                'CODE' => 404
            ], 200);
        } else {
            $update = $this->dev->where('dev_id', $id)->update([
                'dev_name' => $request->get('dev_name'),
                'dev_model' => $request->get('dev_model'),
            ]);
            return Response()->json([
                'STATUS' => true,
                'MESSAGE' => 'success',
                'CODE' => 200,
            ], 200);
        }
    }

   	public function destroy($id)
    {   
        $device = $this->dev->where('dev_id', $id)->delete();
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
    public function show($id)
    {
        $device = $this->dev->where('dev_id', $id )->first();
        if( !$device ){
            return Response()->json([
                'STATUS' => false,
                'MESSAGE' => 'data not founded',
                'CODE' => 404
            ], 200);
        } else {
            return Response()->json([
                'STATUS' => true,
                'MESSAGE' => 'Data founded',
                'DATA' => $device,
            ], 200);
        }
    }


    public function listDevice( $page, $limit)
    {
    	$page = preg_replace ( '#[^0-9]#', '', $page );
    	$item = preg_replace ( '#[^0-9]#', '', $limit );
    	$offset = $page * $item - $item;    	
    	
    	$count = $this->dev->count();
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

    	$device = $this->dev
    		->orderBy('dev_id', 'desc')
    		->skip($offset)
    		->take( $item )
    		->get();
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
                'DATA' => $device,
                'PAGINATION' => $pagination,
            ], 200);
        }
    }
    /* f
	
    */
    function search( $page, $limit, $key ){
    	$page = preg_replace ( '#[^0-9]#', '', $page );
    	$item = preg_replace ( '#[^0-9]#', '', $limit );
    	$offset = $page * $item - $item;    
    	$count = $this->dev->where('dev_name', 'like', $key.'%')->count();

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

    	$device = $this->dev
    		->where('dev_name', 'like', $key.'%')
    		->orderBy('dev_id', 'desc')
    		->skip($offset)
    		->take( $item )
    		->get();
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
                'DATA' => $device,
                'PAGINATION' => $pagination,
            ], 200);
        }
    }
}

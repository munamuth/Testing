<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\tbl_device;
use App\tbl_customer;
use App\tbl_cus_device;
class CustomerController extends Controller
{
    private $dev, $cus, $cus_dev;
    public function __construct( tbl_device $dev, tbl_customer $cus, tbl_cus_device $cus_dev )
    {
        $this->dev = $dev;
        $this->cus = $cus;
        $this->cus_dev = $cus_dev;

        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request )
    {
        $device = $this->dev->get();

        if( $this->cus->count() == 0 ){
            $cus_id = 1;
        } else {            
            $newCustomer = $this->cus->orderBy('cus_id', 'desc')->select('cus_id')->first();
            $cus_id = $newCustomer->cus_id + 1;
        }
        if( $this->cus_dev->count() == 0 ){

            $cus_dev_id = 1;

        } else {

            $cus_dev = $this->cus_dev->orderBy('cus_dev_id', 'desc')->select('cus_dev_id')->first();
            $cus_dev_id = $cus_dev->cus_dev_id + 1;

        }
        return view('app.index', compact('device', 'cus_id', 'cus_dev_id') );
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
        $customer = $request->all();
        $insert = $this->cus->insert( $customer );
        if( !$insert ){
            return Response()->json([
                'STATUS' => false,
                'MESSAGE' => 'Insert not success',
                'CODE' => 404
            ], 200);
        } else{
            return Response()->json([
                'STATUS' => false,
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
        $customer = $this->cus->where('cus_id', $id )->first();
        if( !$customer ){
            return Response()->json([
                'STATUS' => false,
                'MESSAGE' => 'data not founded',
                'CODE' => 404
            ], 200);
        } else {
            return Response()->json([
                'STATUS' => true,
                'MESSAGE' => 'Data founded',
                'DATA' => $customer,
            ], 200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(Request $request, $id)
    {
        $update = $this->cus->where('cus_id', $id)->first();
        if( !$update ){
            return Response()->json([
                'STATUS' => false,
                'MESSAGE' => 'Insert not success',
                'CODE' => 404
            ], 200);
        } else {
            $update = $this->cus->where('cus_id', $id)->update([
                'cus_name' => $request->get('cus_name'),
                'cus_addr' => $request->get('cus_addr'),
                'cus_phone' => $request->get('cus_phone'),
                'cus_email' => $request->get('cus_email'),
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
        $customer = $this->cus->where('cus_id', $id)->delete();
        if( !$customer ){
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

    public function listCustomer( $page, $limit)
     {
        $page = preg_replace ( '#[^0-9]#', '', $page );
        $item = preg_replace ( '#[^0-9]#', '', $limit );
        $offset = $page * $item - $item;        
        
        $count = $this->cus->count();
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

        $customer = $this->cus
                            ->orderBy('cus_id', 'desc')
                            ->skip($offset)
                            ->take( $item )
                            ->get();
        if( !$customer || $page > $totalpage ){
            return Response()->json([
                'STATUS' => false,
                'MESSAGE' => 'DATA NOT FOUND',
                'CODE' => 404,
            ], 200);
        } else {
            return Response()->json([
                'STATUS' => true,
                'MESSAGE' => 'data founded',
                'DATA' => $customer,
                'PAGINATION' => $pagination,
            ], 200);
        }
    }
    public function search( $page, $limit, $key )
    {
        $page = preg_replace ( '#[^0-9]#', '', $page );
        $item = preg_replace ( '#[^0-9]#', '', $limit );
        $offset = $page * $item - $item;        
        
        $count = $this->cus->where('cus_name', 'like', $key.'%')->count();
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

        $customer = $this->cus
                            ->where('cus_name', 'like', $key.'%')
                            ->orderBy('cus_id', 'desc')
                            ->skip($offset)
                            ->take( $item )
                            ->get();
        if( !$customer || $page > $totalpage ){
            return Response()->json([
                'STATUS' => false,
                'MESSAGE' => 'DATA NOT FOUND',
                'CODE' => 404,
            ], 200);
        } else {
            return Response()->json([
                'STATUS' => true,
                'MESSAGE' => 'data founded',
                'DATA' => $customer,
                'PAGINATION' => $pagination,
            ], 200);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use App\tbl_status;
use App\tbl_user_role;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    private $u, $s, $r, $user;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct( User $u, tbl_status $s, tbl_user_role $r)
    {
       $this->u = $u;
       $this->s = $s;
       $this->r = $r;

        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->u->get();
        $role = $this->r->get();
        return view('app.user', compact('users', 'role'));
    }
    public function destroy( $id ){
        $delete = $this->u->where('id', $id )->delete();
        if( !$delete ){
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

    public function store(Request $request)
    {
        $this->u->name = $request->txtName;
        $this->u->email = $request->txtEmail;
        $this->u->phone = $request->txtPhone;
        $this->u->password = bcrypt($request->txtPassword);
        $this->u->user_status = '1';
        $this->u->role_id_for = $request->txtRole;
        
        $this->u->save(); 

        \Session::flash('message','Muth');

        return back();    
    }
    public function update( UserRequest $request, $id )
    {
        $update = $this->u->where('id', $id)->update([
                'name' => $request->txtName,
                'email' => $request->txtEmail,
                'password' => bcrypt($request->txtPassword),
                'role_id_for' => $request->txtRole,
            ]);
        if( !$update ) {
            return back();
        } else {
            return back();
        }
    }
    public function login(){
        return view('auth.login');
    }
    public function listUser( $page, $limit)
    {
        $page = preg_replace ( '#[^0-9]#', '', $page );
        $item = preg_replace ( '#[^0-9]#', '', $limit );
        $offset = $page * $item - $item;        
        
        $count = $this->u->count();
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

        $user = $this->u
            ->orderBy('id', 'desc')
            ->skip($offset)
            ->take( $item )
            ->get();
        if( !$user ){
            return Response()->json([
                'STATUS' => false,
                'MESSAGE' => 'DATA NOT FOUND',
                'CODE' => 404,
            ], 200);
        } else {
            return Response()->json([
                'STATUS' => true,
                'MESSAGE' => 'data founded',
                'DATA' => $user,
                'PAGINATION' => $pagination,
            ], 200);
        }
    }

    public function edit( $id ) {
        $user = $this->u->where('id', $id)->first();
        $item = count($user);
        if( $item == 0 ){
            return Response()->json([
                'STATUS' => false,
                'MESSAGE' => 'DATA NOT FOUND',
                'CODE' => 404,
            ], 200);
        } else {
            return Response()->json([
                'STATUS' => true,
                'MESSAGE' => 'DATA FOUND',
                'DATA' => $user,
            ], 200);
        }
    }
}

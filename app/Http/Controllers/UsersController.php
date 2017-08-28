<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use App\Roles;
use Validator;

class UsersController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        return view('admin.Users.index')->with(compact(''));
    }

    public function user_management() {
        //echo "<pre>";print_r(Input::get());exit;
        $draw = Input::get('draw');
        $start = Input::get('start');
        $length = Input::get('length');

        if (Input::get('order') && Input::get('order') != "") {
            $order = Input::get('order');
            $columns = Input::get('columns');
            $orderby = $columns[$order[0]['column']]['data'];
            $orderdir = $order[0]['dir'];
        } else {
            $orderby = 'blog_category.id';
            $orderdir = 'desc';
        }


        $search = Input::get('search');
        $search = $search['value'];
        if ($search && $search != "") {
            $category = User::select('roles.id as role_id', 'roles.title', 'users.id', 'users.name', DB::raw('DATE_FORMAT(users.created_at, "%d-%m-%Y %H:%i:%s") as created_date'), DB::raw('DATE_FORMAT(users.updated_at, "%d-%m-%Y %H:%i:%s") as updated_date'),DB::raw('(CASE WHEN (users.status = "Yes") THEN "Active" ELSE "Inactive" END) as status'))
                    ->join('roles', function($join) {
                        $join->on('roles.id', '=', 'users.role_id');
                    })
                    ->where('users.name', 'like', $search . '%')
                    ->orWhere('roles.title', 'like', $search . '%')
                    ->orWhere('users.created_at', 'like', $search . '%')
                    ->orWhere('users.updated_at', 'like', $search . '%')
                    ->orWhere('users.id', $search)
                    ->skip($start)
                    ->take($length)
                    ->orderBy($orderby, $orderdir)
                    ->get()
                    ->toArray();
            $recordsTotalSearch = count($category);
            $recordsFilteredSearch = count($category);
        } else {
            $category = User::select('roles.id as role_id', 'roles.title', 'users.id', 'users.name', DB::raw('DATE_FORMAT(users.created_at, "%d-%m-%Y %H:%i:%s") as created_date'), DB::raw('DATE_FORMAT(users.updated_at, "%d-%m-%Y %H:%i:%s") as updated_date'),DB::raw('(CASE WHEN (users.status = "Yes") THEN "Active" ELSE "Inactive" END) as status'))
                    ->join('roles', function($join) {
                        $join->on('roles.id', '=', 'users.role_id');
                    })
                    ->skip($start)
                    ->take($length)
                    ->orderBy($orderby, $orderdir)
                    ->get()
                    ->toArray();
        }

        $data = [];
        foreach ($category as $da) {
            $action = '<a href="' . url("admin/menu/" . $da['id']) . '" class="btn btn-success btn-xs">Pages <i class="fa fa-arrow-right"></i></a> ';
            $action .= '<a id="edit-' . $da['id'] . '" data-token=' . csrf_token() . ' onclick="edit(' . $da['id'] . ');" class="btn btn-warning btn-xs">Edit <i class="fa fa-pencil"></i></a> ';
            //$action .= '<a id="delete-' . $da['id'] . '" data-token=' . csrf_token() . ' onclick="delete_blog(' . $da['id'] . ');" class="btn btn-danger btn-xs">Delete <i class="fa fa-trash"></i></a>';
            array_push($data, array_merge($da, ['action' => $action]));
        }
        if (isset($recordsTotalSearch) && isset($recordsFilteredSearch)) {
            $recordsTotal = $recordsTotalSearch;
            $recordsFiltered = $recordsFilteredSearch;
        } else {
            $recordsTotal = User::count();
            $recordsFiltered = User::count();
        }

        echo json_encode(['draw' => $draw, 'recordsTotal' => $recordsTotal, 'recordsFiltered' => $recordsFiltered, 'data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $role = [];
        $roles = Roles::all()->toArray();
        foreach ($roles as $r) {
            $role[$r['id']] = $r['title'];
        }
        return view('admin.Users.add')->with(compact('role'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'role_id' => 'required'
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->status = $request->status;
        $user->password = bcrypt($request->password);
        $user->save();
        return redirect('admin/user/management');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $role = [];
        $roles = Roles::all()->toArray();
        foreach ($roles as $r) {
            $role[$r['id']] = $r['title'];
        }

        $user = User::find($id);

        return view('admin.Users.edit')->with(compact('role', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|min:6|confirmed',
            'role_id' => 'required'
        ]);
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->status = $request->status;
        $user->password = bcrypt($request->password);
        $user->save();
        return redirect('admin/user/management');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

}

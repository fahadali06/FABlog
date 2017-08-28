<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Menu;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use App\User_Menu;

class MenuController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id) {
        $menus = [];
        $menu = Menu::all()->toArray();
        foreach ($menu as $m) {
            $menus[$m['id']] = $m['title'];
        }
        return view('admin.menu.index')->with(compact('menus', 'id'));
    }

    public function menu_ajax() {
        $id = Input::get('id');
        $draw = Input::get('draw');
        $start = Input::get('start');
        $length = Input::get('length');

        if (Input::get('order') && Input::get('order') != "") {
            $order = Input::get('order');
            $columns = Input::get('columns');
            $orderby = $columns[$order[0]['column']]['data'];
            $orderdir = $order[0]['dir'];
        } else {
            $orderby = 'user_menu.id';
            $orderdir = 'desc';
        }


        $search = Input::get('search');
        $search = $search['value'];
        if ($search && $search != "") {
            $category = Menu::select('menu.id', 'menu.title', DB::raw('DATE_FORMAT(menu.created_at, "%d-%m-%Y %H:%i:%s") as created_date'), DB::raw('DATE_FORMAT(menu.updated_at, "%d-%m-%Y %H:%i:%s") as updated_date'), 'menu.status')
                    ->join('user_menu', function($join){
                        $join->on('user_menu.menu_id', '=', 'menu.id');
                    })
                    ->where('menu.title', 'like', $search . '%')
                    ->where('user_menu.user_id', $id)
                    ->orWhere('menu.created_at', 'like', $search . '%')
                    ->orWhere('menu.updated_at', 'like', $search . '%')
                    ->orWhere('menu.id', $search)
                    ->skip($start)
                    ->take($length)
                    ->orderBy($orderby, $orderdir)
                    ->get()
                    ->toArray();
            $recordsTotalSearch = count($category);
            $recordsFilteredSearch = count($category);
        } else {
            $category = Menu::select('menu.id', 'menu.title', DB::raw('DATE_FORMAT(user_menu.created_at, "%d-%m-%Y %H:%i:%s") as created_date'), DB::raw('DATE_FORMAT(user_menu.updated_at, "%d-%m-%Y %H:%i:%s") as updated_date'), 'menu.status')
                    ->join('user_menu', function($join){
                        $join->on('user_menu.menu_id', '=', 'menu.id');
                    })
                    ->where('user_menu.user_id', $id)
                    ->skip($start)
                    ->take($length)
                    ->orderBy($orderby, $orderdir)
                    ->get()
                    ->toArray();
        }

        $data = [];
        foreach ($category as $da) {
            $action = "";
            //$action = '<a href="' . url("admin/menu/" . $da['id']) . '" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i> User rights</a> ';
//            $action .= '<a id="edit-' . $da['id'] . '" data-token=' . csrf_token() . ' onclick="edit(' . $da['id'] . ');" class="btn btn-warning btn-xs">Edit <i class="fa fa-pencil"></i></a> ';
            //$action .= '<a id="delete-' . $da['id'] . '" data-token=' . csrf_token() . ' onclick="delete_blog(' . $da['id'] . ');" class="btn btn-danger btn-xs">Delete <i class="fa fa-trash"></i></a>';
            array_push($data, array_merge($da, ['action' => $action]));
        }
        if (isset($recordsTotalSearch) && isset($recordsFilteredSearch)) {
            $recordsTotal = $recordsTotalSearch;
            $recordsFiltered = $recordsFilteredSearch;
        } else {
            $recordsTotal = Menu::count();
            $recordsFiltered = Menu::count();
        }

        echo json_encode(['draw' => $draw, 'recordsTotal' => $recordsTotal, 'recordsFiltered' => $recordsFiltered, 'data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $title = $request->title2;
        $x = 0;

        if (User_Menu::where('user_id', '=', $request->user_id)->exists()) {
            User_Menu::where('user_id', $request->user_id)->delete();
        }

        for ($i = 0; $i < count($title); $i++) {
            $menu = new User_Menu;
            $menu->menu_id = $title[$i];
            $menu->user_id = $request->user_id;
            $menu->save();
            $x++;
        }
        echo $x == count($title) ? "Success" : "error";
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
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

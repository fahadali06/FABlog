<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Blogs;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use App\BlogCategory;
use Illuminate\Support\Facades\Auth;

class BlogsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct() {
        $this->middleware('auth');
    }

    public function index($id) {
        $categoryname = BlogCategory::where('id', $id)->get()->first();
        return view('admin.blogs.blog.index')->with(compact('id', 'categoryname'));
    }

    public function blogs_ajax_list($id) {
        $draw = Input::get('draw');
        $start = Input::get('start');
        $length = Input::get('length');

        if (Input::get('order') && Input::get('order') != "") {
            $order = Input::get('order');
            $columns = Input::get('columns');
            $orderby = $columns[$order[0]['column']]['data'];
            $orderdir = $order[0]['dir'];
        } else {
            $orderby = 'blogs.id';
            $orderdir = 'desc';
        }


        $search = Input::get('search');
        $search = $search['value'];
        if ($search && $search != "") {
            $blogs = Blogs::select('blogs.id', 'blogs.title', 'users.name as user_id', DB::raw('DATE_FORMAT(blogs.created_at, "%d-%m-%Y %H:%i:%s") as created_date'), DB::raw('DATE_FORMAT(blogs.updated_at, "%d-%m-%Y %H:%i:%s") as updated_date'), 'blogs.description', 'blogs.links', 'blogs.image', 'blogs.path',DB::raw('(CASE WHEN (blogs.status = "Yes") THEN "Active" ELSE "Inactive" END) as status'))
                    ->join('users', function($join) {
                        $join->on('users.id', '=', 'blogs.user_id');
                    })
                    //->with('user')
                    ->where('blogs.blog_category', $id)
                    ->where('blogs.title', 'like', $search . '%')
                    ->orWhere('blogs.user_id', 'like', $search . '%')
                    ->orWhere('blogs.created_at', 'like', $search . '%')
                    ->orWhere('blogs.updated_at', 'like', $search . '%')
                    ->orWhere('blogs.id', $search)
                    ->skip($start)
                    ->take($length)
                    ->orderBy($orderby, $orderdir)
                    ->get()
                    ->toArray();
            $recordsTotalSearch = count($blogs);
            $recordsFilteredSearch = count($blogs);
        } else {
            $blogs = Blogs::select('blogs.id', 'blogs.title', 'users.name as user_id', DB::raw('DATE_FORMAT(blogs.created_at, "%d-%m-%Y %H:%i:%s") as created_date'), DB::raw('DATE_FORMAT(blogs.updated_at, "%d-%m-%Y %H:%i:%s") as updated_date'), 'blogs.description', 'blogs.links', 'blogs.image', 'blogs.path',DB::raw('(CASE WHEN (blogs.status = "Yes") THEN "Active" ELSE "Inactive" END) as status'))
                    ->join('users', function($join) {
                        $join->on('users.id', '=', 'blogs.user_id');
                    })
                    ->where('blogs.blog_category', $id)
                    ->skip($start)
                    ->take($length)
                    ->orderBy($orderby, $orderdir)
                    ->get()
                    ->toArray();
        }

        $data = [];
        foreach ($blogs as $da) {//public_path {{url("public/assets/upload/")}}' . $da['path'] . '/' . $da['image'] . '
            //$action = '<a href="' . url("admin/blogs/blog/" . $da['id']) . '" class="btn btn-success btn-xs">Blogs <i class="fa fa-arrow-right"></i></a> ';
            $image = '<img src="'.  ($da['image'] ? url("public/assets/upload/".$da['path']."/".$da['image']) : url("public/assets/upload/thumb.jpg")).'" width="30" height="30" />';
            $action = '<a id="edit-' . $da['id'] . '" data-token=' . csrf_token() . ' onclick="edit(' . $da['id'] . ');" class="btn btn-warning btn-xs">Edit <i class="fa fa-pencil"></i></a> ';
            $action .= '<a id="delete-' . $da['id'] . '" data-token=' . csrf_token() . ' onclick="delete_blog(' . $da['id'] . ');" class="btn btn-danger btn-xs">Delete <i class="fa fa-trash"></i></a>';
            array_push($data, array_merge($da, ['action' => $action, 'image' => $image]));
        }
        if (isset($recordsTotalSearch) && isset($recordsFilteredSearch)) {
            $recordsTotal = $recordsTotalSearch;
            $recordsFiltered = $recordsFilteredSearch;
        } else {
            $recordsTotal = Blogs::count();
            $recordsFiltered = Blogs::count();
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
        
        $blogs = new Blogs();
        $user = Auth::user();
        if ($request->title && $request->title) {
            $blogs->title = $request->title;
            $blogs->description = $request->description;
            $blogs->links = $request->links;
            $blogs->blog_category = $request->blog_category;
            $blogs->status = $request->status;
            $blogs->user_id = $user['id'];
            if ($request->image && !empty($request->image)) {
                $photoName = time() . '.' . $request->image->getClientOriginalExtension();
                $datefolder = 'images/blogs/' . date('m-Y');
                $request->image->move(public_path('assets/upload/' . $datefolder), $photoName);
                $blogs->path = $datefolder;
                $blogs->image = $photoName;
            }
            echo $blogs->save() ? "Success" : "error";
        }
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
        $blogs = Blogs::where('id', $id)->get()->first();
        echo json_encode($blogs);
        exit();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $user = Auth::user();
        if ($request->title && $request->title != "") {
            $data = ['title' => $request->title, 'user_id' => $user['id'], 'description' => $request->description, 'links' => $request->links, 'status' => $request->status];
            if ($request->image && !empty($request->image)) {
                $photoName = time() . '.' . $request->image->getClientOriginalExtension();
                $datefolder = 'images/blogs/' . date('m-Y');
                $request->image->move(public_path('assets/upload/' . $datefolder), $photoName);
                $data['image'] = $photoName;
                $data['path'] = $datefolder;
            }
            $blogs = Blogs::where('id', $id)->update($data);
            echo $blogs ? "Success" : "error";
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $blogs = Blogs::findOrFail($id);
        $blogs->delete();
        echo $blogs ? "Success" : "error";
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\BlogCategory;
use App\User;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BlogCategoryController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct() {
        $this->middleware('auth', ['except' => ['category']]);
    }

    public function index() {
        $title = 'Blog Category List';
        return view('admin.blogs.category.index')->with(compact('title'));
    }

    public function category_ajax_list() {
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
            $category = BlogCategory::select('blog_category.id', 'blog_category.title', 'users.name as user_id', DB::raw('DATE_FORMAT(blog_category.created_at, "%d-%m-%Y %H:%i:%s") as created_date'), DB::raw('DATE_FORMAT(blog_category.updated_at, "%d-%m-%Y %H:%i:%s") as updated_date'),DB::raw('(CASE WHEN (blog_category.status = "Yes") THEN "Active" ELSE "Inactive" END) as status'))
                    ->join('users', function($join) {
                        $join->on('users.id', '=', 'blog_category.user_id');
                    })
                    //->with('user')
                    ->where('blog_category.title', 'like', $search . '%')
                    ->orWhere('blog_category.user_id', 'like', $search . '%')
                    ->orWhere('blog_category.created_at', 'like', $search . '%')
                    ->orWhere('blog_category.updated_at', 'like', $search . '%')
                    ->orWhere('blog_category.id', $search)
                    ->skip($start)
                    ->take($length)
                    ->orderBy($orderby, $orderdir)
                    ->get()
                    ->toArray();
            $recordsTotalSearch = count($category);
            $recordsFilteredSearch = count($category);
        } else {
            $category = BlogCategory::select('blog_category.id', 'blog_category.title', 'users.name as user_id', DB::raw('DATE_FORMAT(blog_category.created_at, "%d-%m-%Y %H:%i:%s") as created_date'), DB::raw('DATE_FORMAT(blog_category.updated_at, "%d-%m-%Y %H:%i:%s") as updated_date'),DB::raw('(CASE WHEN (blog_category.status = "Yes") THEN "Active" ELSE "Inactive" END) as status'))
                    ->join('users', function($join) {
                        $join->on('users.id', '=', 'blog_category.user_id');
                    })
                    ->skip($start)
                    ->take($length)
                    ->orderBy($orderby, $orderdir)
                    ->get()
                    ->toArray();
        }

        $data = [];
        foreach ($category as $da) {
            $action = '<a href="' . url("admin/blogs/blog/" . $da['id']) . '" class="btn btn-success btn-xs">Blogs <i class="fa fa-arrow-right"></i></a> ';
            $action .= '<a id="edit-' . $da['id'] . '" data-token=' . csrf_token() . ' onclick="edit(' . $da['id'] . ');" class="btn btn-warning btn-xs">Edit <i class="fa fa-pencil"></i></a> ';
            $action .= '<a id="delete-' . $da['id'] . '" data-token=' . csrf_token() . ' onclick="delete_blog(' . $da['id'] . ');" class="btn btn-danger btn-xs">Delete <i class="fa fa-trash"></i></a>';
            array_push($data, array_merge($da, ['action' => $action]));
        }
        if (isset($recordsTotalSearch) && isset($recordsFilteredSearch)) {
            $recordsTotal = $recordsTotalSearch;
            $recordsFiltered = $recordsFilteredSearch;
        } else {
            $recordsTotal = BlogCategory::count();
            $recordsFiltered = BlogCategory::count();
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

        //echo "<pre>";print_r($request->image->getClientOriginalName());exit;
        $blogcategory = new BlogCategory;
        $user = Auth::user();
        if ($request->title && $request->title) {
            $blogcategory->title = ucfirst($request->title);
            $blogcategory->status = $request->status;
            $blogcategory->user_id = $user['id'];
            if ($request->image && !empty($request->image)) {
                $photoName = time() . '.' . $request->image->getClientOriginalExtension();
                $datefolder = 'images/category/' . date('m-Y');
                $request->image->move(public_path('assets/upload/' . $datefolder), $photoName);
                $blogcategory->path = $datefolder;
                $blogcategory->image = $photoName;
            }
            echo $blogcategory->save() ? "Success" : "error";
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
        $blogcategory = BlogCategory::where('id', $id)->get()->first();
        echo json_encode($blogcategory);
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
            $data = ['title' => ucfirst($request->title), 'user_id' => $user['id'], 'status' => $request->status];
            if ($request->image && !empty($request->image)) {
                $photoName = time() . '.' . $request->image->getClientOriginalExtension();
                $datefolder = 'images/category/' . date('m-Y');
                $request->image->move(public_path('assets/upload/' . $datefolder), $photoName);
                $data['image'] = $photoName;
                $data['path'] = $datefolder;
            }
            $blogcategory = BlogCategory::where('id', $id)->update($data);
            echo $blogcategory ? "Success" : "error";
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $blogcategory = BlogCategory::findOrFail($id);
        $blogcategory->delete();
        echo $blogcategory ? "Success" : "error";
    }
    
    //Front work start..
    public function category(){
        $blogcategory = BlogCategory::select('id' ,'title',DB::raw('DATE_FORMAT(blog_category.created_at, "%b,%d-%Y") as created_date'), 'path', 'image')->where('status', 'Yes')->get()->toArray();
        return view('category')->with(compact('blogcategory'));
    }

}

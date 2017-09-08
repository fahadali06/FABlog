<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Blogs;
use App\BlogCategory;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('admin.search.index');
    }

    public function search_ajax() {
        $search_blog = Input::get('search_blog');
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
        if ($search_blog && $search_blog != "") {
            $category = BlogCategory::select('blogs.id', 'blog_category.title as category', 'blogs.title as blogs', DB::raw('DATE_FORMAT(blogs.created_at, "%d-%m-%Y %H:%i:%s") as created_date'), DB::raw('DATE_FORMAT(blogs.updated_at, "%d-%m-%Y %H:%i:%s") as updated_date'))
                    ->join('blogs', function($join) {
                        $join->on('blogs.blog_category', '=', 'blog_category.id');
                    })
                    //->with('user')
                    ->where('blogs.title', 'like', $search_blog . '%')
                    //->orwhere('blogs.title', 'like', $search . '%')
                    //->skip($start)
                    //->take($length)
                    ->orderBy($orderby, $orderdir)
                    ->get()
                    ->toArray();
            $recordsTotalSearch = count($category);
            $recordsFilteredSearch = count($category);


            $data = [];
            foreach ($category as $da) {
                array_push($data, $da);
            }
            if (isset($recordsTotalSearch) && isset($recordsFilteredSearch)) {
                $recordsTotal = $recordsTotalSearch;
                $recordsFiltered = $recordsFilteredSearch;
            } else {
                $recordsTotal = Blogs::count();
                $recordsFiltered = Blogs::count();
            }
            echo json_encode(['draw' => $draw, 'recordsTotal' => $recordsTotal, 'recordsFiltered' => $recordsFiltered, 'data' => $data]);
        } else {
            echo json_encode(['draw' => 0, 'recordsTotal' => 0, 'recordsFiltered' => 0, 'data' => []]);
        }
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
        //
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


@extends('layouts.admin')

@section('content')
<!-- Morris Charts CSS -->
<link href="{{ asset('public/assets/admin/vendor/morrisjs/morris.css') }}" rel="stylesheet">
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Dashboard</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-list-ol fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{ $totalblogcategory }}</div>
                            <div>Blog Category!</div>
                        </div>
                    </div>
                </div>
                <a href="{{ url('admin/blogs/category') }}">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>

    </div>
    
</div>
<!-- Morris Charts JavaScript -->
<script src="{{ asset('public/assets/admin/vendor/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('public/assets/admin/vendor/morrisjs/morris.min.js') }}"></script>
<script src="{{ asset('public/assets/admin/data/morris-data.js') }}"></script>
@endsection

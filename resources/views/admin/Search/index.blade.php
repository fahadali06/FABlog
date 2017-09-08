@extends('layouts.admin')

@section('content')
<link href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet" />
<style>
    .fileUpload {
        position: relative;
        overflow: hidden;
        margin: 10px;
        border-radius: 0px !important;
    }
    .fileUpload input.upload {
        position: absolute;
        top: 0;
        right: 0;
        margin: 0;
        padding: 0;
        font-size: 20px;
        cursor: pointer;
        opacity: 0;
        filter: alpha(opacity=0);
    }


</style>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Search </h1>

        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-lg-6">
                            <input placeholder="Search Blogs" name="search_blog" id="search_blog" type="search" class="form-control" />
                        </div>
                    </div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">

                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Category</th>
                                <th>Blog</th>
                                <th>Created at</th>
                                <th>Updated at</th>
                            </tr>
                        </thead>

                    </table>
                    <!-- /.table-responsive -->

                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    <!-- /.row -->

    <!-- /.row -->

    <!-- /.row -->
</div>


<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script>
    var table;
    $(document).ready(function () {
        $('#search_blog').blur(function () {
           // $('#dataTables-example').DataTable().ajax.reload();
            searchblog($('#search_blog').val());
        });


    });

    function searchblog(search_blog) {
        table = $('#dataTables-example').DataTable({
            "processing": true,
            "serverSide": true,
            //"pageLength": 10,
            //"sAjaxDataProp":"",
            "order": [[0, "desc"]],
            "searching": false,
            paging: false,
            "ajax": {
                "url": "{{ url('admin/blog/search/ajax') }}",
                "type": "GET",
                "data": {search_blog: search_blog}
            },
            "columns": [
                {"data": "id"},
                {"data": "category"},
                {"data": "blogs"},
                {"data": "created_date"},
                {"data": "updated_date"},
            ]
        });
        
    }

</script>
@endsection

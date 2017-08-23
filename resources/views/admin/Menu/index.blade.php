@extends('layouts.admin')

@section('content')
<!-- DataTables CSS -->
<!--<link href="{{ asset('public/assets/admin/vendor/datatables-plugins/dataTables.bootstrap.css') }}" rel="stylesheet">-->
<!-- DataTables Responsive CSS -->
<!--<link href="{{ asset('public/assets/admin/vendor/datatables-responsive/dataTables.responsive.css') }}" rel="stylesheet">-->
<link href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet" />
<!--<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">-->
<!--<link href="{{ asset('public/assets/admin/vendor/data-table-ajax/css/jquery.dataTables.min.css') }}" />-->
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
            <h1 class="page-header">Menu <button class="btn btn-primary btn-sm pull-right" onclick="OpenNew();">User Rigts</button></h1>

        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Menu List
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    {!! csrf_field() !!}
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
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
<!--Open add modal-->
<div id="OpenNewModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">User Menu Rights</h4>
            </div>
            <div class="modal-body">
                {{ Form::open(['url' => url('/admin/menu/store'), 'mehtod' => 'POST', 'id' => 'FormAdd', 'enctype' => 'multipart/form-data']) }}
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            {{ Form::label('title1', 'Menus') }}
                            {{ Form::select('title1',  $menus, null , ['class' => 'form-control', 'id' => 'title1', 'multiple' => true]) }}

                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            {{ Form::label(null, '&nbsp;') }}
                            {{ Form::select('title2',  [], null , ['class' => 'form-control', 'id' => 'title2', 'multiple' => true]) }}

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="progress hidden">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100">

                            </div>
                        </div>
                        <div id="output"></div>
                    </div>
                </div>
                {{ Form::close() }}

            </div>
            <div class="modal-footer">
                <button onclick="FormAddSubmit();" id="FormAddSubmit" type="button" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<!--Open edit modal-->
<div id="OpenEditModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Blog Category</h4>
            </div>
            <div class="modal-body">
                {{ Form::open(['url' => url('admin/blogs/category/update'), 'mehtod' => 'POST', 'id' => 'FormEdit', 'enctype' => 'multipart/form-data']) }}
                {{ Form::hidden('blog_id', null,['id' => 'blog_id']) }}
                <div class="form-group">
                    {{ Form::label('title', 'Title') }}
                    {{ Form::text('title', '', ['class' => 'form-control']) }}
                </div>
                <div class="form-group">
                    {{ Form::label('file', 'Image') }}
                    <div class="clearfix"></div>
                    <div class="fileUpload btn btn-success">
                        <span>Upload</span>
                        {{ Form::file('image', ['class' => 'upload', 'id' => 'file']) }}
                    </div>
                    <input type="hidden" id="orignal-image" name="orignal-image" />
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="progress hidden">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100">

                            </div>
                        </div>
                        <div id="output"></div>
                    </div>
                </div>
                {{ Form::close() }}

            </div>
            <div class="modal-footer">
                <button onclick="FormEditSubmit();" id="FormAddSubmit" type="button" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<!--<script src="{{ asset('public/assets/admin/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/assets/admin/vendor/datatables-plugins/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('public/assets/admin/vendor/datatables-responsive/dataTables.responsive.js') }}"></script>-->
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<!--<script src="{{ asset('public/assets/admin/vendor/data-table-ajax/js/jquery.dataTables.min.js') }}"></script>-->
<script>
    var table;
    $(document).ready(function () {
        table = $('#dataTables-example').DataTable({
            "processing": true,
            "serverSide": true,
            //"pageLength": 10,
            //"sAjaxDataProp":"",
            "order": [[0, "desc"]],
            "ajax": {
                "url": "{{ url('admin/menu') }}",
                "type": "GET",
            },
            "columns": [
                {"data": "id"},
                {"data": "title"},
                {"data": "created_date"},
                {"data": "updated_date"},
            ]
        });
        setInterval(function () {
            table.ajax.reload(null, false); // user paging is not reset on reload
        }, 30000);
        
        $('#title1').on('change',function(){
            var id = $(this).find('option:selected').val();
            var text = $(this).find('option:selected').text();
           
            if(id == ""){
                
            }else{
                var flag = true;
                $('#title2 option').each(function(){
                    if($(this).val() == id){
                        flag = false;
                    }
                });
                if(flag == false){ alert(text+' already exist'); return false;}
                $('#title2').append('<option selected value='+id+'>'+text+'</option>');
                
            }
        });
        
        $('#title2').on('click', function() {
            $("#title2 option:selected").remove();
            $('#title2').find('option').prop('selected',true);
        });
        
    });

    function OpenNew() {

        $('#OpenNewModal').modal(
                {
                    'backdrop': 'static',
                    'keyboard': false
                }
        );
    }

    function FormAddSubmit() {
        if ($('#FormAdd input[name=title]').val() == "") {
            alert('Title field should not be empty!');
        } else {
            $('#FormAdd #output').text('');
            $('.progress').removeClass('hidden');
            $(".progress .progress-bar").css("width", "0%").text("0%");
            //$(".progress span").text("0%");

            $.ajax({
                // Your server script to process the upload
                url: '{{ url("admin/blogs/category/store") }}',
                type: 'POST',
                // Form data
                data: new FormData($('#FormAdd')[0]),
                // Tell jQuery not to process data or worry about content-type
                // You *must* include these options!
                cache: false,
                contentType: false,
                processData: false,
                // Custom XMLHttpRequest
                xhr: function () {
                    var myXhr = $.ajaxSettings.xhr();
                    if (myXhr.upload) {
                        // For handling the progress of the upload
                        myXhr.upload.addEventListener('progress', function (e) {
                            var percent = 0;
                            var position = e.loaded || e.position;
                            var total = e.total;
                            if (e.lengthComputable) {
                                $('progress').attr({
                                    value: e.loaded,
                                    max: e.total,
                                });

                                percent = Math.ceil(position / total * 100);

                            }

                            $(".progress .progress-bar").css("width", +percent + "%").text(percent + "%");
                            //$(".progress span").text(percent +"%");

                            if (percent == 100) {
                                //$('.progress').fadeOut(2000);
                                setTimeout(function () {
                                    //$('.progress').addClass('hidden');
                                }, 3000);
                            }

                        }, false);
                    }
                    return myXhr;
                },
                success: function (response) {
                    if (response == 'Success') {
                        $('#FormAdd')[0].reset();
                        $('#output').text(response);
                        $('#FormEdit .progress').addClass('hidden');
                        $('#OpenNewModal').modal('hide');
                        table.ajax.reload();
                    } else {
                        $('#FormAdd')[0].reset();
                        $('#FormEdit .progress').addClass('hidden');
                        $('#output').text(response);
                        table.ajax.reload();
                    }
                }
            });
        }
    }

    function edit(id) {
        window.location.href = '{{ url("admin/user/management/edit") }}/' + id;
        return false;
        $('#FormEdit #blog_id').val(id);
        $.ajax({
            type: 'POST',
            url: '{{ url("admin/blogs/category/edit") }}/' + id,
            data: {_token: $('#edit-' + id).attr('data-token')},
            dataType: 'json',
            success: function (response) {
                var result = response;
                $('#FormEdit #title').val(result['title']);
                $('#FormEdit #orignal-image').val(result['image']);
                $('#OpenEditModal').modal(
                        {
                            'backdrop': 'static',
                            'keyboard': false
                        }
                );
            }
        });
    }

    function FormEditSubmit() {
        if ($('#FormEdit input[name=title]').val() == "") {
            alert('Title field should not be empty!');
        } else {
            $('#FormEdit #output').text('');
            var blog_id = $('#FormEdit #blog_id').val();
            $('#FormEdit .progress').removeClass('hidden');
            $("#FormEdit .progress .progress-bar").css("width", "0%").text("0%");
            //$(".progress span").text("0%");

            $.ajax({
                // Your server script to process the upload
                url: '{{ url("admin/blogs/category/update") }}/' + blog_id,
                type: 'POST',
                // Form data
                data: new FormData($('#FormEdit')[0]),
                // Tell jQuery not to process data or worry about content-type
                // You *must* include these options!
                cache: false,
                contentType: false,
                processData: false,
                // Custom XMLHttpRequest
                xhr: function () {
                    var myXhr = $.ajaxSettings.xhr();
                    if (myXhr.upload) {
                        // For handling the progress of the upload
                        myXhr.upload.addEventListener('progress', function (e) {
                            var percent = 0;
                            var position = e.loaded || e.position;
                            var total = e.total;
                            if (e.lengthComputable) {
                                $('progress').attr({
                                    value: e.loaded,
                                    max: e.total,
                                });

                                percent = Math.ceil(position / total * 100);

                            }

                            $("#FormEdit .progress .progress-bar").css("width", +percent + "%").text(percent + "%");
                            //$(".progress span").text(percent +"%");

                            if (percent == 100) {
                                //$('#FormEdit .progress').fadeOut(2000);
                                setTimeout(function () {
                                    //$('#FormEdit .progress').addClass('hidden');
                                }, 3000);
                            }

                        }, false);
                    }
                    return myXhr;
                },
                success: function (response) {
                    if (response == 'Success') {
                        $('#FormEdit')[0].reset();
                        $('#FormEdit #output').text(response);
                        $('#FormEdit .progress').addClass('hidden');
                        $('#OpenEditModal').modal('hide');
                        table.ajax.reload();
                    } else {
                        $('#FormEdit')[0].reset();
                        $('#FormEdit .progress').addClass('hidden');
                        $('#FormEdit #output').text(response);
                        table.ajax.reload();
                    }
                }
            });
        }
    }

    function delete_blog(id) {
        if (confirm('Do you want to do it ?')) {
            $.ajax({
                type: 'POST',
                url: '{{ url("admin/blogs/category/delete") }}/' + id,
                //dataType: 'json',
                data: {_token: $('#delete-' + id).attr('data-token')},
                success: function (response) {
                    var result = response;
                    if (result == "Success") {
                        table.ajax.reload();
                    } else {
                        table.ajax.reload();
                    }
                }
            });
        }
    }

</script>
@endsection
<!--https://datatables.net/examples/server_side/post.html
https://stackoverflow.com/questions/33571905/how-do-i-pass-additional-parameters-to-the-jquery-datatable-ajax-call
https://datatables.net/forums/discussion/21940/how-to-pass-new-post-parameters-on-ajax-reload-->

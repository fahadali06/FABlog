@extends('layouts.app')

@section('content')

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Post Content Column -->
        <div class="col-lg-8">
            <h4 class="mt-4">Blogs</h4>
            <div class="row">
                <div class="col-lg-6">
                    {{ Form::select('category', $blogcategory, $id, ['class' => 'form-control', 'onchange' => 'blog(this.value);']) }}
                </div>
                <div class="col-lg-6">
                    {{ Form::select('blog', [], null, ['class' => 'form-control', 'id' => 'blog', 'onchange' => 'blog_detail(this.value);']) }}
                </div>
                {{ csrf_field() }}
            </div>
            <div>&nbsp;</div>
            <div class="row show-blog" style="display: none;">
                <div class="col-lg-12 ">
                    <h1 class="mt-4 blog-title"></h1>

                    <!-- Author -->
                    <p class="lead">
                        by
                        <a class="blog-user" href="#"></a>
                    </p>

                    <hr>

                    <!-- Date/Time -->
                    <p class="blog-date"></p>

                    <hr>

                    <!-- Preview Image -->
                    <img class="img-fluid rounded blog-image" src="" alt=""><!-- http://placehold.it/900x300 -->

                    <hr>

                    <!-- Post Content -->
                    <div class="blog-description"></div>
                    <hr>
                </div>
            </div>
        </div>

        <!-- Sidebar Widgets Column -->
        @include('layouts.sidebar')

    </div>
    <!-- /.row -->

</div>
<!-- /.container -->
<script>
    $(document).ready(function () {
        blog(<?php echo $id; ?>);
        setTimeout(function () {
            blog_detail($('#blog option:selected').val());
        }, 1000);

    });

    function  blog(id) {
        $.ajax({
            type: 'POST',
            url: '{{ url("blog_ajax") }}',
            data: {id: id, _token: $('input[name=_token]').val()},
            dataType: 'json',
            success: function (response) {
                var result = response;
                var option;
                if (result.length > 0) {
                    $.each(result, function (index, value) {
                        option += "<option value = " + value.id + ">" + value.title + "</option>";
                    });
                    $('#blog').html('');
                    $('#blog').append(option);
                } else {
                    $('#blog').html('');
                    $('#blog').append('<option value="">Blog not found</option>');
                }
            }
        });
        setTimeout(function () {
            blog_detail($('#blog option:selected').val());
        }, 500);
    }

    function  blog_detail(id) {
        $.ajax({
            type: 'POST',
            url: '{{ url("blog_detail_ajax") }}',
            data: {id: id, _token: $('input[name=_token]').val()},
            dataType: 'json',
            success: function (response) {
                var result = response;
                if (result) {
                    $('.show-blog').css('display', 'block');
                    $('.blog-title').text(result.title);
                    $('#mtitle').attr('content', result.title);
                    $('.blog-user').text(result.bloguser.name);
                    $('.blog-date').text('Posted on ' + result.created_date);
                    if (result.path) {
                        var src = '<?php echo asset('public/assets/upload'); ?>/' + result.path + '/' + result.image;
                    } else {
                        var src = 'http://placehold.it/900x300';
                    }
                    $('.blog-image').attr('src', src);
                    $('#mimage').attr('content', src);
                    $('.blog-description').html(result.description);
                    $('#mdescription').attr('content', result.description.replace(/(<([^>]+)>)/ig,""));
                    $('#murl').attr('content', '<?php echo url('blog') ?>/' + result.blog_category + '/' + result.id);
                } else {

                    $('.show-blog').css('display', 'none');
                }
            }
        });
    }
</script>
@endsection

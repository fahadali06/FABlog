@extends('layouts.app')

@section('content')

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Post Content Column -->
        <div class="col-lg-8">
            <h4 class="mt-4">Blogs</h4>
            @if(isset($blogs) && !empty($blogs))
            <div class="row show-blog" >
                <div class="col-lg-12 ">
                    <h1 class="mt-4 blog-title">{{ $blogs[0]['blog'] }}</h1>

                    <!-- Author -->
                    <p class="lead">
                        by
                        <a class="blog-user" href="#">{{ $blogs[0]['name'] }}</a>
                    </p>

                    <hr>

                    <!-- Date/Time -->
                    <p class="blog-date">{{ $blogs[0]['created_date'] }}</p>

                    <hr>

                    <!-- Preview Image -->
                    <img class="img-fluid rounded blog-image" src="{{ $blogs[0]['path'] ? asset('public/assets/upload').'/'.$blogs[0]['path'].'/'.$blogs[0]['image'] : "http://placehold.it/900x300" }}" alt=""><!-- http://placehold.it/900x300 -->

                    <hr>

                    <!-- Post Content -->
                    {!! $blogs[0]['description'] !!}
                    <hr>
                </div>
            </div>
            @if(isset($rel_blogs) && !empty($rel_blogs))
            <div class="row">
                <div class="col-lg-12">
                    Related Blogs: @foreach($rel_blogs as $blog) <a href="{{ url('blog').'/'.$blog['blog_category'].'/'.$blog['id'] }}">{{ $blog['title'] }}</a> | @endforeach
                </div>
            </div>
            @endif
            @endif
            <div>&nbsp;</div>
        </div>

        <!-- Sidebar Widgets Column -->
        @include('layouts.sidebar')

    </div>
    <!-- /.row -->

</div>
<!-- /.container -->
@endsection

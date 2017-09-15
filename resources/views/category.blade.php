@extends('layouts.app')

@section('content')

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Post Content Column -->
        <div class="col-lg-8">
            <h4 class="mt-4">Blog Categories</h4>
            <div class="row">
                @if(isset($blogcategory))
                @foreach($blogcategory as $category)
                <div class="col-lg-4">
                    <div class="thumbnail ">
                        <img width="200" height="200"  src="{{ $category['image'] ? asset('public/assets/upload/'.$category['path'].'/'.$category['image']) : "http://placehold.it/200x200" }}" /><!--http://placehold.it/200x200-->
                        <div class="caption">
                            <strong>{{ $category['title'] }}</strong>
                            <br><a href="{{ url('blog'.'/'.$category['id']) }}" class="btn-link"><small>Show more</small></a>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>

        <!-- Sidebar Widgets Column -->
        @include('layouts.sidebar')

    </div>
    <!-- /.row -->

</div>
<!-- /.container -->



@endsection

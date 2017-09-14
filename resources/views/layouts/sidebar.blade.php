<div class="col-md-4">

    <!-- Search Widget -->
    <div class="card my-4">
        <h5 class="card-header">Search</h5>
        <div class="card-body">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search for...">
                <span class="input-group-btn">
                    <button class="btn btn-secondary" type="button">Go!</button>
                </span>
            </div>
        </div>
    </div>

    <!-- Categories Widget -->
    <div class="card my-4">
        <h5 class="card-header">Categories</h5>
        <div class="card-body">
            <div class="row">
                @if(isset($BlogCategoryList))
                @foreach($BlogCategoryList as $category)
                <div class="col-lg-6">
                    <a href="{{ url('blog'.'/'.$category['id']) }}">{{ $category['title'] }}</a>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>

    <!-- Side Widget -->
    <div class="card my-4">
        <h5 class="card-header">Recent Posts</h5>
        <div class="card-body">
            @if($RecentBlog)
            @foreach($RecentBlog as $blog)
            <h5>{!! $blog['title'] !!}</h5>
            <div class="row">
                <div class="col-md-12">
                    <img width='50' style='float:left; margin-right:10px;' src="{{ $blog['path'] ? asset('public/assets/upload/'.$blog['path'].'/'.$blog['image']) : "http://placehold.it/50x50" }}" /><!-- http://placehold.it/50x50 -->
                    {!! str_limit($blog['description'], $limit = 50, $end = '...') !!}
                    <a href="{{ url('#') }}"><small>See Post</small></a>
                </div>

            </div>
            @endforeach
            @endif
        </div>
    </div>

    <!-- Side Archive -->
    <div class="card my-4">
        <h5 class="card-header">Archive</h5>
        <div class="card-body">
            <div class="row">
                @if(isset($ArchiveBlog))
                @foreach($ArchiveBlog as $blog)
                <div class="col-sm-6"><a href="{{ url('blogs/archive/'.$blog['created_date']) }}" class=" btn-link">{{ $blog['created_date'] }}</a></div>
                @endforeach
                @endif
            </div>

        </div>
    </div>

</div>
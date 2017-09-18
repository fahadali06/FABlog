<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="This blog free of cost, Open source developing on laravel 5.2">
        <meta name="author" content="">
        @if(isset($fb) && $fb == TRUE)
        <meta id="murl" property="og:url"                content="" />
        <meta id="mtype" property="og:type"               content="article" />
        <meta id="mtitle" property="og:title"              content="" />
        <meta id="mdescription" property="og:description"        content="" />
        <meta id="mimage" property="og:image"              content="" />
        @endif
        
        <link rel="shortcut icon" href="{{{ asset('public/assets/front/favicon.ico') }}}">

        <title>Blog</title>

        <!-- Bootstrap core CSS -->
        <link href="{{ asset('public/assets/front/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="{{ asset('public/assets/front/css/blog-post.css') }}" rel="stylesheet">
        <script src="{{ asset('public/assets/admin//vendor/jquery/jquery.min.js') }}"></script>

    </head>

    <body>

        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
            <div class="container">
                <a class="navbar-brand" href="#">FA Blog</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ url('') }}">Home
                                <span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('category') }}">Blogs</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Gallery</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        @yield('content')

        <!-- Footer -->
        <footer class="py-5 bg-dark">
            <div class="container">
                <p class="m-0 text-center text-white">Copyright &copy; 2017</p>
            </div>
            <!-- /.container -->
        </footer>

        <!-- Bootstrap core JavaScript -->
        <script src="{{ asset('public/assets/front/vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('public/assets/front/vendor/popper/popper.min.js') }}"></script>
        <script src="{{ asset('public/assets/front/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
        
        @if(isset($fb) && $fb == TRUE)
        <!-- Go to www.addthis.com/dashboard to customize your tools --> 
        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-59b23501e61e9535"></script> 
        @endif
    </body>

</html>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <!-- Set latest rendering mode for IE -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

        <title>FastBooks</title>

        <!-- Set viewport for mobile devices to zoom to 100% -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
        <!-- Loading fonts in the header makes it work in IE<9 -->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>

        <!-- Including bootstrap 2.3.1 -->
        <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
        <!-- Including Font Awesome 3.0 styles -->
        <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/error.css')}}">
   </head>
    
<body>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="error-template">
                    <h1>
                        Oops!</h1>
                    <h2>
                        404 Not Found</h2>
                    <div class="error-details">
                        Sorry, an error has occured, Requested page not found!
                    </div>
                    <div class="error-actions">
                        <a class="btn btn-primary btn-lg" href="{{ url('/') }}">
                            Take Me Home
                    	 </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
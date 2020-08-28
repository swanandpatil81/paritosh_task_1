<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="{{URL::to('css/bootstrap.min.css')}}" rel="stylesheet">

    <title>Login</title>

    <style>
        .up-space{
            padding-top:15px;
        }
    </style>
</head>

<body>
    <div class="row">

        <div class="col-md-3"></div>

        <div class="col-md-6 up-space">

            @if(Session::get('user_id') != null or Session::get('user_id') != '')
                <script>window.location="{{url('/distance_calc?distance=800&smoothroad=400&badroad=200&workinprogress=200&break=')}}";</script>
            @endif

            @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
                </div>
            @endif

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                </div>
            @endif

            <form class="m-t" role="form" method="post" action="{{URL::to('check-login')}}">
                {{ csrf_field() }}
                <div class="form-group">
                    <input type="text" class="form-control" autocomplete="off" placeholder="Username" name='username' id='username'>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" autocomplete="off" placeholder="Password" name='password' id='password'>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>

                <p class="text-center">
                    <small>Do not have an account?</small>
                </p>
                <a class="btn btn-sm btn-white btn-block" href="#">Create an account</a>
            </form>
        </div>
    </div>

</body>
</html>
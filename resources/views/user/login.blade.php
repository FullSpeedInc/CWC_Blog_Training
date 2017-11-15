@extends("layout/master")
@section('sitetitle', 'User ')
@section("content")
    <div class="row">
        <div class="col-3 offset-md-4">
            <div class="title">Login</div>
            <form action="{{route('login')}}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                @if(session()->has('errors'))
                   <em style="color:red">{{ session()->get('errors')->first() }}</em>
                @endif
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Enter username." required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter password." required>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@stop

@extends("layout/master")
@section('sitetitle', 'User ')
@section("content")
    <div class="row">
            <div class="col-10">
                <div class="row">
                    <div class="offset-md-1 col-10">
                        <div id="notificationUserSuccess" class="alert alert-success" style="display:none;"></div>
                        <div id="notificationUserDanger" class="alert alert-danger" style="display:none;"></div>
                        <table id="tblUser" class="table table-hover table-sm">
                            <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Username</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                                @if($users)
                                    @foreach($users as $user)
                                        <tr>
                                            <td scope="row">{{$user->firstname}}</td>
                                            <td>{{$user->lastname}}</td>
                                            <td>{{$user->username}}</td>
                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm">Edit</button>
                                                <button type="button" class="btn btn-danger btn-sm btnDelete" id="{{$user->id}}">Delete</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td>No Users.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col offset-md-7">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">Next</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            @if ($viewUserStore)
                <div class="col-2 align-self-end">
                    <form action="{{route('user.store')}}" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <h5>Add User</h5>

                        @if($errors->any())
                            <div class="alert alert-danger">{{$errors->first()}}</div>
                        @elseif(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Enter username." required>
                        </div>
                        <div class="form-group">
                            <label for="lastname">Last Name</label>
                            <input type="text" name="lastname" class="form-control" placeholder="Enter lastname." required>
                        </div>
                        <div class="form-group">
                            <label for="firstname">First Name</label>
                            <input type="text" name="firstname" class="form-control" placeholder="Enter firstname." required>
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select class="form-control" name="role">
                                <option value="0" selected>User</option>
                                <option value="1">Admin</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Enter password." required>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            @endif
        </div>
    <script>
    $(document).ready(function(){
        const btns = {
            'delete' : $('.btnDelete')
        }
        const notifications = {
            'user' : {
                'success' : $('#notificationUserSuccess'),
                'danger'  : $('#notificationUserDanger')
            }
        }

        let userDelete = (id = null) => {
            $.ajax({
                url: '{{route("user.delete")}}',
                data : {
                    'id': id,
                    '_token': '{{ csrf_token() }}',
                },
                method: 'POST',
                success: function(data){
                    if (data.success) {
                        notifications.user.success.css('display', 'block')
                        notifications.user.success.html(data.message)
                        $('#tblUser #' + id).closest('tr').remove()
                    }
                },
                error: function(){
                    notifications.user.success.css('display', 'block')
                    notifications.user.danger.html(data.message)
                }
            })
        }

        $('table').on('click', '.btnDelete', function(){
            userDelete($(this).attr('id'))
        })
    })
</script>
@stop
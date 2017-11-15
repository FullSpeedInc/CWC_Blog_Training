@extends("layout/master")
@section('sitetitle', 'User ')
@section("content")
    <div class="row">
        <div class="col-10">
            <div class="row">
                <div class="offset-md-1 col-10">
                    <div id="notificationUserSuccess" class="alert alert-success" style="display:none;"></div>
                    <div id="notificationUserDanger" class="alert alert-danger" style="display:none;"></div>

                    @if(session()->has('errors'))
                        <div class="alert alert-danger">{{ session()->get('errors')->first() }}</div>
                    @elseif(session()->get('userListMessage') && session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif

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
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-id="{{$user->id}}" data-target="#modalUserEdit">Edit</button>
                                            <button type="button" class="btn btn-danger btn-sm btnUserDelete" id="{{$user->id}}">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr><td>No Users.</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-2 offset-md-10">
                    <nav>{{$users->links()}}</nav>
                </div>
            </div>
        </div>
        @if ($viewUserStore)
            <div class="col-2 align-self-end">
                <form action="{{route('user.store')}}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <h5>Add User</h5>

                    @if(session()->has('errors'))
                        <div class="alert alert-danger">{{ session()->get('errors')->first() }}</div>
                    @elseif(session()->get('userAddMessage') && session()->has('message'))
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
                        <input type="text" name="lastname" class="form-control" placeholder="Enter last name." required>
                    </div>
                    <div class="form-group">
                        <label for="firstname">First Name</label>
                        <input type="text" name="firstname" class="form-control" placeholder="Enter first name." required>
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
        @if($user)
            <div class="modal fade" id="modalUserEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalUserLabel">Modify User</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{route('user.update')}}" method="POST">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="id" value="">

                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" name="username" class="form-control" placeholder="Enter username." required>
                                </div>
                                <div class="form-group">
                                    <label for="lastname">Last Name</label>
                                    <input type="text" name="lastname" class="form-control" placeholder="Enter last name." required>
                                </div>
                                <div class="form-group">
                                    <label for="firstname">First Name</label>
                                    <input type="text" name="firstname" class="form-control" placeholder="Enter first name." required>
                                </div>
                                <div class="form-group">
                                    <label for="role">Role</label>
                                    <select class="form-control" name="role">
                                        <option value="0" selected>User</option>
                                        <option value="1">Admin</option>
                                    </select>
                                </div>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <script>
        $(document).ready(function(){
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
                        notifications.user.danger.css('display', 'block')
                        notifications.user.danger.html(data.message)
                    }
                })
            }

            $('table').on('click', '.btnUserDelete', function(){
                userDelete($(this).attr('id'))
            })

            $('#modalUserEdit').on('show.bs.modal', function (event) {
              var button = $(event.relatedTarget)
              var id = button.data('id')
              var modal = $(this)

              $.ajax({
                    url: '{{route("user.get")}}',
                    data : {
                        'id' : id,
                        '_token' : '{{ csrf_token() }}',
                    },
                    method: 'POST',
                    success: function(data){
                        if(data.success){
                            modal.find('#modalUserLabel').append(': ' + data.user.username)
                            modal.find('[name="id"]').val(id)
                            modal.find('[name="username"]').val(data.user.username)
                            modal.find('[name="lastname"]').val(data.user.last_name)
                            modal.find('[name="firstname"]').val(data.user.first_name)
                            modal.find('[name="role"]').val(data.user.role)
                        }
                    },
                    error: function(){
                        notifications.user.danger.css('display', 'block')
                        notifications.user.danger.html(data.message)
                    }
                })
            })
        })
    </script>
@stop
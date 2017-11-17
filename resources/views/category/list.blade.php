@extends("layout/master")
@section('sitetitle', 'Category')
@section("content")
    <div class="row">
        <div class="col-10">
            <div class="row">
                <div class="offset-md-1 col-10">
                    <div id="notificationCategorySuccess" class="alert alert-success" style="display:none;"></div>
                    <div id="notificationCategoryDanger" class="alert alert-danger" style="display:none;"></div>

                    @if(session()->has('errors'))
                        <div class="alert alert-danger">{{ session()->get('errors')->first() }}</div>
                    @elseif(session()->get('categoryListMessage') && session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif

                    <form>
                        <table id="tblCategory" class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if($categories)
                                @foreach($categories as $category)
                                    <tr>
                                        <td scope="row">{{$category->id}}</td>
                                        <td>{{$category->name}}</td>
                                        <td>
                                            <a class="btnCategoryDelete" name="deleteArticle{{$category->id}}" id="{{$category->id}}">
                                                <button type="button" class="btn btn-danger btn-sm" id="{{$category->id}}" value="Delete">Delete</button>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr><td>No Categories.</td></tr>
                            @endif
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
            <div class="row d-flex justify-content-between">
                <div></div>
                <div>{{$categories->links()}}</div>
                <div></div>
            </div>
        </div>
        <div class="col-2">
                <form action="{{route('category.store')}}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <h5>Add Category</h5>

                    @if(session()->has('errors'))
                        <div class="alert alert-danger">{{ session()->get('errors')->first() }}</div>
                    @elseif(session()->get('categoryAddMessage') && session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter category name." required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
    </div>
    <script>
        $(document).ready(function(){
            const notifications = {
                'category' : {
                    'success' : $('#notificationCategorySuccess'),
                    'danger'  : $('#notificationCategoryDanger')
                }
            }
            let categoryDelete = (id = null) => {
                $.ajax({
                    url: '{{route("category.delete")}}',
                    data : {
                        'id': id,
                        '_token': '{{ csrf_token() }}',
                    },
                    method: 'POST',
                    success: function(data){
                        if (data.success) {
                            notifications.category.success.css('display', 'block')
                            notifications.category.success.html(data.message)
                            $('#tblCategory #' + id).closest('tr').remove()
                        } else {
                            notifications.category.danger.css('display', 'block')
                            notifications.category.danger.html(data.message)
                        }
                    },
                    error: function(){
                        notifications.category.danger.css('display', 'block')
                        notifications.category.danger.html(data.message)
                    }
                })
            }

            $('table').on('click', '.btnCategoryDelete', function(){
                categoryDelete($(this).attr('id'))
            })
        })
    </script>
@stop
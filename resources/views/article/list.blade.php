@extends("layout/master")
@section('sitetitle', 'Category')
@section("content")
    <div class="row">
        <div class="col">
            <div class="row">
                <div class="offset-md-1 col-10">
                    <div id="notificationArticleSuccess" class="alert alert-success" style="display:none;"></div>
                    <div id="notificationArticleDanger" class="alert alert-danger" style="display:none;"></div>

                    @if(session()->has('errors'))
                        <div class="alert alert-danger">{{ session()->get('errors')->first() }}</div>
                    @elseif(session()->get('articleListMessage') && session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif

                    <a href="{{route('article.create')}}">Create Article</a>

                    <table id="tblArticle" class="table table-hover table-sm">
                        <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Slug</th>
                            <th>Writer</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($articles)
                            @foreach($articles as $article)
                                <tr>
                                    <td>{{$article->title}}</td>
                                    <td>{{$article->category}}</td>
                                    <td>{{$article->slug}}</td>
                                    <td>{{$article->username}}</td>
                                    <td>
                                        <a href="{{route('article.edit', $article->article_id)}}">Edit</a>
                                        <button type="button" class="btn btn-danger btn-sm btnArticleDelete" id="{{$article->article_id}}">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr><td>No Articles.</td></tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-2 offset-md-10">
                    <nav>
                        <ul class="pagination">
                            @if($currentPage>1)
                                <li class="page-item"><a class="page-link" href="{{url()->current()}}?page={{$currentPage-1}}">Previous</a></li>
                                <li class="page-item"><a class="page-link" href="{{url()->current()}}?page={{$currentPage-1}}">{{$currentPage-1}}</a></li>
                            @endif
                            <li class="page-item"><a class="page-link" href="{{url()->current()}}?page={{$currentPage}}">{{$currentPage}}</a></li>
                            @if($currentPage+1 <= $paginatorLast)
                                <li class="page-item"><a class="page-link" href="{{url()->current()}}?page={{$currentPage+1}}">{{$currentPage+1}}</a></li>
                                    <li class="page-item"><a class="page-link" href="{{url()->current()}}?page={{$currentPage+1}}">Next</a></li>
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>

        </div>
    </div>
    <script>
        $(document).ready(function(){
            const notifications = {
                'article' : {
                    'success' : $('#notificationArticleSuccess'),
                    'danger'  : $('#notificationArticleDanger')
                }
            }
            let userDelete = (id = null) => {
                $.ajax({
                    url: '{{route("article.delete")}}',
                    data : {
                        'id': id,
                        '_token': '{{ csrf_token() }}',
                    },
                    method: 'POST',
                    success: function(data){
                        if (data.success) {
                            notifications.article.success.css('display', 'block')
                            notifications.article.success.html(data.message)
                            $('#tblArticle #' + id).closest('tr').remove()
                        }
                    },
                    error: function(){
                        notifications.article.danger.css('display', 'block')
                        notifications.article.danger.html(data.message)
                    }
                })
            }

            $('table').on('click', '.btnArticleDelete', function(){
                userDelete($(this).attr('id'))
            })
        })
    </script>
@stop
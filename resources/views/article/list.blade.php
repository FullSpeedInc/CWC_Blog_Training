@extends("layout/master")
@section('sitetitle', 'Category')
@section("content")
    <div class="row">
        <div class="col-7">
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

                    <table id="tblArticle" class="table table-hover table-sm">
                        <thead>
                        <tr>
                            <th>ID</th>
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
                                    <td>{{$article->article_id}}</td>
                                    <td>{{$article->title}}</td>
                                    <td>{{$article->category}}</td>
                                    <td>{{$article->slug}}</td>
                                    <td>{{$article->username}}</td>
                                    <td>
                                        <a class="btn btn-primary btn-sm" href="{{route('article.edit', $article->article_id)}}">Edit</a>
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
            <div class="row d-flex justify-content-between">
                <div></div>
                <div>{{$articles->links()}}</div>
                <div></div>
            </div>

        </div>
        <div class="col-5">
            <div class="row">
                <form action="{{route('article.store')}}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" class="form-control" placeholder="Enter title." maxlength="255" required>
                    </div>
                    <div class="form-group">
                        <label for="slug">Slug</label>
                        <input type="text" name="slug" class="form-control" placeholder="Enter slug." maxlength="255" pattern="[a-zA-Z0-9._-]+" required>
                    </div>
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select class="form-control" name="category">
                            @foreach($categories as $category)
                                <option value="{{$category->id}}" selected>{{$category->value}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <textarea name="editor"></textarea>
                    </div>

                    <div class="form-group">
                        <input name="imgInput" type="text" style="width:60%">
                        <button type="button" name="imgUpload" class="btn btn-primary" style="float: left">Choose Image</button>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
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


            //For the CKEditor
            var editor = ClassicEditor.create( document.querySelector( '[name=editor]' ) )
                                    .then( editor => { console.log( editor );
                                    }).catch( error => { console.error( error );
                                    })

            $('[name=imgUpload]').click( () => {
                CKFinder.modal( {
                    chooseFiles: true,
                    width: 800,
                    height: 600,
                    onInit: function( finder ) {
                        finder.on( 'files:choose', function( evt ) {
                            var file = evt.data.files.first();
                            $('[name=imgInput]').val(file.getUrl());
                        } );

                        finder.on( 'file:choose:resizedImage', function( evt ) {
                            $('[name=imgInput]').val(evt.data.resizedUrl);
                        } );
                    }
                });
            });
        })
    </script>
@stop
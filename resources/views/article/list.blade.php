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

                    <table id="tblArticle" class="table table-hover table-sm">
                        <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Writer</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($articles)
                            <tr><td>TO DO.</td></tr>
                        @else
                            <tr><td>No Articles.</td></tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-2 offset-md-10">
                    <nav>{{$articles->links()}}</nav>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <form action="{{route('user.update')}}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" value="">

                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control" placeholder="Enter title." required>
                </div>
                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input type="text" name="slug" class="form-control" placeholder="Enter slug." required>
                </div>
                <div class="form-group">
                    <label for="img">Attach Image</label>
                    <input type="file" class="form-control-file" id="img" aria-describedby="imgHelp">
                    <small id="imgHelp" class="form-text text-muted">Image for article.</small>
                </div>

                <div class="form-group">
                    <textarea name="editor" id="editor">
                        <p>Here goes the initial content of the editor.</p>
                    </textarea>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            //For the CKEditor
            var editor = ClassicEditor.create( document.querySelector( '#editor' ) )
                                      .then( editor => { console.log( editor );
                                           }).catch( error => { console.error( error );
                                           })
        })
    </script>
@stop
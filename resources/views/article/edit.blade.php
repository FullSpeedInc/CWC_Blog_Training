@extends("layout/master")
@section('sitetitle', 'Create Category')
@section("content")
    <div class="row">
        <div class="col">
            <form action="{{route('article.update')}}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" value="{{ $article->id }}">

                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control" placeholder="Enter title." maxlength="255" required value="{{$article->title}}">
                </div>
                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input type="text" name="slug" class="form-control" placeholder="Enter slug." maxlength="255" pattern="[a-zA-Z0-9._-]+" value="{{$article->slug}}" required>
                </div>
                <div class="form-group">
                    <label for="category">Category</label>
                    <select class="form-control" name="category">
                        @foreach($categories as $category)
                            <option value="{{$category->id}}" @if($article->article_category_id == $category->id) selected @endif>{{$category->value}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="img">Attach Image</label>
                    <input type="file" class="form-control-file" id="img" aria-describedby="imgHelp">
                    <small id="imgHelp" class="form-text text-muted">Image for article.</small>
                </div>

                <div class="form-group">
                    <textarea name="editor">{{$article->contents}}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            //For the CKEditor
            var editor = ClassicEditor.create( document.querySelector( '[name=editor]' ) )
                .then( editor => { console.log( editor );
        }).catch( error => { console.error( error );
        })
        })
    </script>
@stop
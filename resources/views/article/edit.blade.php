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
                    <textarea name="editor">{{$article->contents}}</textarea>
                </div>

                <input name="imgInput" type="text" style="width:60%">
                <button type="button" name="imgUpload" class="btn btn-primary" style="float: left">Choose Image</button>
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
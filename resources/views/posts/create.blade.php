@extends('layouts.app')

@auth

@section('content')

<div class="card card-default">
    <div class="card-header">
        Create Post
    </div>
    <div class="card-body">
        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="list-group">
                @foreach($errors->all() as $error)
                <div class="list-group-item text-danger">
                    {{$error}}
                </div>
                @endforeach
            </ul>
        </div>
        @endif

    <form action="{{route('posts.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
            <div class="form-group">
                <div class="form-group-item">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" class="form-control">
                </div>
                <div class="form-group-item">
                <label for="description">Description</label>
                <input type="text" name="description" id="description" class="form-control">
                </div>
                <div class="form-group-item">
                <label for="content">Content</label>
                <input id="content" type="hidden" name="content" name="content" class="form-control">
                <trix-editor input="content"></trix-editor>
                </div>
                <div class="form-group">
                    <label for="category">Select Category</label>
                    <select class="form-control" id="category" name="category">
                      @foreach($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                    </select>
                  </div>
                <div class="form-group-item">
                <label for="published_at">Published at</label>
                <input type="text" name="published_at" id="published_at" class="form-control">
                </div>
                <div class="form-group-item">
                <label for="image">Image</label>
                <input type="file" name="image" id="image" class="form-control">
                </div>
            </div>
            <div class="form-group">
            <button class="btn btn-success" type="submit">
                    Create post
            </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.4/trix-core.min.js"></script>
<script>
    $(document).on("trix-initialize", function(event) {
        console.log(event.type, event);
      });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script>
      flatpickr('#published_at',{
        enableTime: true,
      })
  </script>
@endsection

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.4/trix.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endsection

@else
<script>window.location = "{{route('home')}}";</script>
@endauth
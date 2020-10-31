@extends('layouts.app')

@auth

    @section('content')

        <div class="d-flex justify-content-end">
            <a href="{{ route('posts.create') }}" class="btn btn-primary float-right my-2">
                Create Post
            </a>
        </div>


        <div class="card card-default">
            <div class="card-header">
                Posts
            </div>
            <div class="card-body">
                <ul class="list">
                  @if(count($posts) > 0)
                    @foreach ($posts as $post)
                        <li class="list-item">
                            Title: <span class="text-primary my-2">{{ $post->title }}</span> 
                            <a href="{{route('categories.edit',$post->category->id)}}" class="btn btn-primary btn-sm my-2">Category : {{$post->category->name}}</a></br>
                            Created at: <span  class="text-danger my-2">{{ $post->created_at }}</span>
                        </br>
                            <span class="list-item">
                              {{-- /cms/storage/app/ --}}
                                <img src="storage/{{$post->image }}" class="img-thumbnail" alt="Responsive image"
                                    style="width:25%">
                                Description : {{ $post->description }}
                            <div>
                            <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-secondary btn-sm">Edit</a>
                            <form method="POST" action="{{ route('posts.trash', $post->id) }}" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-warning btn-sm">Trash</button>
                            </form>
                            <button onclick="handleDelete({{ $post->id }})" class="btn btn-danger btn-sm">Delete</button>
                            </div>
                        </span>
                        </li>
                    @endforeach
                    @else 
                    <div class="alert alert-info" role="alert">
                      No Records.
                    </div>
                    @endif
                </ul>
            </div>

            <div class="card-header">
                Trashed Posts
            </div>
            <div class="card-body">
                <ul class="list">
                  @if(count($trashed) > 0)
                    @foreach ($trashed as $trash)
                        <li class="list-item">
                            Title: <span class="text-primary">{{ $trash->title }}</span> 
                            <a class="btn btn-primary btn-sm my-2">Category : {{$trash->category->name}}</a> </br>
                            <small>Created at: <span class="text-danger">{{ $trash->created_at }}</span></small></br>
                            <small>Deleted at: <span class="text-danger">{{ $trash->deleted_at }}</span></small></br>
                            <span class="list-item">
                              {{-- /cms/storage/app/ --}}
                                <img src="storage/{{$trash->image }}" class="img-thumbnail" alt="Responsive image"
                                    style="width:25%">
                                Description : {{ $trash->description }}
                            </span>
                            <form method="POST" action="{{route('posts.restore-trash', $trash->id)}}">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Restore</button>
                            </form>
                        </li>
                        </br>
                    @endforeach
                    @else 
                    <div class="alert alert-info" role="alert">
                      No Records.
                    </div>
                    @endif
                </ul>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Are you sure to delete this post?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger">
                            <strong>Danger!</strong> Indicates a dangerous or potentially negative action.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
                        <form action="" method="post" id="deletePostForm">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Yes, Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    @endsection
    @section('script')
        <script>
            function handleDelete(id) {
                var form = document.getElementById('deletePostForm')
                form.action = 'posts/' + id
                // console.log('deleting.', id)
                $('#deleteModal').modal('show')
            }
        </script>
    @endsection
@else
    <script>
        window.location = "{{ route('home') }}";
    </script>
@endauth

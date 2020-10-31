@extends('layouts.app')

@auth

@section('content')

<div class="card card-default">
    <div class="card-header">
        Edit Category
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

    <form action="{{route('categories.update',$categories->id)}}" method="POST">
        @csrf
        @method('PUT')
            <div class="form-group">
                <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $categories->name }}">
            </div>
            <div class="form-group">
            <button class="btn btn-success" type="submit">
                    Update Category
            </button>
            </div>
        </form>
    </div>
</div>

@endsection
@else
<script>window.location = "{{route('home')}}";</script>
@endauth
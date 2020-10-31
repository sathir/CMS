@extends('layouts.app')

@auth

@section('content')

<div class="d-flex justify-content-end">
<a href="{{route('categories.create')}}" class="btn btn-primary float-right my-2">
        Create Category
    </a>
</div>


<div class="card card-default">
    <div class="card-header">
        Categories
    </div>
    <div class="card-body">
        <ul class="list">
            @foreach($categories as $category)
            <li class="list-item">
            {{$category->name}} 
            <form method="POST" action="{{route('categories.destroy',$category->id)}}">{{ method_field('DELETE') }}{!! csrf_field() !!}
                <a href="{{route('categories.edit',$category->id)}}" class="btn btn-warning btn-sm">Edit</a>
                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
            </form>
            <a class="btn btn-primary btn-sm my-2">Number of posts : {{$category->posts->count()}}</a>               
            </li>
        </br>
            @endforeach
        </ul>
    </div>
</div>

@endsection
@else
<script>window.location = "{{route('home')}}";</script>
@endauth
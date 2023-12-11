@extends('layouts.layout')

@section('content')
    <div class="wrapper license-details">
        <h1>License for {{ $license->license_name }}</h1>
        <p class="type">Description - {{ $license->license_desc }}</p>
    </div>
    <form action="/licenses/{{$license->license_id}}" method="POST">
        @csrf
        @method('DELETE')
        <button>DELETE</button>
    </form>
    <a href="/licenses/{{$license->license_id}}/edit" class="edit">Edit</a>
    <a href="/licenses" class="back"><- Back to all licenses</a>
@endsection

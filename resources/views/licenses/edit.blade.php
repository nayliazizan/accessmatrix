@extends('layouts.layout')

@section('content')
    <div class="wrapper edit-license">
        <h1>Edit License</h1>
        <form action="/licenses/{{$license->license_id}}" method="POST">
            @csrf
            @method('PUT')
            <label for="license_name">Name:</label>
            <input type="text" id="license_name" name="license_name" value="{{$license->license_name}}">
            <label for="license_desc">Description:</label>
            <textarea name="license_desc" rows="5" cols="40">{{$license->license_desc}}</textarea>
            <input type="submit" name="submit" value="Update License"> 
        </form>
    </div>
@endsection


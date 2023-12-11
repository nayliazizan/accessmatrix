@extends('layouts.layout')

@section('content')
                <div class="wrapper create-license">
                    <h1>Create a New License</h1>
                    <form action="/licenses" method="POST">
                        @csrf
                        <label for="license_name">Name:</label>
                        <input type="text" id="license_name" name="license_name">
                        <label for="license_desc">Description:</label>
                        <textarea name="license_desc" rows="5" cols="40"></textarea>
                        <input type="submit" name="submit" value="Create License"> 
                    </form>
                </div>
@endsection
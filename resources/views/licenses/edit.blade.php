@extends('layouts.layout')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1 class="mb-0">Edit License</h1>
                </div>
                <div class="card-body">
                    <form action="/licenses/{{$license->license_id}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="license_name">Name:</label>
                            <input type="text" class="form-control" id="license_name" name="license_name" value="{{$license->license_name}}">
                        </div>
                        <div class="form-group">
                            <label for="license_desc">Description:</label>
                            <textarea class="form-control" name="license_desc" rows="5" cols="40">{{$license->license_desc}}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update License</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


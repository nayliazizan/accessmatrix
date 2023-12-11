@extends('layouts.layout')

@section('content')
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    License List
                </div>
                <div>
                    @foreach($licenses as $license)
                        <div>
                            {{ $license->license_name }} - {{ $license->license_desc }}
                        </div>
                    @endforeach
                </div>
                <a href="/licenses/create">Add a New License</a>
            </div>
        </div>
@endsection
@extends('layouts.layout')
 
@section('content')
 
    <div class="card text-center">
        <div class="card-header">
            MAIN FUNCTIONS
        </div>
 
        <div class="card-body">
                <div class="container">
                    <div class="row">
                        <div class="col-sm">
                            <img src="{{ asset('public/img/layers-player-slides-svgrepo-com.svg') }}" alt="layers" width="100" height="100" class="p-3">
                            <br>
                            <a href="{{ route('licenses.index') }}" class="btn btn-primary">Manage Licenses</a>
                        </div>
                       
                        <div class="col-sm">
                            <img src="{{ asset('public/img/folder-svgrepo-com.svg') }}" alt="folder" width="100" height="100" class="p-3">
                            <br>
                            <a href="{{ route('projects.index') }}" class="btn btn-primary">Manage Projects</a>
                        </div>
 
                        <div class="col-sm">
                            <img src="{{ asset('public/img/employees-svgrepo-com.svg') }}" alt="group of people" width="100" height="100" class="p-3">
                            <br>
                            <a href="{{ route('groups.index') }}" class="btn btn-primary">Manage Groups</a>
                        </div>
 
                        <div class="col-sm">
                            <img src="{{ asset('public/img/new-employee-male-doing-a-guts-pose-svgrepo-com.svg') }}" alt="person" width="100" height="100" class="p-3">
                            <br>
                            <a href="{{ route('staffs.index') }}" class="btn btn-primary">Manage Staff</a>
                        </div>
 
                        <div class="col-sm">
                            <img src="{{ asset('public/img/magnifying-glass-svgrepo-com.svg') }}" alt="glass" width="100" height="100" class="p-3">
                            <br>
                            <a href="{{ route('tracker.form') }}" class="btn btn-primary">Track Difference</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
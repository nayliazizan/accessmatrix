@extends('layouts.layout')

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Licenses</h5>
                    <p class="card-text">Manage licenses</p>
                    <a href="{{ route('licenses.index') }}" class="btn btn-primary">Go to Licenses</a>
                </div>
            </div>
        </div>

        <!-- Add similar cards for Projects, Groups, and Tracker -->
        
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Projects</h5>
                    <p class="card-text">Manage projects</p>
                    <a href="{{ route('projects.index') }}" class="btn btn-primary">Go to Projects</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Groups</h5>
                    <p class="card-text">Manage groups</p>
                    <a href="{{ route('groups.index') }}" class="btn btn-primary">Go to Groups</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Tracker</h5>
                    <p class="card-text">Manage tracker (To be developed)</p>
                    <!-- Link to future tracker page -->
                    <a href="#" class="btn btn-primary disabled">Coming Soon</a>
                </div>
            </div>
        </div>
    </div>
@endsection

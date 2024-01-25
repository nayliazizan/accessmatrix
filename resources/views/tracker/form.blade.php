@extends('layouts.layout')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">Difference Tracker</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('tracker.results') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="to_track">Select what to track:</label>
                            <select class="form-control" id="to_track" name="to_track" required>
                                <option value="status">Status</option>
                                <option value="department">Department</option>
                                <option value="all">All</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="excel_file">Upload Excel File:</label>
                            <input type="file" name="excel_file" accept=".xlsx, .xls">
                        </div>

                        <button type="submit" class="btn btn-primary">TRACK</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

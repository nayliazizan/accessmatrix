@extends('layouts.layout')

@section('content')

<button type="button" class="btn btn-warning"><a href="/licenses/create">ADD</a></button>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exportListModal">
    LIST
</button>

<!-- Export List Modal -->
<div class="modal fade" id="exportListModal" tabindex="-1" role="dialog" aria-labelledby="exportListModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportListModalLabel">Export List Options</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Choose which list you want to export:</p>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exportFormatModal">
                    LICENSES
                </button>
                <button type="button" class="btn btn-primary" disabled>
                    LICENSES & PROJECTS (To be developed)
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Export Format Modal -->
<div class="modal fade" id="exportFormatModal" tabindex="-1" role="dialog" aria-labelledby="exportFormatModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportFormatModalLabel">Export Format Options</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Choose in what format you want the record to be exported:</p>
                <a href="{{ route('exportListLicense', ['format' => 'csv']) }}" class="btn btn-primary">CSV</a>
                <a href="{{ route('exportListLicense', ['format' => 'pdf']) }}" class="btn btn-primary">PDF</a>
            </div>
        </div>
    </div>
</div>

<table class="table">
  <thead class="thead-light">
    <tr>
      <th scope="col">#</th>
      <th scope="col">LICENSE NAME</th>
      <th scope="col">DESCRIPTION</th>
      <th scope="col">UPDATE</th>
      <th scope="col">DELETE</th>
    </tr>
  </thead>
  <tbody>
    @foreach($licenses as $license)
        <tr>
            <th scope="row">{{ $license->license_id }}</th>
            <td>{{ $license->license_name }}</td>
            <td>{{ $license->license_desc }}</td>
            <td>
                <!-- <a href="/licenses/{{ $license->license_id }}/edit" class="btn btn-primary">UPDATE</a> -->

                @if($license->trashed())
                    <button class="btn btn-secondary" disabled>UPDATE</button>
                @else
                    <a href="/licenses/{{ $license->license_id }}/edit" class="btn btn-primary">UPDATE</a>
                @endif
            </td>
            <td>
                @if ($license->trashed())
                    <!-- Display the RESTORE button for soft-deleted licenses -->
                    <form action="{{ route('licenses.restore', $license->license_id) }}" method="GET">
                        @csrf
                        @method('GET')
                        <button type="submit" class="btn btn-success">RESTORE</button>
                    </form>
                @else
                    <!-- Display the DELETE button for non-soft-deleted licenses -->
                    <form action="{{ route('licenses.destroy', $license->license_id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">DELETE</button>
                    </form>
                @endif
            
                <!-- Delete Modal -->
                <div class="modal fade" id="deleteModal{{ $license->license_id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel">Delete Confirmation</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Are you sure to delete '{{ $license->license_name }}' license?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
                                <!-- Form to handle the DELETE request -->
                                <form action="/licenses/{{ $license->license_id }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">YES</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </td>

        </tr>
    @endforeach
  </tbody>
</table>
@endsection

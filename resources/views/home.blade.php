@extends('layouts.app')

@section('content')
<div class="container dashboard">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Your Sites
                    <a href="/sites/create"><button class="btn-new">New Site</button></a>
                </div>

                <div class="card-body">

                    <!-- List Sites -->
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>URL</th>
                                <th>Port</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sites as $site)
                            <tr>
                                <td>{{ $site->name }}</td>
                                <td>{{ $site->url }}</td>
                                <td>{{ $site->port }}</td>
                                <td>
                                    @if ($site->status == 'online')
                                        <span class="badge badge-success">Online</span>
                                    @else  
                                        <span class="badge badge-danger">Offline</span>
                                    @endif
                                </td>
                                <td>
                                <a href="{{$site->url}}" target="_blank" class="btn btn-light">View</a>
                                    <a href="{{ route('sites.edit', $site->id) }}" class="btn btn-secondary">Edit</a>
                                    <form action="{{ route('sites.destroy', $site->id) }}" method="POST"
                                            style="display: inline"
                                            onsubmit="return confirm('Are you sure?');">
                                        <input type="hidden" name="_method" value="DELETE">
                                        {{ csrf_field() }}
                                        <button class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="5">No entries found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <!-- End List Sites -->
                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

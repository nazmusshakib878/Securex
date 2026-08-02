@extends('admin-panel')
@section("content")
<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
                <div class="page-header-kicker">Services</div>
                <h5 class="card-title mb-1">Service List</h5>
                <p class="text-muted mb-0">Create, update and manage all visible services.</p>
            </div>
            <a href="{{ route('viewServiceAddForm') }}" class="btn btn-primary btn-sm text-white"><i class="bi bi-plus-lg me-1"></i>Add Service</a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $service)
                    <tr>
                        <td><img src="{{$service->image_url}}" alt="{{$service->title}}" height="64" width="88" class="rounded object-fit-cover"></td>
                        <td class="fw-semibold">{{$service->title}}</td>
                        <td>${{ number_format($service->price, 2) }}</td>
                        <td class="text-muted">{{$service->description}}</td>
                        <td>
                            @if($service->isActive == 1)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{route("viewServiceEditForm", $service->id)}}" class="btn btn-outline-primary btn-sm"><i class="bi bi-pencil me-1"></i>Edit</a>
                                <form action="{{ route('deleteService', $service) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this service?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash me-1"></i>Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

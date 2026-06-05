@extends('admin-panel')
@section('content')
<div class="container-fluid px-0">
    <div class="row">
        <div class="col-12 col-xl-8">
            <div class="card">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <div class="page-header-kicker">Services</div>
                    <h5 class="card-title mb-0">Edit Service</h5>
                    <p class="text-muted mb-0">Update service details and homepage visibility.</p>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('editService') }}" method="post">
                        @csrf
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif
                        <input type="hidden" name="id" value="{{$service->id}}">
                        <div class="mb-3">
                            <label for="image_url" class="form-label">Image URL</label>
                            <input type="url" value="{{ old('image_url', $service->image_url) }}" class="form-control" id="image_url" name="image_url" required>
                        </div>
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" value="{{ old('title', $service->title) }}" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="short_description" class="form-label">Short Description</label>
                            <textarea class="form-control" id="short_description" name="short_description" rows="3" required>{{ old('short_description', $service->description) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Service Price</label>
                            <input type="number" step="0.01" min="0" class="form-control" id="price" name="price" value="{{ old('price', $service->price) }}" required>
                        </div>
                        <div class="form-check form-switch mb-4">
                            <input type="checkbox" name="isActive" id="isActive" class="form-check-input" {{$service->isActive == 1 ? "checked" : ""}}>
                            <label for="isActive" class="form-check-label">Active on homepage</label>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary"><i class="bi bi-check2 me-1"></i>Save Changes</button>
                            <a href="{{ route('viewServiceList') }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

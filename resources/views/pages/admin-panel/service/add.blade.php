@extends('admin-panel')
@section('content')
<div class="container-fluid px-0">
    <div class="row">
        <div class="col-12 col-xl-8">
            <div class="card">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <div class="page-header-kicker">Services</div>
                    <h5 class="card-title mb-0">Add New Service</h5>
                    <p class="text-muted mb-0">Add a service that can appear on the public homepage.</p>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('storeService') }}" method="post">
                        @csrf
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif
                        <div class="mb-3">
                            <label for="image_url" class="form-label">Image URL</label>
                            <input type="url" class="form-control" id="image_url" name="image_url" value="{{ old('image_url') }}" placeholder="https://example.com/service.jpg" required>
                        </div>
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="short_description" class="form-label">Short Description</label>
                            <textarea class="form-control" id="short_description" name="short_description" rows="3" required>{{ old('short_description') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Service Price</label>
                            <input type="number" step="0.01" min="0" class="form-control" id="price" name="price" value="{{ old('price', '0.00') }}" required>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary"><i class="bi bi-check2 me-1"></i>Add Service</button>
                            <a href="{{ route('viewServiceList') }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

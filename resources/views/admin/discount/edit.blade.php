@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-8 offset-2">
                <div class="card mt-3">
                    <div class="card-header">
                        Update Discount : {{ $discount->name }}
                    </div>
                    <div class="card-body">
                        @include('components.alert')
                        <form action="{{ route('admin.discount.update', $discount->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="form-group mt-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    placeholder="Discount Name" value="{{ old('name') ?? $discount->name }}">
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mt-3">
                                <label for="code" class="form-label">Code</label>
                                <input type="text" class="form-control " name="code" id="code"
                                    placeholder="Discount Name" value="{{ old('code') ?? $discount->code }}">
                                @error('code')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mt-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" id="description" cols="0" rows="2" class="form-control">{{ old('description') ?? $discount->description }}</textarea>
                                @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mt-3">
                                <label for="percentage" class="form-label">Percentage</label>
                                <input type="number" name="percentage" id="percentage" min="1" max="100"
                                    class="form-control" placeholder="Discount Percentage"
                                    value="{{ old('percentage') ?? $discount->percentage }}">
                                @error('percentage')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mt-3">
                                <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

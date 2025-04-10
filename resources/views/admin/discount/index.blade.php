@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-8 offset-2">
                <div class="card mt-3">
                    <div class="card-header">
                        Discounts
                    </div>
                    <div class="card-body">
                        @include('components.alert')
                        <div class="row ">
                            <div class="col-md-12 d-flex flex-row-reverse">
                                <a href="{{ route('admin.discount.create') }}" class="btn btn-sm btn-primary">Add Discount</a>
                            </div>
                        </div>

                        <table class="table mt-5">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Code</th>
                                    <th>Percentage</th>
                                    <th>Description</th>
                                    <th colspan="2">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($discounts as $discount)
                                    <tr class="align-middle
                                    ">
                                        <td>
                                            {{ $discount->name }}
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">{{ $discount->code }}</span>
                                        </td>
                                        <td>
                                            {{ $discount->percentage }}%
                                        </td>
                                        <td>
                                            {{ $discount->description }}
                                        </td>
                                        <td>
                                            <div class="d-flex flex-row gap-2">
                                                <a class="btn btn-warning btn-sm"
                                                    href="{{ route('admin.discount.edit', $discount->id) }}">Edit</a>
                                                <form action="{{ route('admin.discount.destroy', $discount) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="col-span-6">No Discount Created</tr>
                                @endforelse
                            </tbody>
                        </table>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

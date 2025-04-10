@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-8 offset-2">
                <div class="card">
                    <div class="card-header">
                        My Camps
                    </div>
                    <div class="card-body">
                        @include('components.alert')
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Camp</th>
                                    <th>Price</th>
                                    <th>Register</th>
                                    <th>Paid Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($checkouts as $checkout)
                                    <tr>
                                        <td>
                                            {{ $checkout->user->name }}
                                        </td>
                                        <td>
                                            {{ $checkout->camp->title }}
                                        </td>
                                        <td>
                                            Rp.{{ $checkout->camp->price }}
                                        </td>
                                        <td>
                                            {{ $checkout->created_at->format('d-m-Y') }}
                                        </td>
                                        <td>
                                            <strong>
                                                {{ $checkout->payment_status }}
                                            </strong>
                                        </td>

                                    </tr>
                                @empty
                                    <tr class="col-span-3">No Camps Registered</tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

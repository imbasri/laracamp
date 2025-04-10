@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-8 offset-2">
                <div class="card mt-3">
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
                                            {{-- jadi ini dikondisikan karna semisalnya sudah di production dan diskon baru dibuat, karna total itu dari create transaksi dan sebelumnya total jadi nullabel karna belum ada diskon maka kondisi ini jadi yang dipakai --}}
                                            <strong>Rp.{{ number_format($checkout->total ?: $checkout->camp->price, 2) }}
                                                @if ($checkout->discount_percentage)
                                                    <span class="badge bg-success text-center">
                                                        disc {{ $checkout->discount_percentage }}%</span>
                                                @endif
                                            </strong>
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

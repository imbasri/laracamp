@extends('layouts.app')

@section('content')
    <section class="dashboard my-5">
        <div class="container">
            <div class="row text-left">
                <div class=" col-lg-12 col-12 header-wrap mt-4">
                    <p class="story">
                        DASHBOARD
                    </p>
                    <h2 class="primary-header ">
                        My Bootcamps
                    </h2>
                </div>
            </div>
            <div class="row my-5">
                @include('components.alert')
                <table class="table *:table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Bootcamp</th>
                            <th scope="col">Price</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($checkouts as $checkout)
                            <tr class="align-middle">
                                <td width="18%">
                                    <img src="{{ asset('images/item_bootcamp.png') }}" height="120" alt="">
                                </td>
                                <td>
                                    <p class="mb-2">
                                        <strong>{{ $checkout->camp->title }}</strong>
                                    </p>
                                    <p>
                                        {{ \Carbon\Carbon::parse($checkout->created_at)->format('F j, Y') }}
                                    </p>
                                </td>
                                <td>
                                    <strong>Rp.{{ number_format($checkout->camp->price, 2) }}</strong>
                                </td>
                                <td>
                                    <strong> {{ $checkout->payment_status }}</strong>
                                </td>
                                <td>
                                    @if ($checkout->payment_status == 'waiting')
                                        <a href="{{ $checkout->midtrans_url }}" class="btn btn-primary">
                                            Pay here
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    <a href="https://wa.me/085000000?text=Hi,saya ingin bertanya tentang class {{ $checkout->camp->title }} dengan saya {{ Auth::user()->name }}"
                                        class="btn btn-primary" target="_blank">
                                        Contact Admin
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No Camp checkouts available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection

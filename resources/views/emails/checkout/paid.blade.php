@component('mail::message')
    # Your Order is Confirmed!

    Hi, {{ $checkout->User->name }}!

    Your order with ID {{ $checkout->id }} has been successfully processed.
    We appreciate your business and are excited to let you know that your order is now being prepared for shipment. Below
    are the details of your order:
    - **Order ID:** {{ $checkout->id }}
    - **Order Date:** {{ $checkout->created_at->format('Y-m-d H:i:s') }}
    - **Total Amount:** Rp.{{ $checkout->Camp->price }}


    Thank you for your order! We are currently processing it and will send you a confirmation email once it has been
    shipped.

    The body of your message.

    @component('mail::button', ['url' => route('user.dashboard')])
        My Dashboard
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent

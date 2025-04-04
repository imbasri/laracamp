@component('mail::message')
    # Register Camp: {{ $checkout->Camp->title }}

    Hello {{ $checkout->user->name }},
    We are excited to inform you that your registration for the camp {{ $checkout->Camp->title }} has been successfully
    completed.
    Your payment of {{ $checkout->amount }} has been received, and your spot is secured.

    We appreciate your prompt payment and look forward to seeing you at the camp. If you have any questions or need further
    assistance, please feel free to reach out to us.
    We will send you more details about the camp soon, including the schedule, location, and any other important
    information.

    If you have any questions or need further assistance, please feel free to reach out to us.
    We are looking forward to seeing you at the camp!

    Thanks for registering for the camp {{ $checkout->Camp->title }}. Your registration is confirmed.

    @component('mail::button', ['url' => route('user.dashboard')])
        Get Invoice
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent

@component('mail::message')
    # Welcome!
    Hi , {{ $user->name }}
    Welcome to Laracamp, your account has been created successfully.
    You can now log in to your account and start exploring all the features we have to offer.
    We are excited to have you on board and look forward to seeing you in our community.
    If you have any questions or need assistance, feel free to reach out to our support team.
    We are here to help you every step of the way.


    Thanks , If you did not create an account, no further action is required.
    This is a system-generated email, please do not reply.

    @component('mail::button', ['url' => route('login')])
        Login here!
    @endcomponent
    {{ config('app.name') }}
@endcomponent

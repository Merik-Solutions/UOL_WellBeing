@component('mail::message')

Our Response On Your Message Of {{$contact->subject}} is :

{{$contact->reply}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent

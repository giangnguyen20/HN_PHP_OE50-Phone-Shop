@component('mail::message')
Hello, {{ $user->fullname }}

Weekly order report

Last week, Ordered quantity is {{ $orders }}
 
@component('mail::button', ['url' => route('admin.')])
Orders management
@endcomponent
 
Thanks,<br>
{{ config('app.name') }}
@endcomponent

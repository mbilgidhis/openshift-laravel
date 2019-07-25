@component('mail::message')
# Hello,

You have been registered to our system. Please login using these information,

@component('mail::table')
|  Email         | 	Password        |
| :------------: | :---------------:|
| [Your Email]   | {{ $password }}  |

@endcomponent

@component('mail::button', ['url' => ''])
Login Here
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

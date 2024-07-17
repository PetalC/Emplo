<x-mail::message>
# Heading 1
## Heading 2
### Heading 3

<x-email.check-list>
<x-email.check-list-item>Name: Test</x-email.check-list-item>
<x-email.check-list-item>Email: test@test.com</x-email.check-list-item>
</x-email.check-list>

Some text thrown in

<x-mail::table>
| Laravel       | Table         | Example  |
| ------------- |:-------------:| --------:|
| Col 2 is      | Centered      | $10      |
| Col 3 is      | Right-Aligned | $20      |
</x-mail::table>

<x-mail::panel>
Message in a panel...
</x-mail::panel>

<x-mail::button color="error" align="left" :url="''">
Button Text
</x-mail::button>

<x-mail::button align="center" color="primary" :url="''">
Button Text
</x-mail::button>
<x-mail::button align="right" color="success" :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>


{{--{{$time}}--}}


<tr>
    <td class="border px-4 py-2">Monday</td>
    <td class="border px-4 py-2">
        @if ($time->{'monday-start'})
            {{ $time->{'monday-start'} }}
        @else
            Not available
        @endif
    </td>
    <td class="border px-4 py-2">

        {{ $time->{'monday-end'} }}

    </td>
</tr>
<tr>
    <td class="border px-4 py-2">Tuesday</td>
    <td class="border px-4 py-2">
        @if ($time->{'tuesday-start'})
            {{ $time->{'tuesday-start'} }}
        @else
           <span class="text-red-500"> Not available</span>
        @endif
    </td>
    <td class="border px-4 py-2">

        {{ $time->{'tuesday-end'} }}

    </td>
</tr>
<tr>
    <td class="border px-4 py-2">Wednesday</td>
    <td class="border px-4 py-2">
        @if ($time->{'wednesday-start'})
            {{ $time->{'wednesday-start'} }}
        @else
            <span class="text-red-500"> Not available</span>
        @endif
    </td>
    <td class="border px-4 py-2">

        {{ $time->{'wednesday-end'} }}

    </td>
</tr>
<tr>
    <td class="border px-4 py-2">Thursday</td>
    <td class="border px-4 py-2">
        @if ($time->{'thursday-start'})
            {{ $time->{'thursday-start'} }}
        @else
            <span class="text-red-500"> Not available</span>
        @endif
    </td>
    <td class="border px-4 py-2">

        {{ $time->{'thursday-end'} }}

    </td>
</tr>
<tr>
    <td class="border px-4 py-2">Friday</td>
    <td class="border px-4 py-2">
        @if ($time->{'friday-start'})
            {{ $time->{'friday-start'} }}
        @else
            <span class="text-red-500"> Not available</span>
        @endif
    </td>
    <td class="border px-4 py-2">

        {{ $time->{'friday-end'} }}

    </td>
</tr>
<tr>
    <td class="border px-4 py-2">Saturday</td>
    <td class="border px-4 py-2">
        @if ($time->{'saturday-start'})
            {{ $time->{'saturday-start'} }}
        @else
            <span class="text-red-500"> Not available</span>
        @endif
    </td>
    <td class="border px-4 py-2">
        {{ $time->{'saturday-end'} }}

    </td>
</tr>
<tr>
    <td class="border px-4 py-2">Sunday</td>
    <td class="border px-4 py-2">
        @if ($time->{'sunday-start'})
            {{ $time->{'sunday-start'} }}
        @else
            <span class="text-red-500"> Not available</span>
        @endif
    </td>
    <td class="border px-4 py-2">
        {{ $time->{'sunday-end'} }}

    </td>
</tr>

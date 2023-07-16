<tr>
    <td class="border px-4 py-2">Monday</td>
    <td class="border px-4 py-2">
        @if ($time->{'monday-start'})
            {{ \Carbon\Carbon::createFromFormat('H:i:s', $time->{'monday-start'})->format('h:i A') }}
        @else
            <span class="text-red-500">Not available</span>
        @endif
    </td>
    <td class="border px-4 py-2">
        @if ($time->{'monday-end'})
            {{ \Carbon\Carbon::createFromFormat('H:i:s', $time->{'monday-end'})->format('h:i A') }}
        @else
            <span class="text-red-500">Not available</span>
        @endif
    </td>
</tr>
<tr>
    <td class="border px-4 py-2">Tuesday</td>
    <td class="border px-4 py-2">
        @if ($time->{'tuesday-start'})
            {{ \Carbon\Carbon::createFromFormat('H:i:s', $time->{'tuesday-start'})->format('h:i A') }}
        @else
            <span class="text-red-500">Not available</span>
        @endif
    </td>
    <td class="border px-4 py-2">
        @if ($time->{'tuesday-end'})
            {{ \Carbon\Carbon::createFromFormat('H:i:s', $time->{'tuesday-end'})->format('h:i A') }}
        @else
            <span class="text-red-500">Not available</span>
        @endif
    </td>
</tr>
<tr>
    <!-- Repeat the same pattern for other days (Wednesday to Sunday) -->
    <!-- Wednesday -->
    <td class="border px-4 py-2">Wednesday</td>
    <td class="border px-4 py-2">
        @if ($time->{'wednesday-start'})
            {{ \Carbon\Carbon::createFromFormat('H:i:s', $time->{'wednesday-start'})->format('h:i A') }}
        @else
            <span class="text-red-500">Not available</span>
        @endif
    </td>
    <td class="border px-4 py-2">
        @if ($time->{'wednesday-end'})
            {{ \Carbon\Carbon::createFromFormat('H:i:s', $time->{'wednesday-end'})->format('h:i A') }}
        @else
            <span class="text-red-500">Not available</span>
        @endif
    </td>
</tr>
<tr>
    <!-- Repeat the same pattern for other days (Thursday to Sunday) -->
    <!-- Thursday -->
    <td class="border px-4 py-2">Thursday</td>
    <td class="border px-4 py-2">
        @if ($time->{'thursday-start'})
            {{ \Carbon\Carbon::createFromFormat('H:i:s', $time->{'thursday-start'})->format('h:i A') }}
        @else
            <span class="text-red-500">Not available</span>
        @endif
    </td>
    <td class="border px-4 py-2">
        @if ($time->{'thursday-end'})
            {{ \Carbon\Carbon::createFromFormat('H:i:s', $time->{'thursday-end'})->format('h:i A') }}
        @else
            <span class="text-red-500">Not available</span>
        @endif
    </td>
</tr>
<tr>
    <!-- Repeat the same pattern for other days (Friday to Sunday) -->
    <!-- Friday -->
    <td class="border px-4 py-2">Friday</td>
    <td class="border px-4 py-2">
        @if ($time->{'friday-start'})
            {{ \Carbon\Carbon::createFromFormat('H:i:s', $time->{'friday-start'})->format('h:i A') }}
        @else
            <span class="text-red-500">Not available</span>
        @endif
    </td>
    <td class="border px-4 py-2">
        @if ($time->{'friday-end'})
            {{ \Carbon\Carbon::createFromFormat('H:i:s', $time->{'friday-end'})->format('h:i A') }}
        @else
            <span class="text-red-500">Not available</span>
        @endif
    </td>
</tr>
<tr>
    <!-- Repeat the same pattern for other days (Saturday and Sunday) -->
    <!-- Saturday -->
    <td class="border px-4 py-2">Saturday</td>
    <td class="border px-4 py-2">
        @if ($time->{'saturday-start'})
            {{ \Carbon\Carbon::createFromFormat('H:i:s', $time->{'saturday-start'})->format('h:i A') }}
        @else
            <span class="text-red-500">Not available</span>
        @endif
    </td>
    <td class="border px-4 py-2">
        @if ($time->{'saturday-end'})
            {{ \Carbon\Carbon::createFromFormat('H:i:s', $time->{'saturday-end'})->format('h:i A') }}
        @else
            <span class="text-red-500">Not available</span>
        @endif
    </td>
</tr>
<tr>
    <!-- Sunday -->
    <td class="border px-4 py-2">Sunday</td>
    <td class="border px-4 py-2">
        @if ($time->{'sunday-start'})
            {{ \Carbon\Carbon::createFromFormat('H:i:s', $time->{'sunday-start'})->format('h:i A') }}
        @else
            <span class="text-red-500">Not available</span>
        @endif
    </td>
    <td class="border px-4 py-2">
        @if ($time->{'sunday-end'})
            {{ \Carbon\Carbon::createFromFormat('H:i:s', $time->{'sunday-end'})->format('h:i A') }}
        @else
            <span class="text-red-500">Not available</span>
        @endif
    </td>
</tr>

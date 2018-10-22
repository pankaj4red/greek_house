<ul>
    <li>Name: {{ $user->getFullName() }}</li>
    <li>Email: {{ $user->email }}</li>
    <li>Phone: {{ $user->phone }}</li>
    @if ($user->campaigns->first())
        <li><a href="{{ route('dashboard::details', [$user->campaigns->first()->id]) }}">Campaign {{ $user->campaigns->first()->id }}</a></li>
        <li>Estimated Quantity: {{ $user->campaigns->first()->estimated_quantity }}</li>
        <li>Colors Front: {{ $user->campaigns->first()->print_front ? $user->campaigns->first()->print_front_colors : 0}}</li>
        <li>Colors Pocket: {{ $user->campaigns->first()->print_pocket ? $user->campaigns->first()->print_pocket_colors : 0}}</li>
        <li>Colors Back: {{ $user->campaigns->first()->print_back ? $user->campaigns->first()->print_back_colors : 0}}</li>
        <li>Colors Sleeves: {{ $user->campaigns->first()->print_sleeve ? $user->campaigns->first()->print_sleeve_colors : 0}}</li>
        <li>College: {{ $user->campaigns->first()->contact_school }}</li>
        <li>Chapter: {{ $user->campaigns->first()->contact_chapter }}</li>
        <li>Address:<br/>
            {{ $user->campaigns->first()->address_line1 }}<br/>
            @if ($user->campaigns->first()->address_line2)
                {{ $user->campaigns->first()->address_line2 }}<br/>
            @endif
            {{ $user->campaigns->first()->address_city }}, {{ $user->campaigns->first()->address_state }} {{ $user->campaigns->first()->address_zip_code }}<br/>
            {{ $user->campaigns->first()->country }}
        </li>
    @endif
</ul>
@auth
    @unless(count($filteredUsers) == 0)
        <h3 class="font-semibold text-lg mt-5">Connections</h3>
    @endunless
    @foreach($filteredUsers as $user)
        @if (($user->account_type === 'Client' && auth()->user()->account_type === 'Business') || ($user->account_type === 'Business' && auth()->user()->account_type === 'Client'))
            @if($user->connectedUsers->contains(auth()->user()) || auth()->user()->connectedUsers->contains($user))
                <div class="space-y-4 mt-3">
                    <div class="flex items-center space-x-1">
                        <img class="w-8 h-8 rounded-full" src="{{ asset('storage/' . $user->photos) }}" alt="User 1 Image">
                        <div>
                            @if($user['client-name'])
                                <h3 class="ml-3 font-semibold">{{$user['client-name']}}</h3>
                            @elseif($user->name)
                                <h3 class="ml-3 font-semibold">{{$user->name}}</h3>
                            @endif
                        </div>
                        @if(auth()->user()->account_type === 'Business')
                            <a href="/listings/create/{{$user->id}}/{{auth()->id()}}" class="ml-4 inline-block">
                                <i class="fas fa-calendar-plus text-teal-500 "></i>
                            </a>
                        @elseif(auth()->user()->account_type === 'Client')
{{--                            @php--}}
{{--                                $clientId = auth()->id(); // Retrieve the client ID--}}
{{--                                $connectedUser = $user->connectedUsers->firstWhere('id', $clientId);--}}
{{--                            @endphp--}}
                            <a href="/listings/create/{{auth()->id()}}/{{$user->id}}" class="ml-4 inline-block">
                                <i class="fas fa-calendar-plus text-teal-500 "></i>
                            </a>
                        @endif

                    </div>
                    <!-- Additional content for users with pending requests or connected users -->
                </div>
            @endif
        @endif
    @endforeach
@endauth

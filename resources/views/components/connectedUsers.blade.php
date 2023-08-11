@auth
    @unless(count($filteredUsers) == 0)
        <h3 class="font-semibold text-lg mt-5" style="color: white !important;">Connections</h3>
    @endunless
    @foreach($filteredUsers as $user)
        @if (($user->account_type === 'Client' && auth()->user()->account_type === 'Business') || ($user->account_type === 'Business' && auth()->user()->account_type === 'Client'))
            @if($user->connectedUsers->contains(auth()->user()) || auth()->user()->connectedUsers->contains($user))
                <div class="space-y-4 mt-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            @if($user->photos)
                                <img class="w-8 h-8 rounded-full" src="{{ asset('storage/' . $user->photos) }}" alt="User 1 Image">
                            @else
                                <img class="w-8 h-8 rounded-full" src="/images/avatar.png" alt="User 1 Image">
                            @endif

                            <div class="text-white">
                                @if($user['client-name'])
                                    <h3 class="ml-3 font-semibold">{{$user['client-name']}}</h3>
                                @elseif($user->name)
                                    <h3 class="ml-3 font-semibold">{{$user->name}}</h3>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center">
                            @if(auth()->user()->account_type === 'Business')
                                <a href="/calendar/{{$user->id}}/{{auth()->id()}}" class="ml-4 inline-block">
                                    <i class="fas fa-calendar-plus text-teal-500"></i>
                                </a>
                            @elseif(auth()->user()->account_type === 'Client')
                                <a href="/calendar/{{auth()->id()}}/{{$user->id}}" class="ml-4 inline-block">
                                    <i class="fas fa-calendar-plus text-teal-500"></i>
                                </a>
                            @endif
                            <!-- Additional content for users with pending requests or connected users -->
                        </div>
                    </div>
                </div>



            @endif
        @endif
    @endforeach
@endauth

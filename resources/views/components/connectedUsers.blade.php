@auth
    @if($filteredUsers->count() > 0)
        <h3 class="font-semibold text-lg mt-5">Connections</h3>
    @endif
    @foreach($filteredUsers as $user)
        @if (($user->account_type === 'Client' && auth()->user()->account_type === 'Business') || ($user->account_type === 'Business' && auth()->user()->account_type === 'Client'))
            @if($user->connectedUsers->contains(auth()->user()))
                <div class="space-y-4 mt-5">
                    <div class="flex items-center space-x-1">
                        <img class="w-8 h-8 rounded-full" src="{{ asset('storage/' . $user->photos) }}" alt="User 1 Image">
                        <div>
                            @if($user['client-name'])
                                <h3 class="ml-3 font-semibold">{{$user['client-name']}}</h3>
                            @elseif($user->name)
                                <h3 class="ml-3 font-semibold">{{$user->name}}</h3>
                            @endif
                        </div>
                        <a href="/listings/create" class="ml-4 inline-block">
                            <i class="fas fa-calendar-plus text-green-500 text-2xl"></i>
                        </a>
                    </div>
                    <!-- Additional content for users with pending requests or connected users -->
                </div>
            @endif
        @endif
    @endforeach
@endauth

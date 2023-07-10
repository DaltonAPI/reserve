
<div class="flex flex-col ">
    <div class="bg-white rounded-lg shadow-md relative mb-3">


            @auth
                @if (auth()->user()->id === $user->id)
                    <div class="flex ">

                        <a href="/edit/user" class="edit-icon absolute top-0 right-6 m-2 text-pink-600 hover:text-pink-700">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form id="profileForm{{$user->id}}" method="POST" action="{{ route('profile.destroy', $user->id) }}" onsubmit="return confirm('Are you sure you want to delete this account?')">
                            @csrf
                            @method('DELETE')
                            <!-- Rest of the form code -->
                            <button type="submit" ><a class="save-icon  absolute top-0 right-0 m-2 text-pink-600 hover:text-pink-700">
                                <button><i class="fas fa-trash"></i></button>
                             </a></button>
                            </form>
                    </div>
                @endif
            @endauth

            @csrf
            @method('PUT')

            <div class="flex flex-col md:flex-row">
                <div class="md:w-1/3 flex items-center justify-center">
                    <div class="overflow-hidden w-28 h-16 md:w-56 md:h-56  border-gray-300 mt-5">
                        @if ($user->photos)
                            <img src="{{ asset('storage/' . $user->photos) }}" alt="User Photo" class="rounded-lg border h-full w-2/3">
                        @else
                            <img src="/images/business.png" alt="Default User Photo" class="rounded-lg border h-full w-2/3">
                        @endif
                    </div>

                </div>
                <div class="p-6 md:w-2/3 mt-8">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-user text-pink-600 mr-2"></i>
                        <h5 class="text-2xl font-bold text-gray-900">
                            @if($user->name)
                            <span class="name-label">{{ $user->name }}</span>
                            @elseif($user['client-name'])
                                <span class="name-label">{{ $user['client-name'] }}</span>
                            @endif
                        </h5>
                    </div>

                    <div class="flex items-center mb-2">
                        @if($user->bio)
                        <p class="text-gray-700">
                            <i class="fas fa-info-circle text-pink-600 mr-2"></i>
                            <span class="bio-label">{{ $user->bio }}</span>
                        </p>
                        @endif

                    </div>

                    <div class="contact-info">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-envelope text-pink-600 mr-2"></i>
                            <span class="email-label">{{ $user->email }}</span>
                            <input type="text" class="hidden input-field bg-gray-100 rounded px-4 py-2 ml-2 w-2/3"
                                   name="email" value="{{ $user->email }}">
                        </div>
                        <div class="flex items-center mb-2">
                            <i class="fas fa-phone-alt text-pink-600 mr-2"></i>
                            <span class="contact-label">{{ $user->contact_info }}</span>

                        </div>
{{--                        <div class="flex items-center">--}}
{{--                            <i class="fas fa-globe text-pink-600 mr-2"></i>--}}
{{--                            <span class="industry-label">{{ $user->industry_category }}</span>--}}
{{--                            <input type="text" class="hidden input-field bg-gray-100 rounded px-4 py-2 ml-2 w-2/3"--}}
{{--                                   name="industry_category" value="{{ $user->industry_category }}">--}}
{{--                        </div>--}}
                    </div>

                    <!-- Add Location Field -->
                    @if($user->location)
                    <div class="flex items-center mb-2">
                        <i class="fas fa-map-marker-alt text-pink-600 mr-2"></i>
                        <span class="location-label">{{ $user->location }}</span>
                    </div>
                    @endif
                    <!-- Add Services Offered -->
                  @if($user->serviceList)
                        <div class="flex items-center mb-2">
                            <i class="fas fa-tools text-pink-600 mr-2"></i>
                            <div class="flex flex-wrap">
                                @php
                                    $colors = ['bg-pink-200', 'bg-blue-200', 'bg-green-200', 'bg-yellow-200'];
                                @endphp
                                @foreach(json_decode($user->serviceList) as $key => $service)
                                    <span class="inline-block {{ $colors[$key % count($colors)] }} text-pink-800 text-xs font-medium py-1 px-2 rounded-full mb-1 mr-1">{{ $service }}</span>
                                @endforeach
                            </div>

                        </div>
                    @endif

                    <div id="social_media_links" class="flex items-center justify-end">
                        @if($user->social_media)
                            @php
                                $socialMedia = json_decode($user->social_media, true);
                            @endphp
                            @foreach ($socialMedia as $platform)
                                @php
                                    $platformLink = $user->{$platform . '_links'};
                                    $iconColor = '';
                                    switch ($platform) {
                                        case 'Facebook':
                                            $iconColor = 'text-blue-600';
                                            break;
                                        case 'Instagram':
                                            $iconColor = 'text-pink-600';
                                            break;
                                        case 'Twitter':
                                            $iconColor = 'text-blue-400';
                                            break;
                                        // Add more cases for additional social media platforms if needed
                                        default:
                                            $iconColor = 'text-gray-600';
                                            break;
                                    }
                                @endphp
                                @if ($platformLink)
                                    <div class="flex items-center mb-2">
                                        <a href="{{ $platformLink }}" target="_blank" rel="noopener noreferrer">
                                            <i class="fab fa-{{ strtolower($platform) }} {{ $iconColor }} mr-2"></i>
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>

                </div>
            </div>

        <div class="flex justify-end mb-2 mr-2">
            @auth
                @if (($user->account_type === 'Client' && auth()->user()->account_type === 'Business') || ($user->account_type === 'Business' && auth()->user()->account_type === 'Client') )
                    @if ($user->sentConnectionRequests->contains(auth()->user()))
                        <!-- Request received -->
                        <form method="POST" action="/connections/{{$user->id}}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white px-4 py-2 rounded-full mt-2">
                                Accept Request
                            </button>
                        </form>
                    @elseif ($user->receivedConnectionRequests->contains(auth()->user()))
                        <!-- Request sent -->
                        <button class="bg-gray-500 text-white px-4 py-2 rounded-full mt-2">
                            Request Sent
                        </button>

                    @elseif ($user->connectedUsers->contains(auth()->user()) )
                        <!-- Connected -->
{{--                        @php--}}
{{--                            $clientId = auth()->id(); // Retrieve the client ID--}}
{{--                            $connectedUser = $user->connectedUsers->firstWhere('id', $clientId);--}}
{{--                        @endphp--}}

                        <a href="/listings/create/{{auth()->id()}}/{{$user->id}}" class="ml-4 inline-block">
                            <i class="fas fa-calendar-plus text-green-500 text-2xl"></i>
                        </a>
                    @else
                        <!-- No connection -->
                        <form method="POST" action="/connections">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            <button type="submit" >
                                <i class="fas fa-user-plus text-pink-500 text-2xl"></i>
                            </button>
                        </form>

                    @endif
                @endif

            @endauth




        </div>

    </div>
</div>





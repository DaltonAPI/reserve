<style>
    .business span, p{
        color: white;
    }
</style>

    <div class="flex flex-col ">
        <div class="bg-black rounded-lg shadow-md relative mb-3 border border-white">


            @auth
                @if (auth()->user()->id === $user->id)
                    <div class="flex ">
                        @if (!isset($id))
                            <a href="/services" class="edit-icon absolute top-0 right-12 m-2 text-teal-600 hover:text-pink-700">
                                <i class="fas fa-tools"></i>
                            </a>
                        @endif
                        <a href="/edit/user" class="edit-icon absolute top-0 right-6 m-2 text-teal-600 hover:text-pink-300">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form id="profileForm{{$user->id}}" method="POST" action="{{ route('profile.destroy', $user->id) }}" onsubmit="return confirm('Are you sure you want to delete this account?')">
                            @csrf
                            @method('DELETE')
                            <!-- Rest of the form code -->
                            <button type="submit" ><a class="save-icon  absolute top-0 right-0 m-2 text-teal-600 hover:text-pink-300">
                                    <button><i class="fas fa-trash"></i></button>
                                </a></button>
                        </form>
                    </div>
                @endif
            @endauth

            @csrf
            @method('PUT')

            <div class="flex flex-col md:flex-row business">
                <div class="ml-5 flex items-center justify-center">
                    <div class="overflow-hidden w-16 h-16 md:w-56 md:h-56 rounded-lg border border-gray-300 mt-5">
                        @if ($user->photos)
                            <img src="{{ asset('storage/' . $user->photos) }}" alt="User Photo" class="h-full w-full">
                        @else
                            <img src="/images/business.png" alt="Default User Photo" class="h-full w-full">
                        @endif
                    </div>

                </div>
                <div class="p-6 md:w-2/3 mt-4">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-user text-teal-600 mr-2"></i>
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
                                <i class="fas fa-info-circle text-teal-600 mr-2"></i>
                                <span class="bio-label">{{ $user->bio }}</span>
                            </p>
                        @endif

                    </div>

                    <div class="contact-info">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-envelope text-teal-600 mr-2"></i>
                            <span class="email-label">{{ $user->email }}</span>
                        </div>
                        <div class="flex items-center mb-2">
                            <i class="fas fa-phone-alt text-teal-600 mr-2"></i>
                            <span class="contact-label">{{ $user->contact_info }}</span>

                        </div>

                    </div>

                    <!-- Add Location Field -->
                    @if($user->location)
                        <div class="flex items-center mb-2">
                            <i class="fas fa-map-marker-alt text-teal-600 mr-2"></i>
                            <span class="location-label">{{ $user->location }}</span>
                        </div>
                    @endif

                    <!-- Add Services Offered -->
                    @if($user->services)
                        <div class="flex items-center ">
                            <div class="flex flex-wrap">
                                @php
                                    $decodedServices = json_decode($user->services);
                                @endphp
                                @if($decodedServices)
                                    <i class="fas fa-tools text-teal-600 mr-2"></i>
                                @endif
                                @php
                                    $counter = 0;
                                @endphp
                                @foreach($decodedServices as $key => $service)
                                    @if($counter < 4 && is_object($service))
                                        <a href="/" class="inline-block bg-black border-white border text-white text-xs font-medium py-1 px-2 rounded-full mb-1 mr-1">{{ $service->name }} ( {{ $service->duration }}) - ${{ $service->price }}</a>
                                        @php
                                            $counter++;
                                        @endphp
                                    @endif
                                @endforeach
                                @if(count($decodedServices) > 4)
                                    <a href="" class="inline-block bg-white border-black border text-black text-xs font-medium py-1 px-2 rounded-full mb-1 mr-1 hover:bg-gray-200">All Services</a>
                                @endif
                            </div>
                        </div>
                    @endif

                    <div class="flex items-center mb-2">
                        <i class="fa fa-calendar text-teal-500"></i>
                        <a href="https://reservify.in/calendar/{{ $user->id }}" class="text-xs text-pink-500 hover:text-pink-700 ml-2">
                            https://reservify.in/calendar/{{$user->id}}
                        </a>
                    </div>




                    <!-- Container for QR Code and Download Icon -->
                    <div id="qrCodeContainer">
                        <!-- QR Code for a specific user -->
                        <div class="qr-container" style="display: flex; align-items: center;">
                            <!-- QR Code image with Google Charts API (chs parameter adjusted to half size) -->
                            <img class="qrCodeImage" src="https://chart.googleapis.com/chart?chs=50x50&cht=qr&chl=https://reservify.in/calendar/{{ $user->id }}" alt="QR Code">

                            <!-- Download Icon (Font Awesome) -->
                            <a class="downloadLink ml-2" href="#" data-user-id="{{ $user->id }}" onclick="downloadQRCode(event)">
                                <i class="fas fa-download" style="font-size: 20px; color: white; cursor: pointer; margin-left: 5px;"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Include JavaScript to handle download -->
                    <script>
                        function downloadQRCode(event) {
                            event.preventDefault();

                            // Get the user ID from the data attribute
                            var userId = event.currentTarget.getAttribute('data-user-id');

                            // Construct the QR Code image source based on the user ID
                            var qrCodeSrc = 'https://chart.googleapis.com/chart?chs=50x50&cht=qr&chl=https://reservify.in/calendar/' + userId;

                            // Fetch the image data
                            fetch(qrCodeSrc)
                                .then(response => response.blob())
                                .then(blob => {
                                    // Create a temporary anchor element
                                    var tempLink = document.createElement('a');
                                    tempLink.href = URL.createObjectURL(blob);
                                    tempLink.download = 'qrcode.png';

                                    // Trigger a click event on the temporary link
                                    document.body.appendChild(tempLink);
                                    tempLink.click();
                                    document.body.removeChild(tempLink);
                                })
                                .catch(error => {
                                    console.error('Error fetching QR code:', error);
                                });
                        }
                    </script>



















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
                                        case 'TikTok':
                                            $iconColor = 'text-white';
                                            break;
                                        case 'YouTube':
                                            $iconColor = 'text-red-600';
                                            break;

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

                        @elseif ($user->connectedUsers->contains(auth()->user())  || auth()->user()->connectedUsers->contains($user) )


                            <a href="/calendar/{{auth()->id()}}/{{$user->id}}" class="ml-4 inline-block">
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






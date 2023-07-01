
<div class="flex flex-col ">
    <div class="bg-white rounded-lg shadow-md relative mb-3">

        <form id="profileForm{{$user->id}}" method="POST" action="/profile/{{$user->id}}">
            @auth
                @if (auth()->user()->id === $user->id)
                    <div class="flex ">

                        <a class="edit-icon absolute top-0 right-0 m-2 text-pink-600 hover:text-pink-700">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a class="save-icon hidden absolute top-0 right-0 m-2 text-pink-600 hover:text-pink-700">
                            <button><i class="fas fa-save"></i></button>
                        </a>
                    </div>
                @endif
            @endauth

            @csrf
            @method('PUT')

            <div class="flex flex-col md:flex-row">
                <div class="md:w-1/3 flex items-center justify-center">
                    <div class=" overflow-hidden w-28 h-28 md:w-56 md:h-56 rounded-lg border border-gray-300">
                        <img src="{{ asset('storage/' . $user->photos) }}" alt="User Photo"  class="">
                    </div>
                </div>
                <div class="p-6 md:w-2/3 mt-8">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-envelope text-pink-600 mr-2"></i>
                        <h5 class="text-2xl font-bold text-gray-900">
                            <span class="name-label">{{ $user->name }}</span>
                        </h5>
                        <input type="text" class="hidden input-field bg-gray-100 rounded px-4 py-2 ml-2 w-2/3"
                               name="name" value="{{ $user->name }}">
                    </div>

                    <div class="flex items-center mb-2">
                        @if($user->bio)
                        <p class="text-gray-700">
                            <i class="fas fa-info-circle text-pink-600 mr-2"></i>
                            <span class="bio-label">{{ $user->bio }}</span>
                        </p>
                        @endif
                        <textarea class="hidden input-field bg-gray-100 rounded px-4 py-2 ml-2 w-2/3"
                                  name="bio">{{ $user->bio }}</textarea>
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
                            <input type="text" class="hidden input-field bg-gray-100 rounded px-4 py-2 ml-2 w-2/3"
                                   name="contact_info" value="{{ $user->contact_info }}">
                        </div>
{{--                        <div class="flex items-center">--}}
{{--                            <i class="fas fa-globe text-pink-600 mr-2"></i>--}}
{{--                            <span class="industry-label">{{ $user->industry_category }}</span>--}}
{{--                            <input type="text" class="hidden input-field bg-gray-100 rounded px-4 py-2 ml-2 w-2/3"--}}
{{--                                   name="industry_category" value="{{ $user->industry_category }}">--}}
{{--                        </div>--}}
                    </div>

                    <!-- Add Location Field -->
                    <div class="flex items-center mb-2">
                        <i class="fas fa-map-marker-alt text-pink-600 mr-2"></i>
                        <span class="location-label">{{ $user->location }}</span>
                        <input type="text" class="hidden input-field bg-gray-100 rounded px-4 py-2 ml-2 w-2/3"
                               name="location" value="{{ $user->location }}">
                    </div>

                    <!-- Add Services Offered -->
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
                        <input type="hidden" name="servicesOffer" value="{{ $user->serviceList }}">
                    </div>



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
        </form>
        <div class="flex justify-end mb-2 mr-2">
            <a href="/listings/create"
               class="ml-4 inline-block px-4 py-2 leading-none text-white bg-gradient-to-r from-pink-300 to-pink-600 rounded hover:bg-blue-700">Make Reservation</a>
{{--            <form id="profileForm{{$user->id}}" method="POST" action="{{ route('profile.destroy', $user->id) }}">--}}
{{--                @csrf--}}
{{--                @method('DELETE')--}}
{{--                <!-- Rest of the form code -->--}}
{{--                <div class="flex justify-end mt-6">--}}
{{--                    @auth--}}
{{--                        @if (auth()->user()->id === $user->id)--}}

{{--                            <button type="submit" class="ml-4 inline-block px-4 py-2 leading-none text-white bg-gradient-to-r from-red-300 to-red-600 rounded hover:bg-red-700">Remove Account</button>--}}
{{--                           --}}
{{--                        @endif--}}
{{--                    @endauth--}}
{{--                </div>--}}
{{--            </form>--}}

        </div>

    </div>
</div>



<script>
    function confirmDelete(form) {
        if (confirm('Are you sure you want to delete this user?')) {
            // Change the form's method to DELETE and submit it
            var methodInput = document.createElement('input');
            methodInput.setAttribute('type', 'hidden');
            methodInput.setAttribute('name', '_method');
            methodInput.setAttribute('value', 'DELETE');

            form.appendChild(methodInput);
            form.submit();
        }
    }






    var editIcons = document.querySelectorAll('.edit-icon');
    var saveIcons = document.querySelectorAll('.save-icon');

    editIcons.forEach(function (editIcon) {
        editIcon.addEventListener('click', function () {
            var card = editIcon.closest('.bg-white');
            var nameLabel = card.querySelector('.name-label');
            var nameInput = card.querySelector('input[name="name"]');
            var bioLabel = card.querySelector('.bio-label');
            var bioInput = card.querySelector('textarea[name="bio"]');
            var emailLabel = card.querySelector('.email-label');
            var emailInput = card.querySelector('input[name="email"]');
            var contactLabel = card.querySelector('.contact-label');
            var contactInput = card.querySelector('input[name="contact_info"]');
            var industryLabel = card.querySelector('.industry-label');
            var industryInput = card.querySelector('input[name="industry_category"]');

            nameLabel.classList.add('hidden');
            nameInput.classList.remove('hidden');
            bioLabel.classList.add('hidden');
            bioInput.classList.remove('hidden');
            emailLabel.classList.add('hidden');
            emailInput.classList.remove('hidden');
            contactLabel.classList.add('hidden');
            contactInput.classList.remove('hidden');
            industryLabel.classList.add('hidden');
            industryInput.classList.remove('hidden');

            editIcon.classList.add('hidden');
            var saveIcon = card.querySelector('.save-icon');
            saveIcon.classList.remove('hidden');
        });
    });

    saveIcons.forEach(function (saveIcon) {
        saveIcon.addEventListener('click', function () {
            var card = saveIcon.closest('.bg-white');
            var form = card.querySelector('form');
            form.submit();
        });
    });
</script>

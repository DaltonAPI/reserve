<x-layout>
    <x-card class="p-10 max-w-lg mx-auto mt-24">
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-1">Create a Reservation</h2>
            <p class="mb-4">Reserve a seat for your clients</p>
        </header>

        <form method="POST" action="/listings" enctype="multipart/form-data">
            @csrf
            <div class="mb-6">
                <label for="title" class="inline-block text-lg mb-2">The Type of Service</label>
                <input type="text" class="border border-gray-200 rounded p-2 w-full" name="title"
                       placeholder="Example: HairCut" value="{{old('title')}}" />

                @error('title')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="customer_name" class="inline-block text-lg mb-2">
                    Customer Name
                </label>
                <input type="text" class="border border-gray-200 rounded p-2 w-full" name="customer_name" value="{{old('customer_name')}}" />

                @error('customer_name')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="email" class="inline-block text-lg mb-2">
                    Customer Email
                </label>
                <input type="text" class="border border-gray-200 rounded p-2 w-full" name="email" value="{{old('email')}}" />

                @error('email')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="customer_phone" class="inline-block text-lg mb-2">
                    Customer Phone
                </label>
                <input type="text" class="border border-gray-200 rounded p-2 w-full" name="customer_phone" value="{{old('customer_phone')}}" />

                @error('customer_phone')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>


            <div class="mb-6">
                <label for="time" class="inline-block text-lg mb-2">Time</label>
                <input type="time" class="border border-gray-200 rounded p-2 w-full" name="time" value="{{ old('time') }}" />

                @error('time')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>


            <div class="mb-6">
                <label for="date" class="inline-block text-lg mb-2">
                    Date
                </label>
                <input type="date" class="border border-gray-200 rounded p-2 w-full" name="date" value="{{old('date')}}" />

                @error('date')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="logo" class="inline-block text-lg mb-2">
                  Service Expectation(optional)
                </label>
                <input type="file" class="border border-gray-200 rounded p-2 w-full" name="logo" />

                @error('logo')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="description" class="inline-block text-lg mb-2">
                    Additional Details
                </label>
                <textarea class="border border-gray-200 rounded p-2 w-full" name="description" rows="10"
                          placeholder="Include tasks, requirements, salary, etc">{{old('description')}}</textarea>

                @error('description')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="tags" class="inline-block text-lg mb-2">
                    Tags (Comma Separated)
                </label>
                <input type="text" class="border border-gray-200 rounded p-2 w-full" name="tags"
                       placeholder="Example: salon, hair, rebuild, etc" value="{{old('tags')}}" />

                @error('tags')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="status" class="inline-block text-lg mb-2">Status</label>
                <select name="status" class="border border-gray-200 rounded p-2 w-full">
                    <option value="pending" @if(old('status') === 'rescheduled') selected @endif>rescheduled</option>
                    <option value="confirmed" @if(old('status') === 'confirmed') selected @endif>Confirmed</option>
                    <option value="cancelled" @if(old('status') === 'cancelled') selected @endif>Cancelled</option>
                </select>

                @error('status')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-6">
                <button class="text-white rounded py-2 px-4 hover:bg-black bg-blue-500">
                    Reserve
                </button>
                <a href="/" class="text-black ml-4"> Back </a>
            </div>
        </form>
    </x-card>
</x-layout>

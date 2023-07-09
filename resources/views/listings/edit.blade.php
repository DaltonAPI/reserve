
<x-sidbar :filteredUsers="$filteredUsers"/>
<x-layout :filteredUsers="$filteredUsers">
    <x-card class="p-10 max-w-lg mx-auto mt-24">
        <header class="text-center">
            <h2 class="text-2xl font-bold uppercase mb-1">Edit Reservation</h2>
            <p class="mb-4">Edit: {{$listing->title}}</p>
        </header>

        <form method="POST" action="/listings/{{$listing->id}}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="title" class="inline-block text-lg mb-2">Type of service</label>
                <input type="text" class="border border-gray-200 rounded p-2 w-full" name="title"
                       placeholder="Example: Senior Laravel Developer" value="{{$listing->title}}" />

                @error('title')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="tags" class="inline-block text-lg mb-2">Tags (Comma Separated)</label>
                <input type="text" class="border border-gray-200 rounded p-2 w-full" name="tags"
                       placeholder="Example: Repair, Haircare, Painter, etc" value="{{$listing->tags}}" />

                @error('tags')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="email" class="inline-block text-lg mb-2">Contact Email</label>
                <input type="text" class="border border-gray-200 rounded p-2 w-full" name="email"
                       value="{{$listing->email}}" />

                @error('email')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="time" class="inline-block text-lg mb-2">Time</label>
                <input type="time" class="border border-gray-200 rounded p-2 w-full" name="time"
                       value="{{ old('time', $listing->time) }}" />

                @error('time')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="date" class="inline-block text-lg mb-2">Date</label>
                <input type="date" class="border border-gray-200 rounded p-2 w-full" name="date"
                       value="{{ old('date', $listing->date ? date('Y-m-d', strtotime($listing->date)) : '') }}" />

                @error('date')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>


            <div class="mb-6">
                <label for="customer_name" class="inline-block text-lg mb-2">Customer Name</label>
                <input type="text" class="border border-gray-200 rounded p-2 w-full" name="customer_name"
                       value="{{$listing->customer_name}}" />

                @error('customer_name')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="customer_phone" class="inline-block text-lg mb-2">Customer Phone</label>
                <input type="text" class="border border-gray-200 rounded p-2 w-full" name="customer_phone"
                       value="{{$listing->customer_phone}}" />

                @error('customer_phone')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>
            <div class="mb-6">
                <label for="logo" class="inline-block text-lg mb-2">Company Logo</label>
                <input type="file" class="border border-gray-200 rounded p-2 w-full" name="logo" />

               <div class="mt-4">
                   @if ($listing->logo)
                       <img class="w-48 " src="{{ asset('storage/' . $listing->logo) }}" alt="Company Logo" />
                   @endif

                   @error('logo')
                   <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                   @enderror
               </div>
            </div>

            <div class="mb-6">
                <label for="description" class="inline-block text-lg mb-2">Job Description</label>
                <textarea class="border border-gray-200 rounded p-2 w-full" name="description" rows="10"
                          placeholder="Include tasks, requirements, salary, etc">{{$listing->description}}</textarea>

                @error('description')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="status" class="inline-block text-lg mb-2">Status</label>
                <select name="status" class="border border-gray-200 rounded p-2 w-full">
                    <option value="rescheduled" {{ (old('status', $listing->status) === 'rescheduled') ? 'selected' : '' }}>rescheduled</option>
                    <option value="confirmed" {{ (old('status', $listing->status) === 'confirmed') ? 'selected' : '' }}>Confirmed</option>
                    <option value="cancelled" {{ (old('status', $listing->status) === 'cancelled') ? 'selected' : '' }}>Cancelled</option>
                </select>

                @error('status')
                <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                @enderror
            </div>


            <div class="mb-6">
                <button class="text-white rounded py-2 px-4 hover:bg-black bg-pink-500">Update Reservation</button>
                <a href="/" class="text-black ml-4">Back</a>
            </div>
        </form>
    </x-card>
</x-layout>

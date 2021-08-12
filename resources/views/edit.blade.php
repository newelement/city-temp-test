<x-app-layout>
<div class="px-12 max-w-6xl mx-auto">
    <div class="pt-4 pb-4">

        <h2 class="text-4xl my-4">Update</h2>

        <form action="/locations/{{ $location->id }}" method="post">
        @csrf
        @method('put')
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="country" class="w-full">Country</label>
                <select id="country" class="w-full" name="country" required>
                    <option value=""></option>
                    @foreach( countries() as $code => $country )
                    <option value="{{$code}}" {{ $code === $location->country ? 'selected="selected"' : '' }}>{{$country}}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="city" class="w-full">City</label>
                <input type="text" id="city" class="w-full" name="city" value="{{ $location->city }}" required>
            </div>
            <div>
                <label for="date" class="w-full">Date</label>
                <input type="date" id="date" class="w-full" name="temperature_date" value="{{ $location->temperature_date->format('Y-m-d') }}" required>
            </div>
            <div>
                <label for="temperature">Temperature</label>
                <input type="number" id="temperature" class="w-full" name="temperature" value="{{ $location->temperature }}" required>
            </div>
            <div>
                <label for="temperature-scale" class="w-full">Temperature Scale</label>
                <select id="temperature-scale" class="w-full" name="temperature_scale" required>
                    <option value="F" {{ $location->temperature_scale === 'F' ? 'selected="selected"' : '' }}>F</option>
                    <option value="C" {{ $location->temperature_scale === 'C' ? 'selected="selected"' : '' }}>C</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update</button>
            </div>
        </div>

        </form>
    </div>
</div>
</x-app-layout>




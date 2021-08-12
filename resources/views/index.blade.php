<x-app-layout>
<div class="px-12 max-w-6xl mx-auto">
    <div class="pt-4 pb-4">
        <form action="{{ route('locations.store') }}" method="post">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="country" class="w-full">Country</label>
                <select id="country" class="w-full" name="country" required>
                    <option value=""></option>
                    @foreach( countries() as $code => $country )
                    <option value="{{$code}}">{{$country}}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="city" class="w-full">City</label>
                <input type="text" id="city" class="w-full" name="city" required>
            </div>
            <div>
                <label for="date" class="w-full">Date</label>
                <input type="date" id="date" class="w-full" name="temperature_date" required>
            </div>
            <div>
                <label for="temperature">Temperature</label>
                <input type="number" id="temperature" class="w-full" name="temperature" required>
            </div>
            <div>
                <label for="temperature-scale" class="w-full">Temperature Scale</label>
                <select id="temperature-scale" class="w-full" name="temperature_scale" required>
                    <option value="F">F</option>
                    <option value="C">C</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Add</button>
            </div>
        </div>

        </form>
    </div>

    <div class="pt-4 pb-4">
        <table class="table-auto w-full ">
            <thead>
                <th class="px-4 py-2">Country</th>
                <th class="px-4 py-2">City</th>
                <th class="px-4 py-2">Date</th>
                <th class="px-4 py-2" width="100">Temp (F)</th>
                <th class="px-4 py-2" width="100">Temp (C)</th>
                <th class="px-4 py-2" width="140">Actions</th>
            </thead>
            <tbody>
                @foreach( $locations as $location )
                <tr>
                    <td class="border px-4 py-2">{{ getCountry($location->country) }}</td>
                    <td class="border px-4 py-2">{{ $location->city }}</td>
                    <td class="border px-4 py-2 text-center">{{ $location->temperature_date->format('m-d-Y') }}</td>
                    <td class="border px-4 py-2 text-right">{{ $location->temperature_far }}&#8457;</td>
                    <td class="border px-4 py-2 text-right">{{ $location->temperature_cel }}&#8451;</td>
                    <td class="text-center border px-4 py-2">
                        <a href="/locations/{{$location->id}}">Edit</a>
                        <form class="ml-4 inline-block" action="/locations/{{ $location->id }}" method="post">
                        @method('delete')
                        @csrf
                        <button type="submit" class="ml-3">X</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @if( $locations->count() === 0 )
        <h3 class="text-2xl my-4">No locations found. Please enter one above.</h3>
        @endif

        {{ $locations->links() }}
    </div>
</div>
</x-app-layout>




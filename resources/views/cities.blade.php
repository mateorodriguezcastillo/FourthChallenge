@props(['city'])

<x-layout>
    <section class="px-6 py-8">
        <main class="max-w mx-auto mt-10 bg-gray-100 border border-gray-200 p-6 rounded-xl">
            <h1 class="text-center font-bold text-xl mb-2">All Cities</h1>

            <table class="w-full">
                <thead class="bg-gray-50 border-b-2 border-gray-200">
                  <tr>
                    <th class="mr-4">@sortablelink('id')</th>
                    <th class="mr-4">@sortablelink('name')</th>
                    <th class="mr-4">Arriving</th>
                    <th class="mr-4">Departing</th>
                    <th class="mr-4"></th>
                  </tr>
                </thead>
                <tbody class="text-center">
                    @foreach ($cities as $city)
                        <tr>
                            <td>{{ $city->id }}</td>
                            <td>{{ $city->name }}</td>
                            <td>12</td>
                            <td>24</td>
                            <td>
                                <a href="/cities/{{ $city->id }}" class="text-blue-500">Editar</a>
                                /
                                <a href="/cities/{{ $city->id }}/delete" class="text-red-500">Eliminar</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $cities->links() }}
            </div>
        </main>
    </section>
</x-layout>

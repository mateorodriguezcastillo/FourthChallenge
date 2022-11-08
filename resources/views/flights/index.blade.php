@extends('layouts.app')

@section('content')
<div id="flightsCrud">
    <div id="defaultModal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">

        <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-gray-900 rounded-lg border border-gray-200 text-white shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex justify-between items-start p-4 rounded-t border-b dark:border-gray-600">
                    <h3 class="text-xl font-semibold dark:text-white">
                        Manage Flight
                    </h3>
                    <button type="button" id="btnCloseModal" data-modal-toggle="defaultModal"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-toggle="defaultModal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    <form method="POST" id="formData">
                        @csrf
                        <div class="mb-4">
                            <select name="airline_id" id="airline_id" class="form-select block w-full mb-2 bg-gray-900 text-white border-2 border-white rounded-lg max-h-12 overflow-scroll" @change="onChangeAirline(airlineID)" v-model="airlineID">
                                <option value="0">Select Airline</option>
                                <option v-for="airline in airlines" :value="airline.id">@{{ airline.name }}</option>
                            </select>
                            <span class="text-red-500" id="airline_id_error"></span>
                            <select name="origin_id" id="origin_id" class="form-select block w-full mb-2 bg-gray-900 text-white border-2 border-white rounded-lg max-h-12 overflow-scroll" @change="onChangeOrigin(originID)" v-model="originID">
                                <option value="0">Select Origin</option>
                                <option v-for="city in airline.cities" :value="city.id">@{{ city.name }}</option>
                            </select>
                            <span class="text-red-500" id="origin_id_error"></span>
                            <select name="destination_id" id="destination_id" class="form-select block w-full mb-2 bg-gray-900 text-white border-2 border-white rounded-lg max-h-12 overflow-scroll">
                                <option value="0">Select Destination</option>
                                <option v-for="city in airline.cities" :value="city.id">@{{ city.name }}</option>
                            </select>
                            <span class="text-red-500" id="destination_id_error"></span>
                            {{-- Departure Date --}}
                            <div class="relative">
                                <label for="departure_date" class="text-sm font-medium text-gray-400">Departure Date</label>
                                <input type="date" name="departure_date" id="departure_date" class="form-input block w-full mt-1 bg-gray-900 text-white border-2 border-white rounded-lg">
                                <span class="text-red-500" id="departure_date_error"></span>
                            </div>
                            {{-- Arrival Date --}}
                            <div class="relative">
                                <label for="arrival_date" class="text-sm font-medium text-gray-400">Arrival Date</label>
                                <input type="date" name="arrival_date" id="arrival_date" class="form-input block w-full mt-1 bg-gray-900 text-white border-2 border-white rounded-lg">
                                <span class="text-red-500" id="arrival_date_error"></span>
                            </div>
                        </div>
                        <div>
                            <button id="btn-create" type="submit"
                                class="bg-blue-500 text-white px-4 py-3 rounded font-medium w-full">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<section class="max-w-5xl container mx-auto my-6">
    <div class="rounded overflow-hidden shadow-lg bg-gray-800 border-2 border-white">
        <div class="px-6 py-4">
            <div class="font-bold text-xl mb-2 text-center text-white">Flights</div>
            <div>
                <div class="mb-4 flex inline-flex">
                    <button id="btnCreateModal" data-action="{{ route('cities.store') }}"
                        class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        type="button"
                        @click="toggle">
                        Create Flight
                    </button>
                    <button id="btnOpenModal" data-modal-toggle="defaultModal" hidden></button>
                    <select id="selectCity" class="js-example-basic-single ml-4 bg-gray-800 text-white border-2 border-white rounded-lg max-h-12 overflow-scroll">
                    </select>
                </div>
                <div>
                    <table class="table-auto w-full text-white">
                        <thead class="border-b-2 border-white">
                            <tr>
                                <th class="px-4 py-2 text-sm font-semibold tracking-wide">ID Flight</th>
                                <th class="px-4 py-2 text-sm font-semibold tracking-wide">Airline</th>
                                <th class="px-4 py-2 text-sm font-semibold tracking-wide">Origin</th>
                                <th class="px-4 py-2 text-sm font-semibold tracking-wide">Destination</th>
                                <th class="px-4 py-2 text-sm font-semibold tracking-wide">Departure</th>
                                <th class="px-4 py-2 text-sm font-semibold tracking-wide">Arrival</th>
                                <th class="px-4 py-2 text-sm font-semibold tracking-wide">Action</th>
                            </tr>
                        </thead>
                        <tbody id="tbody" class="text-center items-center">
                            <tr v-for="flight in flights.data">
                                <td class="px-4 py-2 border-b border-white">@{{ flight.id }}</td>
                                <td class="px-4 py-2 border-b border-white">@{{ flight.airline.name }}</td>
                                <td class="px-4 py-2 border-b border-white">@{{ flight.origin.name }}</td>
                                <td class="px-4 py-2 border-b border-white">@{{ flight.destination.name }}</td>
                                <td class="px-4 py-2 border-b border-white">@{{ flight.departure }}</td>
                                <td class="px-4 py-2 border-b border-white">@{{ flight.arrival }}</td>
                                <td class="px-4 py-2 border-b border-white">
                                    <div class="flex inline-flex mb-1 mt-1">
                                        <button data-action="{{ route('cities.update', ':id') }}"
                                            class="block text-white bg-yellow-300 hover:bg-yellow-500 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium mr-1 rounded-md text-sm px-3 py-1 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                            @click="edit(flight)">
                                            Edit
                                        </button>
                                        <button
                                            class="block text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-md text-sm px-3 py-1 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                            @click="deleteFlight(flight)">
                                            Delete
                                        </button>
                                    </div>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div id="pagination" class="px-6 py-4 text-center">
            <div class="flex flex-col items-center">
                <!-- Help text -->
                <span class="text-sm text-gray-200 dark:text-gray-400">
                    Showing <span class="font-semibold text-white dark:text-white">@{{ flights.from }}</span> to <span class="font-semibold text-white dark:text-white">@{{ flights.to }}</span> of <span class="font-semibold text-white dark:text-white">@{{ flights.total }}</span> Entries
                </span>
                <nav aria-label="Page navigation example">
                    <ul class="inline-flex -space-x-px mt-3">
                        <li v-for="page in flights.links" class="page-item">
                            <button @click="changePage(page)" :disabled="page.active" :hidden="page.url ? false : true" :class="page.active ? activePageClass : defaultPageClass" :data-url="page.url">@{{page.label}}</button>
                        </li>
                    </ul>
                </nav>
            </div>
        {{-- <ul>
            <li v-for="flight in flights">
                @{{ flight.id }}
            </li>
        </ul> --}}
        </div>
    </div>
</section>
</div>
@endsection

@push('addon-script')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{ asset('/js/flightsCrud.js') }}"></script>
@endpush

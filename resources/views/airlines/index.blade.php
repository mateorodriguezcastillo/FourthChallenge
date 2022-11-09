@extends('layouts.app')

@section('content')
<div id="defaultModal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-gray-900 rounded-lg border border-gray-200 text-white shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex justify-between items-start p-4 rounded-t border-b dark:border-gray-600">
                    <h3 class="text-xl font-semibold dark:text-white">
                        Manage Airline
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
                            <label for="name" class="sr-only">Name</label>
                            <input type="text" name="name" id="nameInput" placeholder="Airline name"
                                class="bg-clip-text border-2 w-full p-4 rounded-lg mb-1" value="{{ old('name') }}">
                            <span id="errorName" class="text-red-500 mt-2"></span>
                            <label for="name" class="sr-only">Description</label>
                            <textarea name="description" id="descriptionInput" placeholder="Description"
                                class="bg-clip-text border-2 w-full h-36 p-4 rounded-lg mb-1" value="{{ old('description') }}"></textarea>
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

<section class="max-w-2xl container mx-auto my-6">
    <div class="rounded overflow-hidden shadow-lg bg-gray-800 border-2 border-white">
        <div class="px-6 py-4">
            <div class="font-bold text-xl mb-2 text-center text-white">Airlines</div>
            <div>
                <div class="mb-4 flex inline-flex">
                    <button id="btnCreateModal" data-action="{{ route('cities.store') }}"
                        class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        type="button">
                        Create Airline
                    </button>
                    <button id="btnOpenModal" data-modal-toggle="defaultModal" hidden></button>
                    <select id="selectCity" class="js-example-basic-single ml-4 bg-gray-800 text-white border-2 border-white rounded-lg max-h-12 overflow-scroll">
                    </select>
                </div>
                <div>
                    <table class="table-auto w-full text-white">
                        <thead class="border-b-2 border-white">
                            <tr>
                                <th class="px-4 py-2 text-sm font-semibold tracking-wide">ID</th>
                                <th class="px-4 py-2 text-sm font-semibold tracking-wide">Name</th>
                                <th class="px-4 py-2 text-sm font-semibold tracking-wide">Description</th>
                                <th class="px-4 py-2 text-sm font-semibold tracking-wide">No. of Flights</th>
                                <th class="px-4 py-2 text-sm font-semibold tracking-wide">Action</th>
                            </tr>
                        </thead>
                        <tbody id="tbody" class="text-center items-center">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div id="pagination" class="px-6 py-4 text-center">
            {{-- {{ $cities->links() }} --}}
        </div>
    </div>
</section>
@endsection
@push('addon-script')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{ asset('/js/airlinesCrud.js') }}"></script>
@endpush

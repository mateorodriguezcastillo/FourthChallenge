Vue.createApp({
    data() {
        return {
            flights: [],
            flight: {
                id: 0,
                airline_id: 0,
                origin_id: 0,
                destination_id: 0,
                departure_date: '',
                arrival_date: '',
            },
            airlines: [],
            airline: {
                id: 0,
                name: '',
                description: '',
                cities: [],
            },
            cities: [],
            currentPage: 'http://localhost/api/flights',
            defaultPageClass: 'page-link py-2 px-3 ml-0 leading-tight text-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white',
            activePageClass: 'page-link py-2 px-3 ml-0 leading-tight text-white border border-gray-300 bg-blue-500',
            errors: [],
            isEdit: false
        }
    },
    computed: {
        airlineCitiesWithoutOrigin() {
            return this.airline.cities.filter(city => city.id != this.flight.origin_id);
        },
        readyForSubmit() {
            return this.flight.airline_id > 0 && this.flight.origin_id > 0 && this.flight.destination_id > 0 && this.flight.departure_date != '' && this.flight.arrival_date != '' && this.flight.departure_date < this.flight.arrival_date;
        },
        datesAreInvalid() {
            return this.flight.arrival_date != '' && this.flight.arrival_date < this.flight.departure_date
        }
    },
    methods: {
        toggle() {
            btnOpenModal.click();
        },
        getFlights() {
            axios.get(this.currentPage)
                .then(response => {
                    this.flights = response.data;
                }
            );
        },
        createFlight() {
            axios.post('/api/flights', this.flight)
                .then(response => {
                    this.resetFields();
                    this.getFlights();
                    this.errors = [];
                    this.toggle();
                    this.actionCompletedSwal("created");
                }
            ).catch(error => {
                this.errors = error.response.data.errors;
            }
            );
        },
        editFlight(flight) {
            this.toggle();
            axios.get('/api/airlines/' + flight.airline_id)
                    .then(response => {
                        this.airline = response.data;
                    }
                );
            this.flight = flight;
            this.isEdit = true;
        },
        updateFlight() {
            axios.put('/api/flights/' + this.flight.id + '/update', this.flight)
                .then(response => {
                    this.getFlights();
                    this.resetFields();
                    this.actionCompletedSwal("updated");
                    this.toggle();
                    this.isEdit = false;
                    this.errors = [];
                }
            ).catch(error => {
                this.errors = error.response.data.errors;
            }
            );
        },
        deleteFlight(flight) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('/api/flights/' + flight.id + '/delete')
                        .then(response => {
                            this.getFlights();
                        }
                    );
                    this.actionCompletedSwal("deleted");
                }
            })
        },
        changePage(page) {
            this.currentPage = page.url;
            this.getFlights();
        },
        getAllAirlines() {
            axios.get('/api/airlines/all')
                .then(response => {
                    this.airlines = response.data;
                }
            );
        },
        getAllCities() {
            axios.get('/api/cities/all')
                .then(response => {
                    this.cities = response.data;
                }
            );
        },
        onChangeAirline(airline_id) {
            if (airline_id != 0) {
                axios.get('/api/airlines/' + airline_id)
                    .then(response => {
                        this.airline = response.data;
                    }
                );
            } else {
                this.airline = {
                    id: 0,
                    name: '',
                    description: '',
                    cities: [],
                };
            }
            this.flight.airline_id = airline_id;
            this.flight.origin_id = 0;
            this.flight.destination_id = 0;
        },
        onChangeOrigin(origin_id) {
            this.flight.origin_id = origin_id;
            this.flight.destination_id = 0;
        },
        resetFields() {
            this.flight.airline_id = 0;
            this.flight.origin_id = 0;
            this.flight.destination_id = 0;
            this.flight.departure_date ='';
            this.flight.arrival_date ='';
        },
        actionCompletedSwal(action) {
            Swal.fire({
                title: 'Success!',
                text: 'Flight ' + action + ' successfully',
                icon: 'success',
                confirmButtonText: 'Ok'
            });
        }


    },
    mounted() {
        this.getFlights();
        this.getAllAirlines();
        //this.getAllCities();
    }
}).mount('#flightsCrud');


// Vue.createApp({
//     data() {
//         return {
//             active: false,
//         };
//     },
//     methods: {
//         toggle(){
//             alert('Hello!');
//             this.active = !this.active;
//         }
//     }
// }).mount('#flightsCrud');

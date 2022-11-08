Vue.createApp({
    data() {
        return {
            flights: [],
            flight: {
                id: 0,
                name: '',
                departure: '',
                arrival: '',
                price: 0,
                seats: 0,
                available: 0,
                created_at: '',
                updated_at: ''
            },
            airlines: [],
            airline: {
                id: 0,
                name: '',
                description: ''
            },
            airlineID: 0,
            cities: [],
            originID: 0,
            destinationID: 0,
            currentPage: 1,
            defaultPageClass: 'page-link py-2 px-3 ml-0 leading-tight text-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white',
            activePageClass: 'page-link py-2 px-3 ml-0 leading-tight text-white border border-gray-300 bg-blue-500',
            errors: [],
            isEdit: false
        }
    },
    methods: {
        toggle() {
            btnOpenModal.click();
        },
        getFlights(url) {
            axios.get(url ? url : '/api/flights')
                .then(response => {
                    this.flights = response.data;
                    console.log(JSON.parse(JSON.stringify(this.flights)));
                }
            );
        },
        createFlight() {
            axios.post('/api/flights', this.flight)
                .then(response => {
                    this.getFlights();
                    this.flight = {
                        id: 0,
                        name: '',
                        departure: '',
                        arrival: '',
                        price: 0,
                        seats: 0,
                        available: 0,
                        created_at: '',
                        updated_at: ''
                    };
                    this.errors = [];
                }
            ).catch(error => {
                this.errors = error.response.data.errors;
            }
            );
        },
        editFlight(flight) {
            this.flight = flight;
            this.isEdit = true;
        },
        updateFlight() {
            axios.put('/api/flights/' + this.flight.id, this.flight)
                .then(response => {
                    this.getFlights();
                    this.flight = {
                        id: 0,
                        name: '',
                        departure: '',
                        arrival: '',
                        price: 0,
                        seats: 0,
                        available: 0,
                        created_at: '',
                        updated_at: ''
                    };
                    this.isEdit = false;
                    this.errors = [];
                }
            ).catch(error => {
                this.errors = error.response.data.errors;
            }
            );
        },
        deleteFlight(flight) {
            axios.delete('/api/flights/' + flight.id + '/delete')
                .then(response => {
                    this.getFlights();
                }
            );
        },
        changePage(page) {
            console.log("click")
            this.currentPage = page.url;
            this.getFlights(page.url);
        },
        getAllAirlines() {
            axios.get('/api/airlines/all')
                .then(response => {
                    this.airlines = response.data;
                    console.log(JSON.parse(JSON.stringify(this.airlines)));
                }
            );
        },
        getAllCities() {
            axios.get('/api/cities/all')
                .then(response => {
                    this.cities = response.data;
                    console.log(JSON.parse(JSON.stringify(this.cities)));
                }
            );
        },
        onChangeAirline(airline_id) {
            console.log(airline_id);
            if (airline_id != 0) {
                axios.get('/api/airlines/' + airline_id)
                    .then(response => {
                        this.airline = response.data;
                        console.log(JSON.parse(JSON.stringify(this.airline)));
                    }
                );
            } else {
                this.airline = {
                    id: 0,
                    name: '',
                    description: ''
                };
            }
            this.airlineID = airline_id;
        },
        onChangeOrigin(origin_id) {
            console.log(origin_id);
            this.originID = origin_id;
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

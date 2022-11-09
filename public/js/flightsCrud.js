Vue.createApp({
    data() {
        return {
            flights: [],
            airlines: [],
            airline: {
                id: 0,
                name: '',
                description: '',
                cities: [],
            },
            airlineID: 0,
            cities: [],
            flightID: 0,
            originID: 0,
            destinationID: 0,
            departureDate: '',
            arrivalDate: '',
            currentPage: 'http://localhost/api/flights',
            defaultPageClass: 'page-link py-2 px-3 ml-0 leading-tight text-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white',
            activePageClass: 'page-link py-2 px-3 ml-0 leading-tight text-white border border-gray-300 bg-blue-500',
            errors: [],
            isEdit: false
        }
    },
    computed: {
        airlineCitiesWithoutOrigin() {
            return this.airline.cities.filter(city => city.id != this.originID);
        },
        readyForSubmit() {
            return this.airlineID > 0 && this.originID > 0 && this.destinationID > 0 && this.departureDate != '' && this.arrivalDate != '' && this.departureDate < this.arrivalDate;
        },
        datesAreInvalid() {
            return this.arrivalDate != '' && this.arrivalDate < this.departureDate
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
                    console.log(JSON.parse(JSON.stringify(this.flights)));
                }
            );
        },
        createFlight() {
            axios.post('/api/flights', {
                airline_id: this.airlineID,
                origin_id: this.originID,
                destination_id: this.destinationID,
                departure_date: this.departureDate,
                arrival_date: this.arrivalDate
                })
                .then(response => {
                    this.resetFields();
                    this.getFlights();
                    this.errors = [];
                    console.log(response.data);
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
                        console.log(JSON.parse(JSON.stringify(this.airline)));
                    }
                );
            this.flightID = flight.id;
            this.airlineID = flight.airline_id;
            this.originID = flight.origin_id;
            this.destinationID = flight.destination_id;
            this.departureDate = flight.departure_date;
            this.arrivalDate = flight.arrival_date;
            this.isEdit = true;
        },
        updateFlight() {
            console.log('updateFlight');
            axios.put('/api/flights/' + this.flightID + '/update', {
                airline_id: this.airlineID,
                origin_id: this.originID,
                destination_id: this.destinationID,
                departure_date: this.departureDate,
                arrival_date: this.arrivalDate
            })
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
            console.log("click")
            this.currentPage = page.url;
            this.getFlights();
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
                    description: '',
                    cities: [],
                };
            }
            this.airlineID = airline_id;
            this.originID = 0;
            this.destinationID = 0;
        },
        onChangeOrigin(origin_id) {
            console.log(origin_id);
            this.originID = origin_id;
            this.destinationID = 0;
        },
        onChangeDepartureDate(departure_date) {
            console.log(departure_date);
            this.departureDate = departure_date;
        },
        resetFields() {
            this.airlineID = 0;
            this.originID = 0;
            this.destinationID = 0;
            this.departureDate ='';
            this.arrivalDate ='';
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

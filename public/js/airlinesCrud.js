const baseUrl = 'http://localhost/api/airlines';

const container = document.querySelector('tbody');
const pagination = document.querySelector('#pagination');
let results = '';
let page = 1;


const modal = document.getElementById("defaultModal");
const form = document.getElementById("formData");
const name = document.getElementById("nameInput");
const description = document.getElementById("descriptionInput");
let option = '';

btnCreateModal.addEventListener('click', () => {
    btnOpenModal.click();
    name.value = '';
    description.value = '';
    option = 'create';
});

//function to show all airlines
const showAirlines = (airlines) => {
    results = '';
    airlines.data.forEach(airline => {
        results += `
            <tr class="border-b border-gray-700">
                <td>${airline.id}</td>
                <td>${airline.name}</td>
                <td><div class="max-h-14 overflow-y-scroll">${airline.description}</div></td>
                <td>${airline.flights_count}</td>
                <td>
                        <div class="flex inline-flex">
                            <button id="editModal" class="block text-white bg-yellow-300 hover:bg-yellow-500 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium mr-1 rounded-md text-sm px-3 py-1 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button" data-modal-toggle="defaultModal"
                                data-action="` +
                                baseUrl +
                                `/airlines/` +
                                airline.id +
                                `/update" data-id="` +
                                airline.id +
                                `">
                                Edit
                            </button>
                            <button id="btn-delete" data-id="` + airline.id +`" class="block text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-md text-sm px-3 py-1 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                Delete
                            </button>
                        </div>
                </td>
            </tr>
        `;
    });
    htmlPagination = `<div class="flex flex-col items-center">
                        <!-- Help text -->
                        <span class="text-sm text-gray-200 dark:text-gray-400">
                            Showing <span class="font-semibold text-white dark:text-white">` + airlines.from + `</span> to <span class="font-semibold text-white dark:text-white">` + airlines.to + `</span> of <span class="font-semibold text-white dark:text-white">` + airlines.total + `</span> Entries
                        </span>
                            <nav aria-label="Page navigation example">
                                <ul class="inline-flex -space-x-px mt-3">`;
    for (let i = 1; i <= airlines.last_page; i++) {
        htmlPagination += `<li class="page-item">
                            <a class="page-link py-2 px-3 ml-0 leading-tight text-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white" href="` + baseUrl + `/?page=` + i + `" data-url="` + baseUrl + `/?page=` + i + `">` + i + `</a>
                        </li>`;
    }
    htmlPagination += `</ul>`
    htmlPagination += `</nav>`
    htmlPagination += `</div>`;

    //delete all rows
    container.innerHTML = '';
    //add new rows
    container.innerHTML = results;
    pagination.innerHTML = htmlPagination;
}

//prodedure to show all airlines
fetch(baseUrl)
    .then(res => res.json())
    .then(data => showAirlines(data))
    .catch(err => console.log(err));

//function to show all cities
const showCities = (cities) => {
    let results = '';
    if (cities.length < 1) {
        results += `<option value="">No cities found</option>`;
    } else {
        results += `<option value="">All Cities</option>`;
        cities.forEach(city => {
            results += `<option value="` + city.id + `">` + city.name + `</option>`;
        });
    }
    selectCity.innerHTML = results;
}

//procedure to show all cities
fetch('http://localhost/api/cities/all')
    .then(res => res.json())
    .then(data => showCities(data))
    .catch(err => console.log(err));




//function on simil jquery
const on = (element, event, selector, handler) => {
    element.addEventListener(event, e => {
        if (e.target.closest(selector)) {
            handler(e);
        }
    });
};

//function when select city
const selectCity = document.getElementById('selectCity');
selectCity.addEventListener('change', (e) => {
    const city = e.target.value;
    fetch(baseUrl + '/?city=' + city)
        .then(res => res.json())
        .then(data => showAirlines(data))
        .catch(err => console.log(err));
});

function getUrlVars(url)
{
    var vars = [], hash;
    var hashes = url.slice(url.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}

//procedure to change page
on(pagination, 'click', 'a', e => {
    e.preventDefault();
    let url = e.target.getAttribute('data-url');
    page = getUrlVars(url).page;
    fetch(e.target.dataset.url)
        .then(res => res.json())
        .then(data => {
            showAirlines(data);
        })
        .catch(err => console.log(err));
});

//procedure to delete airline
on (document, 'click', '#btn-delete', e => {
    const row = e.target.parentNode.parentNode.parentNode;
    const id = row.firstElementChild.textContent;
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this! ",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(baseUrl + '/' + id + "/delete" + "?page=" + page, {
                method: 'DELETE'
            })
            .then(res => res.json())
            .then(data => {
                showAirlines(data);
            })
            Swal.fire("Deleted!", "City deleted successfully.", "success");
        }
    });

});

//function to create airline
const createAirline = (data) => {
    fetch(baseUrl + '?page=' + page, {
        method: 'POST',
        body: JSON.stringify(data),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        showAirlines(data);
        btnCloseModal.click();
        Swal.fire("Created!", "Airline created successfully.", "success");
    })
    .catch(err => console.log(err));
}

//procedure to update airline
let idForm = 0;
let row = 0;
on (document, 'click', '#editModal', e => {
    row = e.target.parentNode.parentNode.parentNode;
    idForm = row.firstElementChild.textContent;
    const name = row.children[1].textContent;
    const description = row.children[2].firstElementChild.textContent;
    nameInput.value = name;
    descriptionInput.value = description;
    option = 'update';
    btnOpenModal.click();
});

const updateAirline = (data, id) => {
    fetch(baseUrl + '/' + id + '/update' + '?page=' + page, {
        method: 'PUT',
        body: JSON.stringify(data),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        showAirlines(data);
        btnCloseModal.click();
        Swal.fire("Updated!", "Airline updated successfully.", "success");
    })
    .catch(err => console.log(err));
}

//procedure to submit form
form.addEventListener('submit', e => {
    e.preventDefault();
    const data = {
        name: nameInput.value,
        description: descriptionInput.value
    }
    if (option === 'create') {
        createAirline(data);
    } else if (option === 'update') {
        updateAirline(data, idForm);
    }
});


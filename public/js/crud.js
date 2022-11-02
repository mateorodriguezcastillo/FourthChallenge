const baseUrl = "http://localhost";

showCities();

function table_city_row(res) {
    let htmlView = "";
    console.log(res);
    if (res.cities.length <= 0) {
        htmlView +=
            '<tr><td colspan="5" class="text-center">No cities found.</td></tr>';
    }

    res.cities.data.forEach((city) => {
        htmlView += "<tr>";
        htmlView += "<td>" + city.id + "</td>";
        htmlView += "<td>" + city.name + "</td>";
        htmlView += "<td>" + "12" + "</td>";
        htmlView += "<td>" + "24" + "</td>";
        htmlView +=
            `<td>
                        <div class="flex inline-flex">
                            <button id="editModal" class="block text-white bg-yellow-300 hover:bg-yellow-500 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium mr-1 rounded-md text-sm px-3 py-1 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button" data-modal-toggle="defaultModal"
                                data-action="` +
            baseUrl +
            `/cities/` +
            city.id +
            `/update" data-id="` +
            city.id +
            `">
                                Edit
                            </button>
                            <button id="btn-delete" data-id="` + city.id +`" class="block text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-md text-sm px-3 py-1 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                                Delete
                            </button>
                        </div>
                    </td>`;
        htmlView += "</tr>";
    });

    htmlPagination = `<div class="flex flex-col items-center">
                        <!-- Help text -->
                        <span class="text-sm text-gray-700 dark:text-gray-400">
                            Showing <span class="font-semibold text-gray-900 dark:text-white">` + res.cities.from + `</span> to <span class="font-semibold text-gray-900 dark:text-white">` + res.cities.to + `</span> of <span class="font-semibold text-gray-900 dark:text-white">` + res.cities.total + `</span> Entries
                        </span>
                            <nav aria-label="Page navigation example">
                                <ul class="inline-flex -space-x-px mt-3">`;
    if (res.cities.prev_page_url) {
        htmlPagination += `<li class="page-item">
                            <a class="page-link py-2 px-3 ml-0 leading-tight text-gray-500 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white" href="` + res.cities.prev_page_url + `" data-url="` + res.cities.prev_page_url + `" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>`;
    }
    for (let i = 1; i <= res.cities.last_page; i++) {
        htmlPagination += `<li class="page-item">
                            <a class="page-link py-2 px-3 ml-0 leading-tight text-gray-500 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white" href="` + res.cities.links[i].url + `" data-url="` + baseUrl + `/cities?page=` + i + `">` + i + `</a>
                        </li>`;
    }
    if (res.cities.next_page_url) {
        htmlPagination += `<li class="page-item">
                            <a class="page-link py-2 px-3 ml-0 leading-tight text-gray-500 bg-white rounded-l-lg border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"` + res.cities.next_page_url + `" data-url="` + res.cities.next_page_url + `" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Next</span>
                            </a>
                        </li>`;
    }
    htmlPagination += `</ul>`
    htmlPagination += `</nav>`
    htmlPagination += `</div>`;

    $('#pagination').html(htmlPagination);
    $("#tbody").html(htmlView);
}

// Read a page's GET URL variables and return them as an associative array.
function getUrlVars()
{
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}

function showCities() {
    let vars = getUrlVars();
    console.log(vars);
    let urlToPass = baseUrl + "/cities";
    if (vars.sort) {
        urlToPass += "?sort=" + vars.sort + "&direction=" + vars.direction;
    }
    if (vars.page) {
        urlToPass += "&page=" + vars.page;
    }
    console.log(urlToPass);
    $.ajax({
        url: urlToPass,
        type: "GET",
        dataType: "json",
        success: function (res) {
            console.log(res);
            table_city_row(res);
        },
        error: function (err) {
            console.log(err);
        },
    });
}

$("button#createModal").click(function () {
    let url = $(this).data("action");
    console.log(url);
    $("#openModal").click();
    $("#formData").trigger("reset");
    $("#formData").attr("action", url);
});

// Event for created and updated posts
$("#formData").submit(function (e) {
    e.preventDefault();
    let formData = new FormData(this);
    console.log($(this).attr("action"));
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    $.ajax({
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        url: $(this).attr("action"),
        success: function (res) {
            console.log(res);
            console.log(formData);
            if (res.success == true) {
                $("#formData").trigger("reset");
                $("#closeModal").click();
                showCities(); // call function show Posts
                Swal.fire("Success!", res.message, "success");
                $("#errorName").text("");
            }
        },
        error(err) {
            let errors = err.responseJSON.message;
            $("#name").addClass("border-red-500");
            $("#errorName").text(errors);
        },
    });
});

//open edit modal
$(document).on("click", "button#editModal", function () {
    let id = $(this).data("id");
    let dataAction = $(this).data("action");
    console.log(dataAction);
    $("#formData").trigger("reset");
    $("#formData").attr("action", dataAction);
    $.ajax({
        type: "GET",
        url: baseUrl + `/cities/${id}/edit`,
        dataType: "json",
        success: function (res) {
            console.log(res);
            $("#openModal").click();
            $("#nameInput").val(res.cities.name);
        },
    });
});

$(document).on("click", "button#btn-delete", function (e) {
    e.preventDefault();
    let dataDelete = $(this).data("id");
    // console.log(dataDelete);
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
            $.ajax({
                type: "DELETE",
                dataType: "JSON",
                url: baseUrl + `/cities/${dataDelete}/delete`,
                data: {
                    _token: $('meta[name="csrf-token"]').attr("content"),
                },
                success: function (response) {
                    Swal.fire(
                        "Deleted!",
                        "Your file has been deleted.",
                        "success"
                    );
                    showCities();
                },
                error: function (err) {
                    console.log(err);
                },
            });
        }
    });
});

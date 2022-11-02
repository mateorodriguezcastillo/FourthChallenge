const baseUrl = "http://localhost/cities";

showCities();

function table_city_row(res) {
    let htmlView = "";
    if (res.cities.length <= 0) {
        htmlView +=
            '<tr><td colspan="5" class="text-center">No cities found.</td></tr>';
    }

    res.cities.forEach((city) => {
        htmlView += "<tr>";
        htmlView += "<td>" + city.id + "</td>";
        htmlView += "<td>" + city.name + "</td>";
        htmlView += "<td>" + "12" + "</td>";
        htmlView += "<td>" + "24" + "</td>";
        htmlView +=
            '<td><a href="#" class="btn btn-danger btn-sm" onclick="deleteCity(' +
            city.id +
            ')">Delete</a></td>';
        htmlView += "</tr>";
    });
}

// Event for created and updated posts
$("#formData").submit(function (e) {
    e.preventDefault();
    let formData = new FormData(this);
    $.ajax({
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        url: $(this).attr("action"),
        beforeSend: function () {
            $("#btn-create")
                .addClass("disabled")
                .html("Processing...")
                .attr("disabled", true);
            $(document).find("span.error-text").text("");
        },
        complete: function () {
            $("#btn-create")
                .removeClass("disabled")
                .html("Save   Change")
                .attr("disabled", false);
        },
        success: function (res) {
            console.log(res);
            if (res.success == true) {
                $("#formData").trigger("reset");
                $("#exampleModal").modal("hide");
                showPosts(); // call function show Posts
                Swal.fire("Success!", res.message, "success");
            }
        },
        error(err) {
            $.each(err.responseJSON, function (prefix, val) {
                $("." + prefix + "_error").text(val[0]);
            });
            console.log(err);
        },
    });
});

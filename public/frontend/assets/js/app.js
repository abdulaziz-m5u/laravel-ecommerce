function getShippingCostOptions(city_id) {
    $.ajax({
        type: "POST",
        url: "/orders/shipping-cost",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"),
            city_id: city_id,
        },
        success: function (response) {
            $("#shipping-cost-option").empty();
            $("#shipping-cost-option").append(
                "<option value>- Please Select -</option>"
            );
            $("#test").val("Place order");

            $.each(response.results, function (key, result) {
                $("#shipping-cost-option").append(
                    '<option value="' +
                        result.service.replace(/\s/g, "") +
                        '">' +
                        result.service +
                        " | " +
                        result.cost +
                        " | " +
                        result.etd +
                        "</option>"
                );
            });
        },
    });
}

function getQuickView(product_slug) {
    $.ajax({
        type: "GET",
        url: "/products/quick_view/" + product_slug,
        success: function (response) {
            $("#exampleModal").html(response);
            $("#exampleModal").modal();
        },
    });
}

(function ($) {
    $("#province-id").on("change", function (e) {
        var province_id = e.target.value;
        $("#test").val("Loading...");

        $.get("/orders/cities?province_id=" + province_id, function (data) {
            $("#city-id").empty();
            $("#city-id").append("<option value>- Please Select -</option>");
            $("#test").val("Place order");
            $.each(data.cities, function (city_id, city) {
                $("#city-id").append(
                    '<option value="' + city_id + '">' + city + "</option>"
                );
            });
        });
    });

    $("#shipping-province").on("change", function (e) {
        var province_id = e.target.value;
        $("#test").val("Loading...");

        $.get("/orders/cities?province_id=" + province_id, function (data) {
            $("#shipping-city").empty();
            $("#shipping-city").append(
                "<option value>- Please Select -</option>"
            );
            $("#test").val("Place order");

            $.each(data.cities, function (city_id, city) {
                $("#shipping-city").append(
                    '<option value="' + city_id + '">' + city + "</option>"
                );
            });
        });
    });

    // ======= Show Shipping Cost Options =========
    if ($("#city-id").val()) {
        getShippingCostOptions($("#city-id").val());
    }

    $("#city-id").on("change", function (e) {
        var city_id = e.target.value;
        $("#test").val("Loading...");

        if (!$("#ship-box").is(":checked")) {
            getShippingCostOptions(city_id);
        }
    });

    $("#shipping-city").on("change", function (e) {
        var city_id = e.target.value;
        getShippingCostOptions(city_id);
    });

    // ============ Set Shipping Cost ================
    $("#shipping-cost-option").on("change", function (e) {
        var shipping_service = e.target.value;
        var city_id = $("#city-id").val();
        $("#test").val("Loading...");

        if ($("#ship-box").is(":checked")) {
            city_id = $("#shipping-city").val();
        }

        $.ajax({
            type: "POST",
            url: "/orders/set-shipping",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
                city_id: city_id,
                shipping_service: shipping_service,
            },
            success: function (response) {
                $("#test").val("Loading...");
                $(".total-amount").html(response.data.total);
                $("#test").val("Place order");
            },
        });
    });

    $(".quick-view").on("click", function (e) {
        e.preventDefault();

        var product_slug = $(this).attr("product-slug");

        getQuickView(product_slug);
    });

    $(".add-to-card").on("click", function (e) {
        e.preventDefault();

        var product_id = $(this).attr("product-id");

        $.ajax({
            type: "POST",
            url: "/cart",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
                product_id: product_id,
                qty: 1,
            },
            success: function (response) {
                swal("Success !");
                location.reload(true);
            },
        });
    });

    $(".add-to-fav").on("click", function (e) {
        e.preventDefault();

        var product_slug = $(this).attr("product-slug");

        $.ajax({
            type: "POST",
            url: "/favorite",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
                product_slug,
            },
            success: function (response) {
                swal(response);
            },
            error: function (xhr, textStatus, errorThrown) {
                if (xhr.status == 401) {
                    alert("login dulu !");
                }

                if (xhr.status == 422) {
                    alert(xhr.responseText);
                }
            },
        });
    });
})(jQuery);

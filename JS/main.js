$(document).ready(() => {

    // ALL PERSONNEL

    loadPage();

    // SEARCH SUBMIT

    $("#SearchForm").submit(event => {

        event.preventDefault();

        $("#searchInput").val("");

        $("html, body").animate({ scrollTop: 0 }, "fast");

        $("#wrapper").removeClass("toggled");

        const data = $("#SearchForm").serialize();

        $.post("./PHP/getPersonnelByOptions.php", data, function(res) {

            $("ul.pagination").html("");

            for (let index = 1; index <= res.metadata.pages; index++) {

                if (index == 1) {
    
                    const li = `<li class="page-item active"><a class="page-link" href="javascript:getRequestPersonnelByLocation('${data}', '${index}')">${index}</a></li>`;
                    $("ul.pagination").append(li);
                    continue;
    
                }
    
                 const li = `<li class="page-item"><a class="page-link" href="javascript:getRequestPersonnelByLocation('${data}', '${index}')">${index}</a></li>`;
                 $("ul.pagination").append(li);
    
            };

            renderCards(res);

        });
    });

    // CREATE NEW RECORD DATABASE

    $("#create-modal-form").submit(event => {

        event.preventDefault();

        const data = $("#create-modal-form").serialize();

        $.post("./PHP/createPersonnel.php", data, function(res) {

            if (res.status.code == 201) {

                $("#add-button").attr("disabled", "true");

                const alert = `
                <div class="alert alert-success" role="alert">
                    <h4 class="alert-heading"><i class="fas fa-check-circle"></i> <strong>Success!</strong></h4>
                    <p class="mb-0">Employee successfully added.</p>
                </div>`;

                $("#alert").html("");
                $("#alert").append(alert);

                const timer = setTimeout(() => {

                    $("#create").modal('hide');

                }, 2500);

                $("#create").on("hidden.bs.modal", function() {

                    loadPage();
                    
                    $("#alert").html("");
                    $('#create-modal-form').trigger("reset");
                    $("#add-button").removeAttr("disabled");

                    clearTimeout(timer);

                });

            } else if (res.status.code == 400) {

                const alert = `
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading"><i class="fas fa-exclamation-triangle"></i> <strong>Error!</strong></h4>
                    <p class="mb-0">Please make sure all fields are filled with a valid input and try again.</p>
                </div>`;

                $("#alert").html("");
                $("#alert").append(alert);

            };

        });

    });

    // UPDATE OR DELETE RECORD DATABASE

    $("div#modalDiv").on("click", "button:submit", function(event) {

        event.preventDefault();
        
        const data = $(this).closest("form").serialize();
        
        // GET THE CURRENT RECORD ID TO TARGET THE CORRESPONDING DIVs
        const id = $(this).closest("form").find("input[name=id]").val();

        if ($(this).attr("value") == "update") {

            $.post("./PHP/update.php", data, function(res) {

                if (res.status.code == 200) {

                    $("button:submit").attr("disabled", "true");

                    const alert = `
                    <div class="alert alert-success" role="alert">
                        <h4 class="alert-heading"><i class="fas fa-check-circle"></i> <strong>Success!</strong></h4>
                        <p class="mb-0">Employee successfully updated.</p>
                    </div>`;
    
                    $(`div#alert-${id}`).html("");
                    $(`div#alert-${id}`).append(alert);

                    const timer = setTimeout(() => {

                        $(`div#modal-${id}`).modal("hide");
                        
                    }, 2500);

                    $(`div#modal-${id}`).on("hidden.bs.modal", function() {

                        $(`div#alert-${id}`).html("");

                        $("button:submit").removeAttr("disabled");

                        clearTimeout(timer);

                        loadPage();

                    });
                    

                } else if (res.status.code == 400) {

                    const alert = `
                    <div class="alert alert-danger" role="alert">
                        <h4 class="alert-heading"><i class="fas fa-exclamation-triangle"></i> <strong>Error!</strong></h4>
                        <p class="mb-0">Please make sure all fields are filled with a valid input and try again.</p>
                    </div>`;
    
                    $(`div#alert-${id}`).html("");
                    $(`div#alert-${id}`).append(alert);
                    
                    $(`div#modal-${id}`).on("hidden.bs.modal", function() {

                        $(`div#alert-${id}`).html("");

                    });
    
                };

            });

        } else if ($(this).attr("value") == "delete") {

            const confirmAlert = `
                    <div class="alert alert-warning" role="alert">
                        <h4 class="alert-heading"><i class="fas fa-exclamation-triangle"></i></i> <strong>Warning!</strong></h4>
                        <p class="mb-3">Are you sure you want to delete this employee from the database?</p>
                        <span class="d-block mb-2"><small>Warning! This cannot be undone.</small></span>
                        <button type="button" class="btn btn-sm btn-primary" id="yes">Yes, Delete!</button>
                        <button type="button" class="btn btn-sm btn-secondary" id="no">No</button>
                    </div>`;

            $(`div#alert-${id}`).html("");
            $(`div#alert-${id}`).append(confirmAlert);

            $("button:submit").attr("disabled", "true");

            $("div#modalDiv").on("click", "button#no", function() {

                $(`div#alert-${id}`).html("");
                $("button:submit").removeAttr("disabled");

            });

            $("div#modalDiv").on("click", "button#yes", function() {

                $.post("./PHP/delete.php", data, function(res) {

                    if (res.status.code == 200) {
    
                        const alert = `
                        <div class="alert alert-success" role="alert">
                            <h4 class="alert-heading"><i class="fas fa-check-circle"></i> <strong>Success!</strong></h4>
                            <p class="mb-0">Employee successfully deleted.</p>
                        </div>`;
        
                        $(`div#alert-${id}`).html("");
                        $(`div#alert-${id}`).append(alert);
    
                        const timer = setTimeout(() => {
    
                            $(`div#modal-${id}`).modal("hide");
                            
                        }, 2500);
    
                        $(`div#modal-${id}`).on("hidden.bs.modal", function() {
    
                            $(`div#alert-${id}`).html("");

                            clearTimeout(timer);
    
                            loadPage();
    
                        });
                        
    
                    } else if (res.status.code == 400) {
    
                        const alert = `
                        <div class="alert alert-danger" role="alert">
                            <h4 class="alert-heading"><i class="fas fa-exclamation-triangle"></i> <strong>Error!</strong></h4>
                            <p class="mb-0">Error. Please try again.</p>
                        </div>`;
        
                        $(`div#alert-${id}`).html("");
                        $(`div#alert-${id}`).append(alert);
        
                    };
    
                });

            });

            $(`div#modal-${id}`).on("hidden.bs.modal", function() {
    
                $(`div#alert-${id}`).html("");

                $("button:submit").removeAttr("disabled");

            });

        };

    });

    // toggles sidebar

    $("#menu-toggle").click(function(e) {

        e.preventDefault();
        $("#wrapper").toggleClass("toggled");

    });

    // create modal behaviour

    $("#create").on("hidden.bs.modal", function() {

        $("#create-modal-form").trigger("reset");
        $("#alert").html("");

    });

    // Select department from <select> options in the modal

    $("#modalDiv").on("shown.bs.modal", "div.modal", function() {

        const id = $(this).find("input[name='id']").val();

        console.log($(this).find(`#update-form-modal-${id}`));

        $(this).find(`#update-form-modal-${id}`)[0].reset();

        const departmentId = $(this).find("input[name='departmentId'").val();

        $(this).find(`#department-modal-update-delete${id}`).children(`option[value='${departmentId}']`).attr("selected", "selected");

    });

    // Scroll behaviour and toggle active class Pagination

    $(".pagination").on("click", "a", function() {
        
        $(this).parent().siblings().removeClass('active');

        if (!$(this).parent().hasClass("active")) {

            $(this).parent().toggleClass("active");

        };

        $("html, body").animate({ scrollTop: 0 }, "slow");

    });

    $(".card-deck").on("click", "a", function() {

        $("html, body").animate({ scrollTop: 0 }, "fast");

    });

    // -->

    // Hide sidebar 

    $("div.container-fluid").click(function() {

        $("#wrapper").removeClass("toggled");

    });

    // -->

    // Set location input value in Create-modal OnChange

    $("#department-modal-create").change(function() {

        const valueSelected = this.value;
        const locationInput = $("#location-modal-create");
                
        switch (valueSelected) {
            case "1":
            case "4":
            case "5":
                locationInput.val("London");
                break;
            case "2":
            case "3":
                locationInput.val("New York");
                break;
            case "6":
            case "7":
            case "12":
                locationInput.val("Paris");
                break;
            case "8":
            case "9":
                locationInput.val("Munich");
                break;
            case "10":
            case "11":
                locationInput.val("Rome");
                break;
        };

    });

    // Set location input value in Update And Delete Modals OnChange

    $("#modalDiv").on("shown.bs.modal", "div.modal", function() {

        const id = $(this).find("input[name='id']").val();

        const departmentId = $(this).find("input[name='departmentId'").val();

        const locationInput = $(this).find(`#location-modal-update-delete${id}`);

        $(this).find(`#department-modal-update-delete${id}`).change(function() {

            const valueSelected = this.value;
                    
            switch (valueSelected) {
                case "1":
                case "4":
                case "5":
                    locationInput.val("London");
                    break;
                case "2":
                case "3":
                    locationInput.val("New York");
                    break;
                case "6":
                case "7":
                case "12":
                    locationInput.val("Paris");
                    break;
                case "8":
                case "9":
                    locationInput.val("Munich");
                    break;
                case "10":
                case "11":
                    locationInput.val("Rome");
                    break;
            };

        });

    });

    $("#searchInput").keyup(function() {

        const data = $("#search-form-input").serialize();

        $.post("./PHP/searchByName.php", data, function(res) {

            $("ul.pagination").html("");

            for (let index = 1; index <= res.metadata.pages; index++) {

                if (index == 1) {

                    const li = `<li class="page-item active"><a class="page-link" href="javascript:searchByName('${data}', '${index}')">${index}</a></li>`;
                    $("ul.pagination").append(li);
                    continue;

                }

                    const li = `<li class="page-item"><a class="page-link" href="javascript:searchByName('${data}', '${index}')">${index}</a></li>`;
                    $("ul.pagination").append(li);

            };

            renderCards(res);

        });

    });

    $("#search-form-input").submit(function(event) {

        event.preventDefault();

    });

});
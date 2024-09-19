

"use strict";
var KTDatatablesAdvancedColumnRendering = function () {

    var init = function () {
        var table = $('#kt_datatable');

        // begin first table
        table.DataTable({
            responsive: true,
            paging: true,
            ajax: {
                url: "../controller/php/requirementscontroller.php",
                method: "POST",
                data: {
                    "requirements": "retrieve_file"
                },
                dataSrc: function (data) {
                    var response = data[0];
                    var response_data = response.request_data;
                    console.log(response_data);
                    return response_data;
                }
            },
            columns:
                [
                    { "data": "req_name" },
                    { "data": "date_added" },
                    { "data": "req_id" }
                ],
            columnDefs: [
                {
                    targets: -1,
                    title: 'Actions',
                    orderable: false,
                    render: function (data, type, full, meta) {
                        console.log(full);
                        var deleteFileAction = "DeleteFile('" + data + "')";

                        var returnAction = '\
                        <button onclick=" '+ deleteFileAction + ' " class="btn btn-sm btn-clean btn-icon" title="Delete">\
                            <i class="la la-trash"></i>\
                        </button>\
						';

                        return returnAction;
                    },
                }
            ],
        });

        $('#kt_datatable_search_status').on('change', function () {
            datatable.search($(this).val().toLowerCase(), 'Status');
        });

        $('#kt_datatable_search_type').on('change', function () {
            datatable.search($(this).val().toLowerCase(), 'Type');
        });

        $('#kt_datatable_search_status, #kt_datatable_search_type').selectpicker();
    };

    return {

        //main function to initiate the module
        init: function () {
            init();
        }
    };
}();

jQuery(document).ready(function () {
    KTDatatablesAdvancedColumnRendering.init();
});

//Page Loader
document.onreadystatechange = function () {
    if (document.readyState !== "complete") {
        $('#custom_preloader').delay(350).fadeIn('slow')
    } else {
        LoadAvailableMenu(3);
        $('#custom_preloader').delay(350).fadeOut('slow');
    }
};

function AddNewFile() {
    var req_name = document.getElementById("filename").value;
    $.ajax({
        url: "../controller/php/requirementscontroller.php",
        method: "POST",
        data: {
            "requirements": "new_file",
            "req_name": req_name,
        },
        success: function (data) {
            var response = data[0];
            var response_data = response.request_data;
            var response_status = response.request_status;

            response_status.forEach(function (status_result) {
                if (status_result.status_code == 200) {
                    $("#NewRequirements").modal('hide');
                    document.getElementById("filename").value = "";

                    swal.fire({
                        text: "File Added",
                        icon: "success",
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function () {
                        $("#kt_datatable").DataTable().ajax.reload();
                    });
                }
            });

        },
        error: function (data) {
            console.log(data);

            swal.fire({
                text: "Sorry, looks like there are some errors detected, please try again.",
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                confirmButtonClass: "btn font-weight-bold btn-light"
            }).then(function () {
                KTUtil.scrollTop();
            });
        }
    });
}

function DeleteFile(req_id) {

    Swal.fire({
        title: "Are you sure want to delete this requirements?",
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: "Yes"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "../controller/php/requirementscontroller.php",
                method: "POST",
                data: {
                    "requirements": "delete_file",
                    "req_id": req_id,
                },
                success: function (data) {
                    var response = data[0];
                    var response_data = response.request_data;
                    var response_status = response.request_status;

                    response_status.forEach(function (status_result) {
                        if (status_result.status_code == 200) {
                            swal.fire({
                                text: "Requirement Deleted",
                                icon: "success",
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function () {
                                $("#kt_datatable").DataTable().ajax.reload();
                            });
                        }
                    });

                },
                error: function (data) {
                    console.log(data);

                    swal.fire({
                        text: "Sorry, looks like there are some errors detected, please try again.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        confirmButtonClass: "btn font-weight-bold btn-light"
                    }).then(function () {
                        KTUtil.scrollTop();
                    });
                }
            });
        }
    });


}


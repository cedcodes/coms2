var avatar5 = new KTImageInput('concourse_image');
var avatar6 = new KTImageInput('concourse_layout');
var con_id = document.getElementById("con_id").innerText;
var usertype = document.getElementById("usertype").innerText;

jQuery(document).ready(function () {
    KTDatatablesAdvancedColumnRendering.init();
    PrepareMapLayout();
    document.getElementById("btnAddspace").style.display = usertype == "Owner" ? "inline" : "none";
});

var lblElectricAmount;
var lblWaterAmount;
var ClickedSpace;
var ClickedBill;


function callBillAmount(){
    $.ajax({
        url: "../controller/php/bill-summary.php",
        method: "POST",
        data: {
            "billamount": 'billamount',
            "ClickedSpace": ClickedSpace
        },
        success: function (data) {
            var json = JSON.parse(data);
            console.log(json, 'jData');
            // if (json.length > 0){
            var jData = json.data.data[0]

            lblElectricAmount = jData.txtElectricAmount;
            lblWaterAmount = jData.txtWaterAmount;
            txtRentTotal = jData.space_price;

            $('.lblElectricAmount').text(lblElectricAmount)
            $('.lblWaterAmount').text(lblWaterAmount)
            $('#txtRentTotal').val(txtRentTotal)
            // }     
        },
        error: function (data) {
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
    })
}


function computeBilling() {
    var ElecUnit = $("#txtElectricUnit").val() == '' ? 0 : $("#txtElectricUnit").val()
    var WatUnit = $("#txtWaterUnit").val() == '' ? 0 : $("#txtWaterUnit").val()

    var ElecTotal = ElecUnit * lblElectricAmount
    var WatTotal = WatUnit * lblWaterAmount

    $("#txtElectricTotal").val(ElecTotal)
    $("#txtWaterTotal").val(WatTotal)
}

function PrepareMapLayout() {

    document.getElementById("btnAddspace").style.display = "inline";
    document.getElementById("btnCancelCrop").style.display = "none";

    var imgsrc = document.getElementById("img-src");
    var imgsrccon = document.getElementById("img-src-con");
    imgsrc.removeChild(imgsrccon);

    var newimgsrccon = '<div id="img-src-con"></div>';
    $('#img-src').append(newimgsrccon);

    $.ajax({
        url: "../controller/php/viewspacescontroller.php",
        method: "POST",
        data: {
            "space_action": "retrieve_conlayout",
            "con_id": con_id
        },
        success: function (data) {
            var response = data[0];
            var response_data = response.request_data;
            var response_status = response.request_status;
            console.log(response_data);

            if (response_data) {
                response_data.forEach(function (item) {
                    var imagepath = "../uploads/con_layout/" + item.con_layout;
                    var newimagemap = '<img id="image" src="' + imagepath + '" width="100%" height="1500" usemap="#image-map">';
                    $('#img-src-con').append(newimagemap);

                    document.getElementById("conRate").innerText = item.con_rate;
                });
            }

            AppendArea();
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

function AppendArea() {

    var layoutmap = document.getElementById("layoutmap");
    var layoutarea = document.getElementById("layoutarea");
    layoutmap.removeChild(layoutarea);

    var newlayoutarea = '<div id="layoutarea"></div>';
    $('#layoutmap').append(newlayoutarea);

    $.ajax({
        url: "../controller/php/viewspacescontroller.php",
        method: "POST",
        data: {
            "space_action": 'retrieve_space',
            "con_id": con_id
        },
        success: function (data) {
            var response = data[0];
            var response_data = response.request_data;
            var response_status = response.request_status;
            console.log(response_data);

            if (response_data) {
                response_data.forEach(function (item) {
                    var areacoords = item.space_coord_x + "," + item.space_coord_y + "," + item.space_coord_x2 + "," + item.space_coord_y2;
                    var newarea = '<area target="" spaceid="' + item.space_id + '" spacestatus="' + item.space_status + '" title="' + item.space_name + '" href="" coords="' + areacoords + '" shape="rect">';
                    $('#layoutarea').append(newarea);
                });
                CreateAreaButton();
            }
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

function CreateAreaButton() {
    var images = document.querySelectorAll('img[usemap]');
    images.forEach(function (image) {
        var mapid = image.getAttribute('usemap').substr(1);
        var srcimg = document.getElementById("image");

        // var imagewidth = image.getAttribute('width');
        // var imageheight = image.getAttribute('height');
        var imagewidth = srcimg.offsetWidth;
        var imageheight = srcimg.offsetHeight;

        var imagemap = document.querySelector('map[name="' + mapid + '"]');
        var areas = imagemap.querySelectorAll('area');

        image.removeAttribute('usemap');
        imagemap.remove();

        // create wrapper container
        var wrapper = document.createElement('div');
        wrapper.classList.add('imagemap');
        image.parentNode.insertBefore(wrapper, image);
        wrapper.appendChild(image);


        areas.forEach(function (area) {
            var coords = area.getAttribute('coords').split(',');
            var assigned_spaceid = area.getAttribute('spaceid');
            var assigned_spacestat = area.getAttribute('spacestatus');
            var testLink = "OpenNewSpacesModal('" + assigned_spaceid + "','" + assigned_spacestat + "')";
            var xcoords = [parseInt(coords[0]), parseInt(coords[2])];
            var ycoords = [parseInt(coords[1]), parseInt(coords[3])];
            xcoords = xcoords.sort(function (a, b) { return a - b });
            ycoords = ycoords.sort(function (a, b) { return a - b });
            if (assigned_spacestat != 2) {
                wrapper.innerHTML += "<button onclick=" + testLink + " title='" + area.getAttribute('title') + "' class='area' style='left: " + ((xcoords[0] / imagewidth) * 100).toFixed(2) + "%; top: " + ((ycoords[0] / imageheight) * 100).toFixed(2) + "%; width: " + (((xcoords[1] - xcoords[0]) / imagewidth) * 100).toFixed(2) + "%; height: " + (((ycoords[1] - ycoords[0]) / imageheight) * 100).toFixed(2) + "%;'></button>";
            }
        });
    });
}

// function PrepareAddSpace() {
//     Swal.fire({
//         title: "Do you want to save the changes?",
//         showDenyButton: true,
//         showCancelButton: true,
//         confirmButtonText: "Yes",
//         denyButtonText: `No`
//     }).then((result) => {
//         /* Read more about isConfirmed, isDenied below */
//         if (result.isConfirmed) {
//             CropSpaceLayout();
//         } else if (result.isDenied) {
//             $("#NewSpacesModal").modal({ backdrop: "static" });
//         }
//     });
// }

function CropSpaceLayout() {
    document.getElementById("btnAddspace").style.display = "none";
    document.getElementById("btnCancelCrop").style.display = "inline";


    $('#image').Jcrop({
        onSelect: function (c) {
            console.log(c + " : " + c.x + " - " + c.y + " - " + c.x2 + " - " + c.y2);
            document.getElementById("coordx1").innerHTML = c.x;
            document.getElementById("coordx2").innerHTML = c.x2;
            document.getElementById("coordy1").innerHTML = c.y;
            document.getElementById("coordy2").innerHTML = c.y2;

            $("#NewSpacesModal").modal({ backdrop: "static" });
        }
    })


}

function CropCancel() {
    document.getElementById("btnAddspace").style.display = "inline";
    document.getElementById("btnCancelCrop").style.display = "none";
    JcropAPI = $('#image').data('Jcrop');
    JcropAPI.destroy();
}

"use strict";
var KTDatatablesAdvancedColumnRendering = function () {

    var init = function () {
        var table = $('#kt_datatable');

        // begin first table
        table.DataTable({
            responsive: true,
            paging: true,
            ajax: {
                url: "../controller/php/viewspacescontroller.php",
                method: "POST",
                data: {
                    "space_action": "retrieve_space",
                    "con_id": con_id
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
                    { "data": "space_name" },
                    { "data": "tenant_name" },
                    { "data": "space_status" },
                    { "data": "space_id" }
                ],
            columnDefs: [
                {
                    targets: -1,
                    title: 'Actions',
                    orderable: false,
                    render: function (data, type, full, meta) {
                        var ediDetailsAction = "EditConcourse('" + data + "')";
                        var deleteConAction = "DeleteConcourse('" + data + "')";
                        var ViewBilling = "ViewBilling('" + data + "')";
                        var PrevBilling = "PrevBilling('" + data + "')";
                        var ApplySpace = "OpenNewSpacesModal('" + data + "','" + full.space_status + "','" + full.email + "', '" + full.owner + "')";
                        var hidebtn = '';
                        if (full.space_status != 2){
                            hidebtn='d-none';
                        }

                        var ActionButtons_non_owner = '\
                                                <button onclick="\ ' + ApplySpace + ' \" class="btn btn-primary" >\
                                                    View Space \
                                                </button>\
											';
                        var ActionButtons_owner = '\
                                            <div class="dropdown dropdown-inline">\
                                                <a href="javascript:;" title="Settings" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown">\
                                                    <i class="la la-cog"></i>\
                                                </a>\
                                                  <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">\
                                                    <ul class="nav nav-hoverable flex-column">\
                                                        <li class="nav-item"><button class="btn btn-sm nav-link" onclick="\ ' + ApplySpace + ' \" ><i class="nav-icon la la-eye"></i><span class="nav-text">View Details</span></button></li>\
                                                        <li class="nav-item"><button class="btn btn-sm nav-link '+hidebtn+'" onclick="\ ' + ViewBilling + ' \"><i class="nav-icon la la-file-invoice-dollar '+hidebtn+'"></i><span class="nav-text">Create Billing</span></button></li>\
                                                        <li class="nav-item"><button class="btn btn-sm nav-link" onclick="\ ' + PrevBilling + ' \"><i class="nav-icon la la-dollar"></i><span class="nav-text">View Billings</span></button></li>\
                                                    </ul>\
                                                  </div>\
                                            </div>\
                                            <button onclick=" '+ deleteConAction + ' " class="btn btn-sm btn-clean btn-icon" title="Delete">\
                                                <i class="la la-trash"></i>\
                                            </button>\
                                        ';

                        var ActionButtons = usertype == "Owner" ? ActionButtons_owner : ActionButtons_non_owner

                        // <li class="nav-item"><button class="btn btn-sm nav-link" onclick="\ ' + ediDetailsAction + ' \" ><i class="nav-icon la la-edit"></i><span class="nav-text">Edit Details</span></button></li>\
                        return ActionButtons;
                    }
                },
                {
                    targets: 1,
                    orderable: false,
                    render: function (data, type, full, meta) {
                        if (data == null) {
                            return "None"
                        }
                        else {
                            return data;
                        }


                    }
                },
                {
                    targets: 2,
                    orderable: false,
                    render: function (data, type, full, meta) {
                        if (data == 0) {
                            return "Available"
                        }
                        else if (data == 1) {
                            return "Reserved";
                        }
                        else {
                            return "Occupied"
                        }


                    }
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

//Page Loader
document.onreadystatechange = function () {
    if (document.readyState !== "complete") {
        $('#custom_preloader').delay(350).fadeIn('slow')
    } else {
        LoadAvailableMenu(2);
        $('#custom_preloader').delay(350).fadeOut('slow');
    }

};

function ViewBilling(SpaceID) {
    console.log(SpaceID, 'SpaceID')
    ClickedSpace = SpaceID
    callBillAmount()
    $("#mdBillingSetup").modal("show")
}

$('#btnViewAddbill').on('click', function (e) {
    var BillType = $("#txtBillType").val()
    if (BillType == 'SecurityDeposit') {
        $("#mDeposit").modal("show")
    }
    else {
        $("#mdBillingSetup").modal("show")
    }
})

function PrevBilling(space_id) {
    $("#mdViewPrevBillings").modal("show")
    ClickedSpace = space_id
    var table2 = $('#kt_PrevBilling');

    table2.DataTable({
        destroy: true,
        responsive: true,
        paging: true,
        ajax: {
            url: "../controller/php/bill-summary.php",
            method: "POST",
            data: {
                "viewprevbilling": "viewprevbilling",
                "space_id": space_id
            },

            dataSrc: function (data) {
                var json = data
                var jData = json.data.data
                console.log(jData)
                return jData;
            }
        },
        order:[[2, 'desc']],
        columns:
            [
                { "data": "bill_id" },
                { "data": "tenant_name" },
                { "data": "due_date" },
                { "data": "billtype" },
                { "data": "amount" },
                { "data": "penaltyamount" },
                { "data": "total" },
                { "data": "payment_status" },
                { "data": "bill_id" },
            ],
        columnDefs: [
            {
                targets: -1,
                title: 'Actions',
                orderable: false,
                render: function (data, type, full, meta) {
                    var updateBilling = "updateBilling('" + data + "')";

                    var ActionButtons = '\
                                                <button class="btn btn-sm btn-clean btn-icon" onclick="' + updateBilling + '" title="Update Billing">\
                                                    <i class="la la-edit"></i>\
                                                </button>\
                                            ';

                    return ActionButtons;
                }
            }
        ],
    });
}

$('#btnBillDeposit').on('click', function (e) {
    e.preventDefault();

    var txtAmount = $('#txtBAmount').val()
    var txtDueDate = $('#txtBDueDate').val()

    console.log('ClickedSpace', ClickedSpace, txtAmount, txtDueDate, btnBillDeposit);
    $.ajax({
        url: "../controller/php/bill-summary.php",
        method: "POST",
        data: {
            "saveNewSpaceBill": 'saveNewSpaceBill',
            "newAmount": txtAmount,
            "newDueDate": txtDueDate,
            "newBillType": 'SecurityDeposit',
            "space_id": ClickedSpace
        },
        success: function (data) {
            console.log(data);
            var json = JSON.parse(data);

            console.log(json);
            var _islogin = json.success;
            var err_mess = json.message;
            var err_status = json.err_status;

            if (_islogin) {
                swal.fire({
                    text: "All is cool! " + err_mess,
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    confirmButtonClass: "btn font-weight-bold btn-light-primary"
                }).then(function () {

                });
            }
        },
        error: function (data) {
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
    })
})


$('#btnCreateUtilityBilling').on('click', function (e) {
    e.preventDefault();

    var txtElectricTotal = $('#txtElectricTotal').val()
    var txtWaterTotal = $('#txtWaterTotal').val()
    // var txtDueDate = $('#txtDueDate').val()
    console.log('ClickedSpace1', ClickedSpace, txtElectricTotal, txtWaterTotal);

    if (txtElectricTotal == '' || txtWaterTotal == '') {
        alert('Please enter Electric/water consumption and select Due Date')
    } else {
        $.ajax({
            url: "../controller/php/bill-summary.php",
            method: "POST",
            data: {
                "saveNewUtilityBill": 'saveNewUtilityBill',
                "newElectricAmount": txtElectricTotal,
                "newWaterAmount": txtWaterTotal,
                // "newDueDate": txtDueDate,
                "newBillType": 'UtilityBill',
                "space_id": ClickedSpace
            },
            beforeSend: function(e)
            {
                $("#mdLoadingScreen").modal("show");
            }, 
            success: function (data) {
                $("#mdLoadingScreen").modal("hide");
                console.log(data);
                var json = JSON.parse(data);

                console.log(json);
                var _islogin = json.success;
                var err_mess = json.message;
                var err_status = json.err_status;

                if (_islogin) {
                    swal.fire({
                        text: "All is cool! " + err_mess,
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        confirmButtonClass: "btn font-weight-bold btn-light-primary"
                    }).then(function () {

                    });
                }
            },
            error: function (data) {
                $("#mdLoadingScreen").modal("hide");
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
        })
    }
})


$('#btnBillingSaveChanges').on('click', function (e) {
    e.preventDefault();

    var txt_selectedAmount = $('#txt_selectedAmount').val()
    var txtPaymentStatus = $("#txtPaymentStatus").val()

    console.log('ClickedSpace', ClickedSpace, txtWaterTotal, txtElectricTotal);
    $.ajax({
        url: "../controller/php/bill-summary.php",
        method: "POST",
        beforeSend: function(e)
        {
            $("#mdLoadingScreen").modal("show");
        }, 
        data: {
            "saveUpdateSpaceBill": 'saveUpdateSpaceBill',
            "updBillAmount": txt_selectedAmount,
            "updPaymentStatus": txtPaymentStatus,
            "bill_id": ClickedBill
        },
        success: function (data) {
            $("#mdLoadingScreen").modal("hide");
            console.log(data);
            var json = JSON.parse(data);

            console.log(json);
            var _islogin = json.success;
            var err_mess = json.message;
            var err_status = json.err_status;

            if (_islogin) {
                swal.fire({
                    text: "All is cool! " + err_mess,
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    confirmButtonClass: "btn font-weight-bold btn-light-primary"
                }).then(function () {
                    $("#mdUpdateBilling").modal('hide')
                    PrevBilling(ClickedSpace);
                });
            }
        },
        error: function (data) {
            $("#mdLoadingScreen").modal("hide");
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
    })
})

function updateBilling(bill_id) {
    ClickedBill = bill_id
    $("#mdUpdateBilling").modal("show")

    $.ajax({
        url: "../controller/php/bill-summary.php",
        method: "POST",
        data: {
            "selected_space_bill": 'selected_space_bill',
            "bill_id": bill_id
        },
        success: function (data) {
            var json = JSON.parse(data);
            var jData = json.data.data[0]
            console.log(jData, 'updateBilling');

            var amount = jData.amount;
            var paymentstatus = jData.paymentstatus;

            $('#txt_selectedAmount').val(amount)
            $("#txtPaymentStatus").val(paymentstatus)

            var img_data = jData.receipt_img;
            var img = img_data == '' || img_data === null ? '' : img_data;

            if (img != '') {
                $("#row_uploadedphoto").removeClass('d-none')
                $("#imgDisplayReceipt").attr("src", "../assets/uploads/receipt/" + img)
            } else {
                $("#row_uploadedphoto").addClass('d-none')
            }

        },
        error: function (data) {
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
    })
}

function OpenNewSpacesModal(data, space_status, email, owner) {
    console.log(usertype);
    if (space_status != 0 || usertype == "Owner") {
        document.getElementById("btnPrepareSpace").style.display = "none";
        document.getElementById("btnNotifyMe").style.display = "none";
    }
    else if (space_status == 2 && usertype != "Owner") {
        document.getElementById("btnPrepareSpace").style.display = "none";
        document.getElementById("btnNotifyMe").style.display = "inline";
    }
    else {
        document.getElementById("btnPrepareSpace").style.display = "inline";
        document.getElementById("btnNotifyMe").style.display = "none";
    }

    GetRequirements(email, owner);
    document.getElementById("selectedspace").innerText = data;
    document.getElementById("owner").innerText = owner;
    document.getElementById("owner_email").innerText = email;
    ViewSpace(data);
    $("#ViewSpace").modal({ backdrop: "static" });
}

function ApplySpacesModal() {
    $("#ViewSpace").modal("hide");
    $("#ApplySpace").modal({ backdrop: "static" });
}

function CancelNewConcourse() {
    ClearFields();
}

function AddNewSpace() {
    var spaceData = new FormData();

    var coordx = document.getElementById("coordx1").innerHTML;
    var coordx2 = document.getElementById("coordx2").innerHTML;
    var coordy = document.getElementById("coordy1").innerHTML;
    var coordy2 = document.getElementById("coordy2").innerHTML;

    coordx = coordx.trim().length === 0 ? 0 : coordx;
    coordx2 = coordx2.trim().length === 0 ? 0 : coordx2;
    coordy = coordy.trim().length === 0 ? 0 : coordy;
    coordy2 = coordy2.trim().length === 0 ? 0 : coordy2;

    var spacename = document.getElementById("spacename").value;
    var spaceprice = document.getElementById("spaceprice").value;
    var spacewidth = document.getElementById("spacewidth").value;
    var spacelength = document.getElementById("spacelength").value;

    spaceData.append('space_action', 'new_space');
    spaceData.append('con_id', con_id);
    spaceData.append('coordx', coordx);
    spaceData.append('coordx2', coordx2);
    spaceData.append('coordy', coordy);
    spaceData.append('coordy2', coordy2);
    spaceData.append('spacename', spacename);
    spaceData.append('spaceprice', spaceprice);
    spaceData.append('spacewidth', spacewidth);
    spaceData.append('spacelength', spacelength);


    $.ajax({
        url: "../controller/php/viewspacescontroller.php",
        method: "POST",
        processData: false,
        contentType: false,
        data: spaceData,
        success: function (data) {
            var response = data[0];
            var response_data = response.request_data;
            var response_status = response.request_status;

            if (response_data) {
                response_data.forEach(function (result) {
                    if (result.code == 200) {
                        $("#NewSpacesModal").modal('hide');

                        swal.fire({
                            text: "Space Added.",
                            icon: "success",
                            buttonsStyling: false,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function () {
                            ClearFields();
                            $("#kt_datatable").DataTable().ajax.reload();
                            location.reload();
                        });
                    }
                });
            }

            console.log(response_data);

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
    })
}

function ClearFields() {
    document.getElementById("coordx1").innerHTML = "";
    document.getElementById("coordx2").innerHTML = "";
    document.getElementById("coordy1").innerHTML = "";
    document.getElementById("coordy2").innerHTML = "";
    document.getElementById("spacename").value = "";
    document.getElementById("spaceprice").value = 0;
    document.getElementById("spacewidth").value = "";
    document.getElementById("spacelength").value = "";
    document.getElementById("additional_rate").value = "";
    CropCancel();
}

//autocompute price
$("#spacelength,#additional_rate,#spacewidth").on("input", function () {
    var space_length = (document.getElementById("spacelength").value);
    var additional_rate = (document.getElementById("additional_rate").value);
    var conRate = (document.getElementById("conRate").innerText);

    space_length = space_length.length > 0 ? space_length : 0;
    var space_width = document.getElementById("spacewidth").value;
    space_width = space_width > 0 ? space_width : 0;
    additional_rate = additional_rate > 0 ? additional_rate : 0;

    var compute_price = ((space_width * space_length) * conRate) + parseInt(additional_rate);
    document.getElementById("spaceprice").value = compute_price;
});

const uploadButton = document.getElementById("uploadButton");
uploadButton.addEventListener("click", uploadFiles);

var filecontainer = [];
var reqfileIdList = [];

function GetRequirements(email, owner) {
    var reqparent = document.getElementById("reqparent");
    var reqchild = document.getElementById("reqchild");
    reqparent.removeChild(reqchild);

    var reqdivchild = '<div id="reqchild">' +
        '<h6 class="mb-10">Please upload the needed requirements:</h6>' +
        '<div class="row" id="reqrow">' +
        '</div>' +
        '</div>';
    $('#reqparent').append(reqdivchild);


    $.ajax({
        url: "../controller/php/viewspacescontroller.php",
        method: "POST",
        data: {
            "requirements": "get_req"
        },
        success: function (data) {
            var response = data[0];
            var response_data = response.request_data;
            var response_status = response.request_status;

            response_status.forEach(function (status_result) {
                if (status_result.status_code == 200) {
                    if (response_data) {
                        response_data.forEach(function (result) {
                            var reqlistfile = '<div class="col-md-4">' +
                                '<div class="form-group">' +
                                '<label>*' + result.req_name + '</label>' +
                                '<input type="file" class="form-control form-control-solid h-auto py-5 px-6"' +
                                'id="req' + result.requirement_id + '" name="files[]" accept="*" />' +
                                '</div>' +
                                '</div>';
                            reqfileIdList.push(result.requirement_id)
                            $('#reqrow').append(reqlistfile);
                        });
                    }
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

function uploadFiles(event) {
    event.preventDefault();
    reqfileIdList.forEach(function (reqfile) {
        const fileInput = document.getElementById("req" + reqfile);
        const selectedFiles = fileInput.files;
        filecontainer.push({ selectedFiles, reqfile });
    });

    console.log(filecontainer);

    // Check if any files are selected
    if (filecontainer.length === 0) {
        alert("Please select at least one file to upload.");
        return;
    }
    else {

        SubmitApplication(filecontainer);
    }
}

function SubmitApplication(filecontainer) {
    var applicationData = new FormData();
    var space_id = document.getElementById("selectedspace").innerText;
    var leaseTerms = document.getElementById("leaseTerms").value;
    var applicant_remarks = document.getElementById("applicant_remarks").value;

    applicationData.append('space_action', 'submit_application');
    applicationData.append('con_id', con_id);
    applicationData.append('space_id', space_id);
    applicationData.append('leaseTerms', leaseTerms);
    applicationData.append('applicant_remarks', applicant_remarks);
    applicationData.append('application_type', 0);

    var owner = document.getElementById("owner").innerText;
    var owner_email = document.getElementById("owner_email").innerText;
    var vspaceName = document.getElementById("vspacename").innerHTML;

    swal.fire({
        text: "Submitting your application, please wait.",
        icon: "warning",
        allowOutsideClick: false,
        buttonsStyling: false,
        showConfirmButton: false
    });

    $.ajax({
        url: "../controller/php/viewspacescontroller.php",
        method: "POST",
        processData: false,
        contentType: false,
        data: applicationData,
        success: function (data) {
            var response = data[0];
            var response_data = response.request_data;
            var response_status = response.request_status;

            if (response_data) {
                response_data.forEach(function (result) {
                    if (result.code == 200) {

                        filecontainer.forEach(function (listfile) {
                            console.log(listfile.selectedFiles, listfile.reqfile);
                            UploadRequirements(result.application_id, listfile.selectedFiles[0], listfile.reqfile);
                        });
                        // SendEmail(owner, owner_email, vspaceName);
                        swal.fire({
                            text: "Application Submit.",
                            icon: "success",
                            buttonsStyling: false,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function () {
                            GetNotification();
                            $("#kt_datatable").DataTable().ajax.reload();
                            location.reload();
                        });
                    }
                });
            }

            console.log(response_data);

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
    })
}

function UploadRequirements(application_id, fileToBeUpload, fileID) {
    var uploadData = new FormData();
    var space_id = document.getElementById("selectedspace").innerText;

    uploadData.append('space_action', 'upload_requirements');
    uploadData.append('con_id', con_id);
    uploadData.append('application_id', application_id);
    uploadData.append('req_file', fileToBeUpload);
    uploadData.append('requirement_id', fileID);

    $.ajax({
        url: "../controller/php/viewspacescontroller.php",
        method: "POST",
        processData: false,
        contentType: false,
        data: uploadData,
        success: function (data) {
            var response = data[0];
            var response_data = response.request_data;
            var response_status = response.request_status;

            console.log(response_data);

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
    })
}

function ViewSpace(space_id) {

    $.ajax({
        url: "../controller/php/viewspacescontroller.php",
        method: "POST",
        data: {
            "space_action": "view_space",
            "con_id": con_id,
            "space_id": space_id,
        },
        success: function (data) {
            var response = data[0];
            var response_data = response.request_data;
            var response_status = response.request_status;

            response_status.forEach(function (status_result) {
                if (status_result.status_code == 200) {
                    if (response_data) {
                        response_data.forEach(function (result) {

                            document.getElementById("vspacename").innerHTML = result.space_name;
                            document.getElementById("vspacestatus").innerHTML = result.space_status == 0 ? "Available" : result.space_status == 1 ? "Reserved" : "Occupied";
                            document.getElementById("vspacedimension").innerHTML = result.space_dimension;
                            document.getElementById("vspacearea").innerHTML = result.space_area + " sqm";
                            document.getElementById("vspaceprice").innerHTML = result.space_price;
                            document.getElementById("vspaceowner").innerHTML = result.owner_name;

                        });
                    }
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

// function UpdateConcourse(con_id) {
//     //
//     var concourseData = new FormData();
//     // dataImg.append('img', imageData.files[0]);

//     var conLat = document.getElementById("txtlat").innerHTML;
//     var conLong = document.getElementById("txtlongt").innerHTML;

//     conLat = conLat.trim().length === 0 ? 0 : conLat;
//     conLong = conLong.trim().length === 0 ? 0 : conLong;

//     var conAddress = document.getElementById("conAddress").value;
//     var conName = document.getElementById("conName").value;
//     var conImage = $('#conImage').prop('files')[0];
//     var conLayout = $('#conLayout').prop('files')[0];

//     concourseData.append('concourse', 'update_concourse');
//     concourseData.append('conLat', conLat);
//     concourseData.append('conLong', conLong);
//     concourseData.append('conAddress', conAddress);
//     concourseData.append('conName', conName);
//     concourseData.append('conImage', conImage);
//     concourseData.append('conLayout', conLayout);
//     concourseData.append('conID', con_id);

//     console.log(concourseData);

//     $.ajax({
//         url: "../controller/php/concoursecontroller.php",
//         method: "POST",
//         processData: false,
//         contentType: false,
//         data: concourseData,
//         success: function (data) {
//             var response = data[0];
//             var response_data = response.request_data;
//             var response_status = response.request_status;

//             if (response_data) {
//                 response_data.forEach(function (result) {
//                     if (result.code == 200) {
//                         $("#NewConcourseModal").modal('hide');

//                         swal.fire({
//                             text: "Concourse Updated.",
//                             icon: "success",
//                             buttonsStyling: false,
//                             showConfirmButton: false,
//                             timer: 1500
//                         }).then(function () {
//                             RemoveMark();
//                             initMap();
//                             ClearFields();
//                             $("#kt_datatable").DataTable().ajax.reload();
//                         });
//                     }
//                 });
//             }
//             console.log(response_data);
//             console.log(response_status);

//         },
//         error: function (data) {
//             console.log(data);

//             swal.fire({
//                 text: "Sorry, looks like there are some errors detected, please try again.",
//                 icon: "error",
//                 buttonsStyling: false,
//                 confirmButtonText: "Ok, got it!",
//                 confirmButtonClass: "btn font-weight-bold btn-light"
//             }).then(function () {
//                 KTUtil.scrollTop();
//             });
//         }
//     })
// }

function DeleteConcourse(space_id) {

    Swal.fire({
        title: "Are you sure want to delete this space?",
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: "Yes"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "../controller/php/viewspacescontroller.php",
                method: "POST",
                data: {
                    "space_action": "delete_space",
                    "space_id": space_id,
                },
                success: function (data) {
                    var response = data[0];
                    var response_data = response.request_data;
                    var response_status = response.request_status;

                    response_status.forEach(function (status_result) {
                        if (status_result.status_code == 200) {
                            swal.fire({
                                text: "Space Deleted",
                                icon: "success",
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function () {
                                $("#kt_datatable").DataTable().ajax.reload();
                                RemoveMark();
                                initMap();
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

function NotifyMe() {

    var space_id = document.getElementById("selectedspace").innerText;

    $.ajax({
        url: "../controller/php/viewspacescontroller.php",
        method: "POST",
        data: {
            "space_action": "notify_me",
            "con_id": con_id,
            "space_id": space_id,
        },
        success: function (data) {
            var response = data[0];
            var response_data = response.request_data;
            var response_status = response.request_status;

            console.log(response_data);
            console.log(response_status);
            response_status.forEach(function (status_result) {
                if (status_result.status_code == 200) {
                    swal.fire({
                        title: "Alert Added.",
                        text: "We will let you know when the space is already available",
                        icon: "success",
                        buttonsStyling: false,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function () {
                        // location.reload();
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

function SendEmail(spaceName, owner, owner_email) {
    $.ajax({
        url: "../controller/php/shared/emailcontroller.php",
        method: "POST",
        data: {
            "email": "new_application_alert",
            "spaceName": spaceName,
            "owner": owner,
            "owner_email": owner_email
        },
        success: function (data) {
            console.log(data);
            $("#ApplySpace").modal('hide');

            swal.fire({
                text: "Application Submit.",
                icon: "success",
                buttonsStyling: false,
                showConfirmButton: false,
                timer: 1500
            }).then(function () {
                GetNotification();
                $("#kt_datatable").DataTable().ajax.reload();
                location.reload();
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
    })
}
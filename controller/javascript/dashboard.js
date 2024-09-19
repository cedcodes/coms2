
"use strict";
var KTDatatablesAdvancedColumnRendering = function() {

	var init = function() {

        var table = $('#kt_ConBilling');

        table.DataTable({
            responsive: true,
            paging: true,
            ajax: {
                url: "/new-coms/controller/php/dashboardcontroller.php",
                method: "POST",
                data: {
                    "viewbillperconcourse": "viewbillperconcourse"
                },
                dataSrc: function (data) {
                    console.log(data)
                    var json = data
                    var jData = json.data.data
                    console.log(data)
                    return jData;
                }
            },
            columns:
                [
                    { "data": "con_name" },
                    { "data": "billtype" },
                    { "data": "TotalBilling" }
                ],
        });

        $('#kt_datatable_search_status').on('change', function() {
			datatable.search($(this).val().toLowerCase(), 'Status');
		});

		$('#kt_datatable_search_type').on('change', function() {
			datatable.search($(this).val().toLowerCase(), 'Type');
		});

		$('#kt_datatable_search_status, #kt_datatable_search_type').selectpicker();
    };

    return {
		//main function to initiate the module
		init: function() {
			init();
	    }
    }
}();

jQuery(document).ready(function() {
	KTDatatablesAdvancedColumnRendering.init();
});


$(document).ready(function () {
    // alert("Concourse");

    
    $.ajax({
        url:"/new-coms/controller/php/dashboardcontroller.php",
        method:"POST",
        data:{
            "dashboardfigures": 'dashboardfigures'
        },
        success:function(data){	
            console.log(data,'data');
            var json = JSON.parse(data);
            // var jData = json.data.data[0]
            console.log(json.data.data[0]);

            $("#TotalSpace").text(json.data.data[0].Total.toString())
            $("#TotalReserved").text(json.data.data[0].TotalReserved)
            $("#TotalOccupied").text(json.data.data[0].TotalOccupied)
            $("#TotalAvailable").text(json.data.data[0].TotalAvailable)
            $("#NewApplication").text(json.data.data[0].NewApplication)
            $("#TotalBilling").text('Php ' + ((Math.round(json.data.data[0].TotalBilling.toString() * 100) / 100).toFixed(2)).toString())
           
            $("#lblunpaidElectric").text(json.data.data[0].TotalBillingE)
            $("#lblunpaidWater").text(json.data.data[0].TotalBillingW)
            $("#lblunpaidRent").text(json.data.data[0].TotalBillingR)
            $("#lblunpaidSecDep").text(json.data.data[0].TotalBillingS)
            // if(json.success){
            //     $('#txtElectricAmount').val(jData.txtElectricAmount)
            //     $('#txtWaterAmount').val(jData.txtWaterAmount)
            // }
        },
        error:function(data){
            swal.fire({
                text: "Sorry, looks like there are some errors detected, please try again.",
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                confirmButtonClass: "btn font-weight-bold btn-light"
            }).then(function() {
                KTUtil.scrollTop();
            });
        }
    })

});


//Page Loader
document.onreadystatechange = function () {
    if (document.readyState !== "complete") {
        $('#custom_preloader').delay(350).fadeIn('slow')
    } else {
        LoadAvailableMenu(1);
        $('#custom_preloader').delay(350).fadeOut('slow');
    }
};


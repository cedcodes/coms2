

"use strict";
var KTDatatablesAdvancedColumnRendering = function() {

	var init = function() {
		var table = $('#kt_datatable');

		// begin first table
		table.DataTable({
			responsive: true,
			paging: true,
			ajax: {
				url: "../controller/php/tenantcontroller.php",
				method: "POST",
				data: {
					"tenant": "retrieve_tenant"
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
					{ "data": "tenant_id" },
					{ "data": "tenant" },
					{ "data": "con_name" },
					{ "data": "space_name" },
					{ "data": "startdate" },
					{ "data": "rentstatus" },
					{ "data": "space_id" }
				],
			columnDefs: [
				{
					targets: -1,
					title: 'Actions',
					orderable: false,
					render: function(data, type, row, meta) {
						var viewContract = "viewContract('" + data + "', '"+ row.tenant_id +"', '"+ row.rentstatus +"')";
                    
						var ActionButtons = '\
												<button class="btn btn-sm btn-clean btn-icon" onclick="' + viewContract + '" title="View Contract">\
													<i class="la la-sitemap"></i>\
												</button>\
											';
						return ActionButtons;
					},
				}
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
	};
}();

jQuery(document).ready(function() {
	KTDatatablesAdvancedColumnRendering.init();
});

var vspace_id, vtenant_id;

function viewContract(space_id, tenant_id, rentstatus){
	// alert('Open Contract')
	console.log(space_id,'space_id');
	console.log(tenant_id,'tenant_id');
	vspace_id=space_id;
	vtenant_id=tenant_id
	if (rentstatus!='ACTIVE'){
		$("#btnTerminateContract").addClass("d-none")
	}

	$("#mdViewTenantContract").modal('show')
	$.ajax({
		url:"../controller/php/tenantcontroller.php",
		method:"POST",
		data:{
			"vwContract": 'vwContract',
			"space_id": space_id,
			"tenant_id": tenant_id
		},
		success:function(data){	
			console.log(data)
			var jData = data.data.data[0]		
			if(data.success){
				console.log(data.success);
				$('#lblSpaceName').text(jData.space_name)
				$('#lblLeaseTerm').text(jData.lease_terms)
				$('#lblContractStart').text(jData.contract_start)
				$('#lblContractEnd').text(jData.contract_end)
			}
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
}

$('#btnTerminateContract').on('click', function (e) {
    e.preventDefault();
    console.log('1')
	$.ajax({
		url:"../controller/php/tenantcontroller.php",
		method:"POST",
		data:{
			"vwContractTerminate": 'vwContractTerminate',
			"space_id": vspace_id,
			"tenant_id": vtenant_id
		},
		success:function(data){		
			console.log(data,'data')
			if(data.success){
				swal.fire({
					text: "All is cool! The Contract has been terminated.",
					icon: "success",
					buttonsStyling: false,
					confirmButtonText: "Ok, got it!",
					confirmButtonClass: "btn font-weight-bold btn-light-primary"
				}).then(function() {
					location.reload()
				});
			}
		},
		error:function(data){
			console.log(data)
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
})

//Page Loader
document.onreadystatechange = function () {
    if (document.readyState !== "complete") {
        $('#custom_preloader').delay(350).fadeIn('slow')
    } else {
        LoadAvailableMenu(2);
        $('#custom_preloader').delay(350).fadeOut('slow');
    }
};


var avatar5 = new KTImageInput('concourse_image');
var avatar6 = new KTImageInput('concourse_layout');
var usertype = document.getElementById("usertype").innerText;
"use strict";
var KTDatatablesAdvancedColumnRendering = function () {

	var init = function () {
		var table = $('#kt_datatable');

		// begin first table
		table.DataTable({
			responsive: true,
			paging: true,
			ajax: {
				url: "../controller/php/concoursecontroller.php",
				method: "POST",
				data: {
					"concourse": "retrieve_concourse"
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
					{ "data": "con_name" },
					{ "data": "con_address" },
					{ "data": "avl_space" },
					{ "data": "con_id" }
				],
			columnDefs: [
				{
					targets: -1,
					title: 'Actions',
					orderable: false,
					render: function (data, type, full, meta) {
						var ediDetailsAction = "EditConcourse('" + data + "')";
						var deleteConAction = "DeleteConcourse('" + data + "')";
						var viewspaces = "redirectToViewSpaces('" + data + "')";

						var ActionButtons_non_owner = '\
												<div class="dropdown dropdown-inline">\
													<a href="javascript:;" title="Settings" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown">\
														<i class="la la-cog"></i>\
													</a>\
													  <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">\
														<ul class="nav nav-hoverable flex-column">\
															<li class="nav-item"><button class="btn btn-sm nav-link" onclick="' + viewspaces + '"><i class="nav-icon la la-leaf"></i><span class="nav-text">View Spaces</span></button></li>\
														</ul>\
													  </div>\
												</div>\
											';

						var ActionButtons_owner = '\
												<div class="dropdown dropdown-inline">\
													<a href="javascript:;" title="Settings" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown">\
														<i class="la la-cog"></i>\
													</a>\
													  <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">\
														<ul class="nav nav-hoverable flex-column">\
															<li class="nav-item"><button class="btn btn-sm nav-link" onclick="\ ' + ediDetailsAction + ' \" ><i class="nav-icon la la-edit"></i><span class="nav-text">Edit Details</span></button></li>\
															<li class="nav-item"><button class="btn btn-sm nav-link" onclick="' + viewspaces + '"><i class="nav-icon la la-leaf"></i><span class="nav-text">View Spaces</span></button></li>\
														</ul>\
													  </div>\
												</div>\
												<button onclick=" '+ deleteConAction + ' " class="btn btn-sm btn-clean btn-icon" title="Delete">\
													<i class="la la-trash"></i>\
												</button>\
											';

						var ActionButtons = usertype == "Owner" ? ActionButtons_owner : ActionButtons_non_owner;

						return ActionButtons;
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

jQuery(document).ready(function () {
	KTDatatablesAdvancedColumnRendering.init();
	GetRate();
	if (usertype == "Owner") {
		document.getElementById("btnNewConcourse").style.display = "inline";
	}
	else {
		document.getElementById("btnNewConcourse").style.display = "none";
	}
});

//Page Loader
document.onreadystatechange = function () {
	if (document.readyState !== "complete") {
		$('#custom_preloader').delay(350).fadeIn('slow')
	} else {
		LoadAvailableMenu(2);
		$('#custom_preloader').delay(350).fadeOut('slow');
	}
};

function OpenNewConcourseModal() {
	document.getElementById("txtlat").innerHTML = "";
	document.getElementById("txtlongt").innerHTML = "";
	document.getElementById("conAddress").value = "";
	$("#NewConcourseModal").modal({ backdrop: "static" });
}

function CancelNewConcourse() {
	RemoveMark();
	document.getElementById("removeConLayout").click();
	document.getElementById("removeConImage").click();
	ClearFields();
}

function redirectToViewSpaces(con_id) {
	location.href = "viewspaces.php?concourse=" + con_id;
}

function AddNewConcourse() {
	//
	var concourseData = new FormData();
	// dataImg.append('img', imageData.files[0]);

	var conLat = document.getElementById("txtlat").innerHTML;
	var conLong = document.getElementById("txtlongt").innerHTML;

	conLat = conLat.trim().length === 0 ? 0 : conLat;
	conLong = conLong.trim().length === 0 ? 0 : conLong;

	var conAddress = document.getElementById("conAddress").value;
	var conRate = document.getElementById("conRate").value;
	var conName = document.getElementById("conName").value;
	var conImage = $('#conImage').prop('files')[0];
	var conLayout = $('#conLayout').prop('files')[0];


	console.log(conImage);

	concourseData.append('concourse', 'new_concourse');
	concourseData.append('conLat', conLat);
	concourseData.append('conLong', conLong);
	concourseData.append('conAddress', conAddress);
	concourseData.append('conRate', conRate);
	concourseData.append('conName', conName);
	concourseData.append('conImage', conImage);
	concourseData.append('conLayout', conLayout);

	console.log(concourseData);

	// document.getElementById("con_img_name").value = "Test1";
	// document.getElementById("con_layout_name").value = "Test2";

	// document.getElementById("form_upload").submit();

	swal.fire({
		text: "We are now saving, please wait.",
		icon: "warning",
		allowOutsideClick: false,
		buttonsStyling: false,
		showConfirmButton: false
	});

	$.ajax({
		url: "../controller/php/concoursecontroller.php",
		method: "POST",
		processData: false,
		contentType: false,
		data: concourseData,
		success: function (data) {
			var response = data[0];
			var response_data = response.request_data;
			var response_status = response.request_status;

			if (response_data) {
				response_data.forEach(function (result) {
					if (result.code == 200) {

						$("#NewConcourseModal").modal('hide');

						swal.fire({
							text: "Concourse Added.",
							icon: "success",
							buttonsStyling: false,
							showConfirmButton: false,
							timer: 1500
						}).then(function () {
							RemoveMark();
							initMap();
							ClearFields();
							$("#kt_datatable").DataTable().ajax.reload();
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
	document.getElementById("removeConLayout").click();
	document.getElementById("removeConImage").click();
	document.getElementById("txtlat").innerHTML = "";
	document.getElementById("txtlongt").innerHTML = "";
	document.getElementById("conAddress").value = "";
	document.getElementById("conName").value = "";
}

function EditConcourse(con_id) {

	$.ajax({
		url: "../controller/php/concoursecontroller.php",
		method: "POST",
		data: {
			"concourse": "read_concourse",
			"con_id": con_id,
		},
		success: function (data) {
			var response = data[0];
			var response_data = response.request_data;
			var response_status = response.request_status;

			response_status.forEach(function (status_result) {
				if (status_result.status_code == 200) {
					if (response_data) {

						response_data.forEach(function (result) {
							$("#NewConcourseModal").modal({ backdrop: "static" });

							document.getElementById("conAddress").value = result.con_address;
							document.getElementById("conName").value = result.con_name;
							document.getElementById("txtlat").innerHTML = result.con_lat;
							document.getElementById("txtlongt").innerHTML = result.con_long;
							document.getElementById("txtlongt").innerHTML = result.con_long;
							document.getElementById("conRate").value = result.con_rate;

							document.getElementById("btnUpdateConcourse").setAttribute("onclick", "UpdateConcourse('" + con_id + "')");
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

function UpdateConcourse(con_id) {
	//
	var concourseData = new FormData();
	// dataImg.append('img', imageData.files[0]);

	var conLat = document.getElementById("txtlat").innerHTML;
	var conLong = document.getElementById("txtlongt").innerHTML;

	conLat = conLat.trim().length === 0 ? 0 : conLat;
	conLong = conLong.trim().length === 0 ? 0 : conLong;

	var conAddress = document.getElementById("conAddress").value;
	var conRate = document.getElementById("conRate").value;
	var conName = document.getElementById("conName").value;
	var conImage = $('#conImage').prop('files')[0];
	var conLayout = $('#conLayout').prop('files')[0];

	concourseData.append('concourse', 'update_concourse');
	concourseData.append('conLat', conLat);
	concourseData.append('conLong', conLong);
	concourseData.append('conAddress', conAddress);
	concourseData.append('conRate', conRate);
	concourseData.append('conName', conName);
	concourseData.append('conImage', conImage);
	concourseData.append('conLayout', conLayout);
	concourseData.append('conID', con_id);

	swal.fire({
		text: "We are now saving, please wait.",
		icon: "warning",
		allowOutsideClick: false,
		buttonsStyling: false,
		showConfirmButton: false
	});

	$.ajax({
		url: "../controller/php/concoursecontroller.php",
		method: "POST",
		processData: false,
		contentType: false,
		data: concourseData,
		success: function (data) {
			var response = data[0];
			var response_data = response.request_data;
			var response_status = response.request_status;

			if (response_data) {
				response_data.forEach(function (result) {
					if (result.code == 200) {
						$("#NewConcourseModal").modal('hide');

						swal.fire({
							text: "Concourse Updated.",
							icon: "success",
							buttonsStyling: false,
							showConfirmButton: false,
							timer: 1500
						}).then(function () {
							RemoveMark();
							initMap();
							ClearFields();
							$("#kt_datatable").DataTable().ajax.reload();
						});
					}
				});
			}
			console.log(response_data);
			console.log(response_status);

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

function DeleteConcourse(con_id) {

	Swal.fire({
		title: "Are you sure want to delete this concourse?",
		showDenyButton: true,
		showCancelButton: true,
		confirmButtonText: "Yes"
	}).then((result) => {
		if (result.isConfirmed) {
			$.ajax({
				url: "../controller/php/concoursecontroller.php",
				method: "POST",
				data: {
					"concourse": "delete_concourse",
					"con_id": con_id,
				},
				success: function (data) {
					var response = data[0];
					var response_data = response.request_data;
					var response_status = response.request_status;

					response_status.forEach(function (status_result) {
						if (status_result.status_code == 200) {
							swal.fire({
								text: "Concourse Deleted",
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

function GetRate() {
	$.ajax({
		url: "../controller/php/concoursecontroller.php",
		method: "POST",
		data: {
			"concourse": "get_rate"
		},
		success: function (data) {
			var response = data[0];
			var response_data = response.request_data;
			var response_status = response.request_status;
			console.log(response)
			response_status.forEach(function (status_result) {
				if (status_result.status_code == 200) {
					if (response_data) {
						var rateparent = document.getElementById("ParentRate");
						var ratechild = document.getElementById("ChildRate");
						rateparent.removeChild(ratechild);

						var ratedivchild = '<div id="ChildRate"><select class="form-control form-control-solid h-auto py-5 px-6" id="conRate">' +
							'<option value=""> -- SELECT RATE --</option>' +
							'</select></div>';
						$('#ParentRate').append(ratedivchild);

						response_data.forEach(function (result) {
							var optionItem = '<option value="' + result.amount + '">' + result.billing_name + '</option>';
							$('#conRate').append(optionItem);
						});
					}

					return "Rate_Retrieved"
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

			return "Error_Retrieved"
		}
	});
}







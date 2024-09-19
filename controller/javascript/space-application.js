
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
				url: "../controller/php/space-applicationcontroller.php",
				method: "POST",
				data: {
					"space_app": "retrieve_application"
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
					{ "data": "space_name" },
					{ "data": "tenant" },
					{ "data": "date_added" },
					{ "data": "application_id" }
				],
			columnDefs: [
				{
					targets: 2,
					title: usertype == "Owner" ? "APPLICANT" : "OWNER",
					orderable: false,
					render: function (data, type, full, meta) {

						var return_val = usertype == "Owner" ? data : full.owner;
						return return_val;
					},
				},
				{
					targets: -1,
					title: 'Actions',
					orderable: false,
					render: function (data, type, full, meta) {

						console.log(full.rem_req);

						var application_id = full.application_id;
						var application_type = full.application_type;
						var con_name = full.con_name;
						var con_id = full.con_id;
						var con_address = full.con_address;
						var space_name = full.space_name;
						var space_id = full.space_id;
						var tenant = full.tenant;
						var tenant_email = full.tenant_email;
						var owner = full.owner;
						var owner_email = full.owner_email;
						var applicant_remarks = full.applicant_remarks;
						var leaseTerms = full.lease_terms;
						var addedDate = full.date_added;
						var profile_img = full.profile_img;

						var ViewApplication = "ViewApplication('" + application_id +
							"','" + application_type +
							"','" + con_name +
							"','" + con_address +
							"','" + space_name +
							"','" + tenant +
							"','" + tenant_email +
							"','" + owner +
							"','" + owner_email +
							"','" + applicant_remarks +
							"','" + leaseTerms +
							"','" + addedDate +
							"','" + profile_img + "')";

						var ViewContract = "ViewContract('" + space_id + "','" + con_id + "')";


						var ActionButtons = '\
                                                <button onclick="\ ' + ViewApplication + ' \" class="btn btn-primary" >\
                                                    View Application \
                                                </button>\
											';

						var TenantButton = '\
												<button onclick="\ ' + ViewContract + ' \" class="btn btn-primary" >\
												' + full.application_status + ' - (View Contract) \
												</button>\
											';

						var return_val = usertype == "Tenant" && full.is_approved != 3 ?
							(usertype == "Tenant" && full.is_approved == 1 ? TenantButton : full.application_status) : ActionButtons;

						return return_val;

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
		LoadAvailableMenu(2);
		$('#custom_preloader').delay(350).fadeOut('slow');
	}

	if(usertype == "Owner"){
		document.getElementById("lptLabel1").style.display = "inline";
		document.getElementById("lptLabel2").style.display = "inline";
	}
	else if(usertype == "Tenant"){
		document.getElementById("lptLabel1").style.display = "none";
		document.getElementById("lptLabel2").style.display = "none";
	}
};


function ViewApplication(application_id, application_type, con_name, con_address, space_name, tenant, tenant_email, owner, owner_email, applicant_remarks, leaseTerms, addedDate, profile_img) {
	document.getElementById("application_id").innerText = application_id;
	document.getElementById("con_name").innerText = con_name;
	document.getElementById("con_address").innerText = con_address;
	document.getElementById("space_name").innerText = space_name;
	document.getElementById("applicant_name").innerText = tenant;
	document.getElementById("tenant_email").innerText = tenant_email;
	document.getElementById("owner").innerText = owner;
	document.getElementById("owner_email").innerText = owner_email;
	document.getElementById("application_date").innerText = addedDate;
	document.getElementById("lease_term").innerText = leaseTerms;
	document.getElementById("applicant_purpose").value = applicant_remarks;
	document.getElementById("profile_img").src = "../assets/uploads/user/" + profile_img;

	var req_ret_mode = usertype == "Owner" ? 1 : 2;
	GetRequirements(application_id, req_ret_mode, application_type);

}

function ViewContract(space_id, con_id) {

	$.ajax({
		url: "../controller/php/space-applicationcontroller.php",
		method: "POST",
		data: {
			"space_app": "retrieve_contract",
			"space_id": space_id
		},
		success: function (data) {
			var response = data[0];
			var response_data = response.request_data;
			var response_status = response.request_status;

			if (response_data) {
				response_data.forEach(function (result) {
					document.getElementById("contract_con_id").innerText = con_id;
					document.getElementById("contract_space_id").innerText = space_id;
					document.getElementById("contract_space_name").innerText = result.space_name;
					document.getElementById("lease_terms").innerText = result.lease_terms;
					document.getElementById("contract_start").innerText = result.contract_start;
					document.getElementById("contract_end").innerText = result.contract_end;
				});

				$("#ViewContract").modal({ backdrop: "static" });
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
	});

}

function ViewFile(file_name, req_name) {
	document.getElementById("fileName").innerText = req_name;
	document.getElementById("viewfileimg").src = "../uploads/upload_requirements/" + file_name;
	$("#FileViewer").modal({ backdrop: "static" });
}

var filecontainer = [];
var reqfileIdList = [];

function GetRequirements(application_id, req_ret_mode, application_type) {

	$.ajax({
		url: "../controller/php/space-applicationcontroller.php",
		method: "POST",
		data: {
			"space_app": "retrieve_reqfiles",
			"application_id": application_id,
			"req_ret_mode": req_ret_mode
		},
		success: function (data) {
			var response = data[0];
			var response_data = response.request_data;
			var response_status = response.request_status;

			console.log(response_data);
			response_status.forEach(function (status_result) {
				if (req_ret_mode == 1) {
					if (status_result.status_code == 200) {
						if (application_type == 0) {
							document.getElementById("uploadLabel").style.display = "inline";

							var reqparent = document.getElementById("reqparent");
							var reqchild = document.getElementById("reqchild");
							reqparent.removeChild(reqchild);

							var reqdivchild = '<div id="reqchild">' +
								'<h6 class="mb-10">Please upload the needed requirements:</h6>' +
								'<div class="row" id="reqrow">' +
								'</div>' +
								'</div>';
							$('#reqparent').append(reqdivchild);

							if (response_data) {
								response_data.forEach(function (result) {
									if (result.file_name != null) {
										var ViewFileClick = "ViewFile('" + result.file_name + "', '" + result.req_name + "')"
										var reqlistfile = '<div class="col-md-4">' +
											'<div class="form-group">' +
											'<label>' + result.req_name + '</label>' +
											'<button type="button" onclick="' + ViewFileClick + '"' +
											'class="form-control btn btn-secondary">View File</button>' +
											'</div>' +
											'</div>';
										$('#reqrow').append(reqlistfile);
										document.getElementById("btnApproved").style.display = "inline";
										document.getElementById("btnOnhold").style.display = "none";
									}
									else {
										var reqlistfile = '<div class="col-md-4">' +
											'<div class="form-group">' +
											'<label>' + result.req_name + '</label>' +
											'<span class="form-control">No Uploaded file</span>' +
											'</div>' +
											'</div>';
										$('#reqrow').append(reqlistfile);
										document.getElementById("btnApproved").style.display = "none";
										document.getElementById("btnOnhold").style.display = "inline";
									}
								});
								$("#ViewApplication").modal({ backdrop: "static" });
							}
						}
						else{
							document.getElementById("btnApproved").style.display = "inline";
							document.getElementById("uploadLabel").style.display = "none";
							document.getElementById("btnOnhold").style.display = "none";
							$("#ViewApplication").modal({ backdrop: "static" });
						}
					}
				}
				else if (req_ret_mode == 2) {
					console.log(status_result.status_code);
					if (status_result.status_code == 200) {
						var re_reqparent = document.getElementById("re_reqparent");
						var re_reqchild = document.getElementById("re_reqchild");
						re_reqparent.removeChild(re_reqchild);

						var re_reqdivchild = '<div id="re_reqchild">' +
							'<h6 class="mb-10">Please upload the needed requirements:</h6>' +
							'<span id="re_app_id" style="display:none;">' + application_id + '</span>' +
							'<div class="row" id="re_reqrow">' +
							'</div>' +
							'</div>';
						$('#re_reqparent').append(re_reqdivchild);

						if (response_data) {
							response_data.forEach(function (result) {
								var re_reqlistfile = '<div class="col-md-4">' +
									'<div class="form-group">' +
									'<label>*' + result.req_name + '</label>' +
									'<input type="file" class="form-control form-control-solid h-auto py-5 px-6"' +
									'id="re_req' + result.requirement_id + '" name="files[]" accept="*" />' +
									'</div>' +
									'</div>';
								reqfileIdList.push(result.requirement_id)
								$('#re_reqrow').append(re_reqlistfile);
							});
							$("#ReSubmitApplication").modal({ backdrop: "static" });
						}
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

function ActionApplication(action) {
	var app_id = document.getElementById("application_id").innerText
	var subject;

	if (action == "Approved") {
		document.getElementById("ApprovedApp").style.display = "inline";
		document.getElementById("OnholdApp").style.display = "none";
		document.getElementById("RejectApp").style.display = "none";
		subject = "Finalization of Concession Space Turnover Process";

		document.getElementById("ApprovedApp").setAttribute("onclick", "UpdateApplication('" + app_id + "','1','Approved','" + subject + "')");
	}
	else if (action == "OnHold") {
		document.getElementById("OnholdApp").style.display = "inline";
		document.getElementById("ApprovedApp").style.display = "none";
		document.getElementById("RejectApp").style.display = "none";
		subject = "Reminder: Submission of Physical Requirements for Lease Application";

		document.getElementById("OnholdApp").setAttribute("onclick", "UpdateApplication('" + app_id + "','3','On Hold','" + subject + "')");
	}
	else {
		document.getElementById("RejectApp").style.display = "inline";
		document.getElementById("ApprovedApp").style.display = "none";
		document.getElementById("OnholdApp").style.display = "none";
		subject = "";

		document.getElementById("RejectApp").setAttribute("onclick", "UpdateApplication('" + app_id + "','2','Rejected','')");
	}

	$("#ActionApplication").modal({ backdrop: "static" });
}

function UpdateApplication(application_id, is_approved, application_status, subject) {

	var owner_remarks = document.getElementById("owner_remarks").value;

	swal.fire({
		text: "Saving your action, please wait.",
		icon: "warning",
		allowOutsideClick: false,
		buttonsStyling: false,
		showConfirmButton: false
	});

	$.ajax({
		url: "../controller/php/space-applicationcontroller.php",
		method: "POST",
		data: {
			"space_app": "action_application",
			"application_id": application_id,
			"is_approved": is_approved,
			"application_status": application_status,
			"owner_remarks": owner_remarks
		},
		success: function (data) {
			var response = data[0];
			var response_data = response.request_data;
			var response_status = response.request_status;

			if (response_data) {
				response_data.forEach(function (result) {
					if (result.code == 200) {
						SendEmail(subject, is_approved);
						$("#ViewApplication").modal('hide');
						$("#ActionApplication").modal('hide');

						swal.fire({
							text: "Application Updated.",
							icon: "success",
							buttonsStyling: false,
							showConfirmButton: false,
							timer: 1500
						}).then(function () {
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
	});
}

const uploadButton = document.getElementById("uploadButton");
uploadButton.addEventListener("click", uploadFiles);

function uploadFiles(event) {
	event.preventDefault();
	reqfileIdList.forEach(function (reqfile) {
		const fileInput = document.getElementById("re_req" + reqfile);
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

		UploadRequirements(filecontainer);
	}
}

function ReSubmitApplication(application_id) {
	console.log("resub" + application_id);

	swal.fire({
		text: "Saving your action, please wait.",
		icon: "warning",
		allowOutsideClick: false,
		buttonsStyling: false,
		showConfirmButton: false
	});

	$.ajax({
		url: "../controller/php/space-applicationcontroller.php",
		method: "POST",
		data: {
			"space_app": "action_application",
			"application_id": application_id,
			"is_approved": 0,
			"application_status": "For Review"
		},
		success: function (data) {
			var response = data[0];
			var response_data = response.request_data;
			var response_status = response.request_status;

			if (response_data) {
				response_data.forEach(function (result) {
					if (result.code == 200) {
						$("#ReSubmitApplication").modal('hide');

						swal.fire({
							text: "Application Updated.",
							icon: "success",
							buttonsStyling: false,
							showConfirmButton: false,
							timer: 1500
						}).then(function () {
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
	});
}

function UploadRequirements(filecontainer) {

	var application_id = document.getElementById("re_app_id").innerText;

	console.log(filecontainer.length, application_id);
	var counter = 0;

	filecontainer.forEach(function (listfile) {
		console.log(listfile.selectedFiles, listfile.reqfile);
		// UploadRequirements(result.application_id, listfile.selectedFiles[0], listfile.reqfile);

		var uploadData = new FormData();

		uploadData.append('space_action', 'upload_requirements');
		uploadData.append('application_id', application_id);
		uploadData.append('req_file', listfile.selectedFiles[0]);
		uploadData.append('requirement_id', listfile.reqfile);

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

				if (response_data) {
					response_data.forEach(function (result) {
						if (result.code == 200) {
							counter++;
							if (counter == filecontainer.length) {
								console.log(counter);
								ReSubmitApplication(application_id);
							}
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
	});
}

function SendEmail(subject, is_approved) {

	var con_name = document.getElementById("con_name").innerText;
	var con_address = document.getElementById("con_address").innerText;
	var tenant = document.getElementById("applicant_name").innerText;
	var tenant_email = document.getElementById("tenant_email").innerText;
	var owner = document.getElementById("owner").innerText;
	var owner_email = document.getElementById("owner_email").innerText;

	$.ajax({
		url: "../controller/php/shared/emailcontroller.php",
		method: "POST",
		data: {
			"email": "sent_email_application",
			"tenant": tenant,
			"tenant_email": tenant_email,
			"owner": owner,
			"owner_email": owner_email,
			"conName": con_name,
			"conAddress": con_address,
			"meetdate": "March 10, 2024",
			"meettime": "10:00 AM",
			"office_address": "Test",
			"emailSubject": subject,
			"is_approved": is_approved,
		},
		success: function (data) {
			// var response = data[0];
			// var response_data = response.request_data;
			// var response_status = response.request_status;

			// if (response_data) {
			// 	response_data.forEach(function (result) {
			// 		if (result.code == 200) {
			// 			$("#ViewApplication").modal('hide');
			// 			$("#ActionApplication").modal('hide');

			// 			swal.fire({
			// 				text: "Application Updated.",
			// 				icon: "success",
			// 				buttonsStyling: false,
			// 				showConfirmButton: false,
			// 				timer: 1500
			// 			}).then(function () {
			// 				$("#kt_datatable").DataTable().ajax.reload();
			// 			});
			// 		}
			// 	});
			// }
			console.log(data);
			// console.log(response_status);

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

function RenewLeaseApplication() {
	var applicationData = new FormData();
	var space_id = document.getElementById("contract_space_id").innerText;
	var con_id = document.getElementById("contract_con_id").innerText;
	var leaseTerms = document.getElementById("lease_terms").innerText;

	applicationData.append('space_action', 'submit_application');
	applicationData.append('con_id', con_id);
	applicationData.append('space_id', space_id);
	applicationData.append('leaseTerms', leaseTerms);
	applicationData.append('applicant_remarks', 'Renewal Application');
	applicationData.append('application_type', 1);

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

						$("#ViewContract").modal('hide');

						swal.fire({
							text: "Renewal Submit.",
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
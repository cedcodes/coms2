

"use strict";
var KTDatatablesAdvancedColumnRendering = function() {

	var init = function() {
		var table = $('#kt_datatable');
        var userType;
        // $.ajax({
        //     url:"../controller/php/bill-summary.php",
        //     method:"POST",
        //     data:{
        //         "viewprevbilling": 'viewprevbilling',
        //         'space_id' :1
        //     },
        //     success:function(data){	
        //         console.log(data,'gy')
        //         var json = JSON.parse(data);
        //         var jData = json.data.data
        //         console.log(jData)
        //     },
        // })
        

        $.ajax({
        url:"../controller/php/login.php",
        method:"POST",
        data:{
            "userTypeAccess": 'access'
        },
        success:function(data){	
            var json = JSON.parse(data);
            userType= json.user_type;
            console.log(userType,'userType')
            if(userType == 'Tenant'){
                $("#btnCreateAccountantAcc").addClass("d-none");
                $("#btnCreateBillSetup").addClass("d-none");
                $("#txt_AccountNumber").prop('disabled', true);
                $(".row_uploadQR").addClass("d-none");
                $("#btnQRSaveChanges").addClass("d-none");
                $("#btnManagePayment").attr('value', 'Scan QR'); 
            }
            else if(userType == 'Accountant'){
                $(".col_upload").addClass("d-none");
                $("#btnUploadSaveChanges").addClass("d-none");
                $("#btnManagePayment").attr('value', 'QR Setup'); 
                $("#btnCreateAccountantAcc").addClass("d-none");
            }
            else{
                $(".col_upload").addClass("d-none");
                $("#btnUploadSaveChanges").addClass("d-none");
                $("#btnManagePayment").attr('value', 'QR Setup'); 
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

		// begin first table
		table.DataTable({
			responsive: true,
			paging: true,
            ajax: {
				url: "../controller/php/bill-summary.php",
				method: "POST",
				data: {
					"viewbillsummary": "viewbillsummary"
				},
                
				dataSrc: function (data) {

                    console.log(data)
					// var response = data[0];
					// var response_data = response.request_data;
					// console.log(response_data,'Here');
                    var json = data
                    var jData = json.data.data
                    console.log(data)
					return jData;
				}
			},
            columns:
				[
                    { "data": "space_name" },
					{ "data": "tenant_name" },
					// { "data": "due_date" },
					{ "data": "total" },
					// { "data": "payment_status" },
					{ "data": "space_id" }
				],
                columnDefs: [
                    {
                        targets: -1,
                        title: 'Actions',
                        orderable: false,
                        render: function (data, type, full, meta) {
                            var viewPrevious = "viewPrevious('" + data + "')";
                            
                            var ActionButtons = '\
                                                    <button class="btn btn-sm btn-clean btn-icon" onclick="' + viewPrevious + '" title="View Previous">\
                                                        <i class="la la-sitemap"></i>\
                                                    </button>\
                                                ';
                            // if(userType == 'Tenant'){
                            //     ActionButtons='';
                            // }
                            return ActionButtons;
                        }
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

    var _handleBillingForm = function(e) {
        $.ajax({
            url:"../controller/php/bill-summary.php",
            method:"POST",
            data:{
                "billamount": 'billamount'
            },
            success:function(data){	
                console.log(data);
                var json = JSON.parse(data);
                var jData = json.data.data[0]


                if(json.success){
                    $('#txtElectricAmount').val(jData.txtElectricAmount)
                    $('#txtWaterAmount').val(jData.txtWaterAmount)
                    $('#txtProvPricePerMeter').val(jData.txtProvPricePerMeter)
                    $('#txtMNLPricePerMeter').val(jData.txtMNLPricePerMeter)
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



        $('#btnBillingSaveChanges').on('click', function (e) {
            e.preventDefault();

            var newElectricAmount= $('#txtElectricAmount').val() == '' ? 0 : $('#txtElectricAmount').val()
            var newWaterAmount = $('#txtWaterAmount').val() == '' ? 0 : $('#txtWaterAmount').val() 
            var newProvSpacePrice = $('#txtProvPricePerMeter').val() == '' ? 0 : $('#txtProvPricePerMeter').val()
            var newMnlSpacePrice = $('#txtMNLPricePerMeter').val() == '' ? 0 : $('#txtMNLPricePerMeter').val()

            $.ajax({
                url:"../controller/php/bill-summary.php",
                method:"POST",
                data:{
                    "saveNewBilling": 'saveNewBilling',
                    "newElectricAmount": newElectricAmount,
                    "newWaterAmount": newWaterAmount,
                    "newProvSpacePrice": newProvSpacePrice,
                    "newMnlSpacePrice": newMnlSpacePrice,
                },
                success:function(data){	
                    console.log(data);
                    var json = JSON.parse(data);

                    console.log(json);
                    var _islogin= json.success;
                    var err_mess= json.message;
                    var err_status= json.err_status;
                    
                    if (_islogin){
                        swal.fire({
                            text: "All is cool! " + err_mess,
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            confirmButtonClass: "btn font-weight-bold btn-light-primary"
                        }).then(function() {
                            billsummaryform();
                        });
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
    
        })
    }

	var _handleSignUpForm = function(e) {
        var validation;
        var form = KTUtil.getById('kt_login_signup_form');
       
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        validation = FormValidation.formValidation(
			form,
			{
				fields: {
					firstname: {
						validators: {
							notEmpty: {
								message: 'First name is required'
							}
						}
					},
                    lastname: {
						validators: {
							notEmpty: {
								message: 'Last name is required'
							}
						}
					},
                    username: {
						validators: {
							notEmpty: {
								message: 'Username is required'
							},
                            stringLength: {
                                min: 3,
                                message: 'Your username must be 3 characters long at least',
                            },
						}
					},
					email: {
                        validators: {
							notEmpty: {
								message: 'Email address is required'
							},
                            emailAddress: {
								message: 'The value is not a valid email address'
							}
						}
					},
                    password: {
                        validators: {
                            notEmpty: {
                                message: 'The password is required'
                            }
                        }
                    },
                    cpassword: {
                        validators: {
                            notEmpty: {
                                message: 'The password confirmation is required'
                            },
                            identical: {
                                compare: function() {
                                    return form.querySelector('[name="password"]').value;
                                },
                                message: 'The password and its confirm are not the same'
                            }
                        }
                    }
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		);

        $('#kt_login_signup_submit').on('click', function (e) {
            e.preventDefault();

            var susername   = $("#susername").val();
            var spassword   = $("#spassword").val();
            var sfirstname  = $("#sfirstname").val();
            var slastname   = $("#slastname").val();
            var semail      = $("#semail").val();
            var birthday    = $("#birthday").val();
            var usertype    = $("input[type='radio'][name='usertype']:checked").val();
            var validate_birthday = $("#validate_birthdate").val();

            console.log(
                susername  
                ,spassword  
                ,sfirstname 
                ,slastname  
                ,semail     
                ,birthday   
                ,usertype  
                ,validate_birthday 
            );

            validation.validate().then(function(status) {
                if(status=='Valid'){
                    $.ajax({
                        url:"/new-coms/controller/php/accountant_account.php",
                        method:"POST",
                        data:{
                            "susername"   : susername,
                            "spassword" : spassword,
                            "sfirstname" : sfirstname,
                            "slastname"  : slastname,
                            "semail"     : semail,
                            "birthday"   : birthday,
                            "susertype"   : usertype,
                            "create_accountant": 'create_accountant',
                        },
                        success:function(data){	
                            
                            console.log(data);
                            var json = JSON.parse(data);
    
                            console.log(json);
                            var _islogin= json.success;
                            var err_mess= json.message;
                            var err_status= json.err_status;
                            console.log(status);	
                            console.log(_islogin);
                            
                            if (validate_birthday=='below_18'){
                                status='Invalid'
                                err_mess= "We''re sorry, but you must be at least 18 years old to register.";
                                swal.fire({
                                    text: err_mess,
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    confirmButtonClass: "btn font-weight-bold btn-light"
                                }).then(function() {});
                            }else{
                                if (status == 'Valid' && _islogin) {
                                    swal.fire({
                                        text: "All is cool! " + err_mess,
                                        icon: "success",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        confirmButtonClass: "btn font-weight-bold btn-light-primary"
                                    }).then(function() {
										billsummaryform();
                                    });
                                }
                                else{
                                    swal.fire({
                                        text: err_mess,
                                        icon: "error",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        confirmButtonClass: "btn font-weight-bold btn-light"
                                    }).then(function() {
                                        KTUtil.scrollTop();
                                    });   
                                }
                            }
                             
                        },
                        error:function(data){
                            console.log(data);
    
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
                }else{
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
		    });
        });

        // Handle cancel button
        $('#kt_login_signup_cancel').on('click', function (e) {
            e.preventDefault();
			billsummaryform();
        });

		function billsummaryform(){
			$(".create-accountant-form").addClass("d-none");
			$(".bill-summary-form").removeClass("d-none");
			$(".card-label").text("Bills")	
		}

     

		$('#btnCreateAccountantAcc').on('click', function (e) {
            e.preventDefault();
			$(".create-accountant-form").removeClass("d-none");
			$(".bill-summary-form").addClass("d-none");
			$(".card-label").text("Account")
        });
    }

	return {

		//main function to initiate the module
		init: function() {
			init();
			
			$(".create-accountant-form").addClass("d-none");
            _handleSignUpForm();
            _handleBillingForm();
		}
	};
}();

jQuery(document).ready(function() {
	KTDatatablesAdvancedColumnRendering.init();
});

var ClickedSpaceID
function viewPrevious(space_id){
    $("#mdViewPrevBillings").modal('show')
    ClickedSpaceID=space_id;
    var table2 = $('#kt_PrevBilling');  
    var userType;

    $.ajax({
        url:"../controller/php/login.php",
        method:"POST",
        data:{
            "userTypeAccess": 'access'
        },
        success:function(data){	
            var json = JSON.parse(data);
            userType= json.user_type;
            console.log(userType,'userType')
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
                    var uploadPayment = "uploadPayment('" + data + "')";
                    var updateBilling = "updateBilling('" + data + "')";
                    
                    var hidebtn;
                     if(userType == 'Tenant'){
                        hidebtn='d-none';
                    }

                    console.log(hidebtn,'hidebtn')

                    var ActionButtons = '\
                                            <button class="btn btn-sm btn-clean btn-icon" onclick="' + uploadPayment + '" title="Upload Payment Receipt">\
                                                <i class="la la-sitemap"></i>\
                                            </button>\
                                            \
                                                <button class="btn btn-sm btn-clean btn-icon '+hidebtn+'" onclick="' + updateBilling + '" title="Update Billing">\
                                                    <i class="la la-edit '+hidebtn+'"></i>\
                                                </button>\
                                        ';
                   
                    return ActionButtons;
                }
            }
        ],
    });
}

var bill_id;


function uploadPayment(id){
    bill_id = id
    $("#mdUploadReceipt").modal('show')
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

            var img_data = jData.receipt_img;
            var img = img_data == '' || img_data === null ? 'IMG_ReceiptImage_65df67953ac22.png' :  img_data;
            $("#imgDisplayReceipt").attr("src","../assets/uploads/receipt/"+img)

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

function getQR(){
    $.ajax({
        url: "../controller/php/bill-summary.php",
        method: "POST",
        data: {
            "getQR": 'getQR'
        },
        success: function (data) {
            var json = JSON.parse(data);
            var jData = json.data.data[0]
            console.log(jData, 'getQR');

            var img_data = jData.payment_qr;
            var img = img_data == '' || img_data === null ? 'IMG_ReceiptImage_65df67953ac22.png' :  img_data;
            $("#imgDisplayQR").attr("src","../assets/uploads/receipt/"+img)
            $("#txt_AccountNumber").val(jData.account_no)
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

$("#receiptImage").change(function() {
    var ImgData = new FormData();

    var profileImage = $('#receiptImage').prop('files')[0];
    console.log(profileImage.name);
    $("#lblSelectedPhoto").text('Selected: '+ profileImage.name)
});

$("#QRImage").change(function() {
    var ImgData = new FormData();

    var profileImage = $('#QRImage').prop('files')[0];
    console.log(profileImage.name);
    $("#lblQRPhoto").text('Selected: '+ profileImage.name)
});


function fncUploadPhoto(){
    var ImgData = new FormData();

    var profileImage = $('#receiptImage').prop('files')[0];
    ImgData.append('profileSelectPhoto', 'profileSelectPhoto');
    ImgData.append('profileImage', profileImage);
    ImgData.append('bill_id', bill_id);

    console.log('profileImage',profileImage)

    $.ajax({
        url:"../controller/php/bill-summary.php",
        method:"POST",
        processData: false,
        contentType: false,
        data:ImgData,
        beforeSend: function(e)
        {
            $("#mdLoadingScreen").modal("show");
        }, 
        success:function(result){	
            $("#mdUploadReceipt").modal("hide");
            $("#mdLoadingScreen").modal("hide");
            console.log('hey', result)
            swal.fire({
                text: "All is cool! Receipt has been uploaded.",
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                confirmButtonClass: "btn font-weight-bold btn-light-primary"
            }).then(function() {
                uploadPayment(bill_id)
            });
        },
        error:function(result){
            $("#mdLoadingScreen").modal("hide");
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

$('#btnBillingSaveChanges2').on('click', function (e) {
    e.preventDefault();

    var txt_selectedAmount = $('#txt_selectedAmount').val()
    var txtPaymentStatus = $("#txtPaymentStatus").val()

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
                    viewPrevious(ClickedSpaceID)
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
var ClickedBill;
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

            // var img_data = jData.receipt_img;
            // var img = img_data == '' || img_data === null ? '' :  img_data;

            // if(img != ''){
            //     $("#row_uploadedphoto").removeClass('d-none')
            //     $("#imgDisplayReceipt").attr("src","../assets/uploads/receipt/"+img)
            // }else{
            //     $("#row_uploadedphoto").addClass('d-none')
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

function fncUploadQR(){
    var ImgData = new FormData();

    var account_no = $("#txt_AccountNumber").val()
    var QRImage = $('#QRImage').prop('files')[0];
    ImgData.append('QRUpload', 'QRUpload');
    ImgData.append('QRImage', QRImage);
    ImgData.append('account_no', account_no);


    console.log('QRImage',QRImage)

    $.ajax({
        url:"../controller/php/bill-summary.php",
        method:"POST",
        processData: false,
        contentType: false,
        data:ImgData,
        success:function(result){	
            console.log('hey', result)
            swal.fire({
                text: "All is cool! Your payment details has been uploaded.",
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: "Ok, got it!",
                confirmButtonClass: "btn font-weight-bold btn-light-primary"
            }).then(function() {
                getQR()
            });
        },
        error:function(result){
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

$('#btnUploadSaveChanges').on('click', function (e) {
    e.preventDefault();
    fncUploadPhoto()
})

$('#btnQRSaveChanges').on('click', function (e) {
    e.preventDefault();
    fncUploadQR()
})
//Page Loader
document.onreadystatechange = function () {
    if (document.readyState !== "complete") {
        $('#custom_preloader').delay(350).fadeIn('slow')
    } else {
        LoadAvailableMenu(3);
        $('#custom_preloader').delay(350).fadeOut('slow');
    }

    var validate_birthdate = "below_18";
    $("#validate_birthdate").val(validate_birthdate)

    function getAge(birthDateString) {
        var today = new Date();
        var birthDate = new Date(birthDateString);
        var age = today.getFullYear() - birthDate.getFullYear();
        var m = today.getMonth() - birthDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        console.log(age)
        return age;
      }
  
      $("#birthday").change(function(){
          // alert("The text has been changed.");
          var birthdate = $("#birthday").val()
          console.log(birthdate);
          
          if(getAge(birthdate) < 18) {
            validate_birthdate = "below_18"
            console.log("You are not 18 years old and above");
          } 
          else{
            validate_birthdate = "over_18"
          }
          $("#validate_birthdate").val(validate_birthdate)
          console.log(validate_birthdate)
      });
  

};


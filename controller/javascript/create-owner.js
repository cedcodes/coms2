var KTLoginGeneral = function() {
    var _login;

    var _showForm = function(form) {
        var cls = 'login-' + form + '-on';
        var form = 'kt_login_' + form + '_form';

        _login.removeClass('login-forgot-on');
        _login.removeClass('login-signin-on');
        _login.removeClass('login-signup-on');
        _login.removeClass('login-otp-on');

        _login.addClass(cls);

        console.log('cls', cls);
        
        KTUtil.animateClass(KTUtil.getById(form), 'animate__animated animate__backInUp');        
    }

    var _handleOTPForm = function() {
        var validation;
        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        validation = FormValidation.formValidation(
            KTUtil.getById('kt_otp_form'),
            {
                fields: {
                    otpcode: {
                        validators: {
                            notEmpty: {
                                message: 'OTP is required'
                            }
                        }
                    },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap()
                }
            }
        );

        $('#kt_otp_submit').on('click', function (e) {
            e.preventDefault();
            e.preventDefault();
            var otpcode = $("#otpcode").val();

            let searchParams = new URLSearchParams(window.location.search)
            var otpemail = searchParams.get('email')

            console.log(otpcode, otpemail);

            validation.validate().then(function(status) {
            var _islogin = false;
                $.ajax({
                    url:"new-coms/controller/php/login.php",
                    method:"POST",
                    data:{
                        "otpcode": otpcode,
                        "otpemail": otpemail,
                        "verify_otp": 'verify_otp',
                    },
                    success:function(data){	
                        console.log(data);
                        var json = JSON.parse(data);
                        _islogin= json.success;
                        _errmes= json.message;
                        _otpstatus= json.otpstatus;

                        console.log(status);	
                        console.log(_islogin);
                        
                        if(_otpstatus=="expired"){
                            $("#kt_otp_resend").removeClass("d-none");
                        }

                        if (status == 'Valid' && _islogin) {
                            swal.fire({
                                text: "All is cool! You are now registed. You may now login.",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                confirmButtonClass: "btn font-weight-bold btn-light-primary"
                            }).then(function() {
                                location.href="new-coms/index.php";
                            });
                        } else {
                            swal.fire({
                                text: _errmes,
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                confirmButtonClass: "btn font-weight-bold btn-light"
                            }).then(function() {
                                KTUtil.scrollTop();
                            });
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
                
            });
        });

        $('#kt_otp_resend').on('click', function (e) {
            e.preventDefault();

            let searchParams = new URLSearchParams(window.location.search)
            var otpemail = searchParams.get('email')

            console.log(otpemail);

            validation.validate().then(function(status) {
            var _islogin = false;
                $.ajax({
                    url:"new-coms/controller/php/login.php",
                    method:"POST",
                    data:{
                        "otpemail": otpemail,
                        "resend_otp": 'resend_otp',
                    },
                    success:function(data){	
                        console.log(data);
                        var json = JSON.parse(data);
                        _islogin= json.success;
                        _errmes= json.message;
                        _otpstatus= json.otpstatus;

                        console.log(status);	
                        console.log(_islogin);                       

                        if (_islogin) {
                            swal.fire({
                                text: "Success! New OTP has been sent to your email.",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                confirmButtonClass: "btn font-weight-bold btn-light-primary"
                            }).then(function() {
                                $("#kt_otp_resend").addClass("d-none");
                                
                            });
                        } else {
                            swal.fire({
                                text: _errmes,
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                confirmButtonClass: "btn font-weight-bold btn-light"
                            }).then(function() {
                                KTUtil.scrollTop();
                            });
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
                
            });
        });

       $('#kt_otp_cancel').on('click', function (e) {
            e.preventDefault();
            location.href="new-coms/index.php";
        });
    }

    var _handleSignInForm = function() {
        var validation;

        // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
        validation = FormValidation.formValidation(
            KTUtil.getById('kt_login_signin_form'),
            {
                fields: {
                    username: {
                        validators: {
                            notEmpty: {
                                message: 'Username is required'
                            }
                        }
                    },
                    password: {
                        validators: {
                            notEmpty: {
                                message: 'Password is required'
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

        $('#kt_login_signin_submit').on('click', function (e) {
            e.preventDefault();
            var username = $("#username").val();
            var password = $("#password").val();

            console.log(username, password);

            validation.validate().then(function(status) {
            var _islogin = false;
                $.ajax({
                    url:"new-coms/controller/php/login.php",
                    method:"POST",
                    data:{
                        "username": username,
                        "password": password,
                        "login": 'login',
                    },
                    success:function(data){	
                        console.log(data);
                        var json = JSON.parse(data);
                        _islogin= json.success;
                        usertype= json.usertype
                        
                        err_status= json.is_verified
                        unverified= json.unverified
                        semail= json.email
                        console.log(status,usertype);	
                        console.log(_islogin,err_status);

                        if (status == 'Valid' && _islogin && err_status) {
                            swal.fire({
                                text: "All is cool! You are now logged in.",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                confirmButtonClass: "btn font-weight-bold btn-light-primary"
                            }).then(function() {
                                if(usertype=='Tenant'){
                                    location.href="new-coms/pages/concourse.php";
                                }
                                else{
                                    location.href="new-coms/pages/dashboard.php";
                                }
                            });
                        } 
                        else {
                            _errmes= json.message;
                            swal.fire({
                                text: _errmes,
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                confirmButtonClass: "btn font-weight-bold btn-light"
                            }).then(function() {
                                KTUtil.scrollTop();
                                if(unverified=='existing_email_unverified'){
                                    location.href="new-coms/index.php?sent=1&unverified=1&email=" + semail;
                                }
                            });
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
            });
        });

        // Handle forgot button
        $('#kt_login_forgot').on('click', function (e) {
            e.preventDefault();
            _showForm('forgot');
        });

        // Handle signup
        $('#kt_login_signup').on('click', function (e) {
            e.preventDefault();
            _showForm('signup');
        });

        $('#kt_login_otp').on('click', function (e) {
            e.preventDefault();
            _showForm('otp');
        });
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
                    },
                    agree: {
                        validators: {
                            notEmpty: {
                                message: 'You must accept the terms and conditions'
                            }
                        }
                    },
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
                        url:"new-coms/controller/php/login.php",
                        method:"POST",
                        data:{
                            "susername"   : susername,
                            "spassword" : spassword,
                            "sfirstname" : sfirstname,
                            "slastname"  : slastname,
                            "semail"     : semail,
                            "birthday"   : birthday,
                            "susertype"   : usertype,
                            "signup": 1,
                        },
                        success:function(data){	
                            
                            console.log(data);
                            var json = JSON.parse(data);
    
                            console.log(json);
                            _islogin= json.success;
                            err_mess= json.message;
                            err_status= json.err_status;
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
                                        text: "All is cool! Please login",
                                        icon: "success",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        confirmButtonClass: "btn font-weight-bold btn-light-primary"
                                    }).then(function() {
                                        location.href="new-coms/index.php";
                                        // _showForm('otp');
                                    });
                                } else {
                                    swal.fire({
                                        text: err_mess,
                                        icon: "error",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        confirmButtonClass: "btn font-weight-bold btn-light"
                                    }).then(function() {
                                        KTUtil.scrollTop();
                                        if(err_status=='existing_email_unverified'){
                                            location.href="new-coms/index.php?sent=1&unverified=1&email=" + semail;
                                        }
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

            _showForm('signin');
        });
    }

    return {
        // public functions
        init: function() {
            _login = $('#kt_login');

            _handleSignInForm();
            _handleSignUpForm();
            _handleOTPForm();
            
            let searchParams = new URLSearchParams(window.location.search)
            _isotpunver = searchParams.has('unverified')
            _isotpsent = searchParams.has('sent')
            
            if(_isotpunver){
                $("#kt_otp_resend").click();
            }
            if(_isotpsent){
                _showForm('otp');
            }
           
            validate_birthdate = "below_18";
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
                  var validate_birthdate
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
        }
    };
}();

jQuery(document).ready(function() {
    KTLoginGeneral.init(); 
});


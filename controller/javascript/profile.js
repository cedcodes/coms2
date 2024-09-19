document.onreadystatechange = function () {
    if (document.readyState !== "complete") {
        $('#custom_preloader').delay(100).fadeIn('slow')
    } else {
        LoadAvailableMenu(3);
        $('#custom_preloader').delay(100).fadeOut('slow');
    }

    $.ajax({
        url:"../controller/php/profile.php",
        method:"POST",
        data:{
            "profileview": 'profileview'
        },
        success:function(data){	
            // alert('hey')
            var json = JSON.parse(data);
            var jData = json.data.data[0]
    
            console.log(json.data.data,'hey');

            var img = jData.profile_img == '' || jData.profile_img === null ? 'IMG_ProfileImage_65dc0d6fb04e4.jpeg' :  jData.profile_img;
    
            $('#txtUserType').text(jData.usertype)
            $('#txtUserName').text(jData.username)
            $('#txtTitleUsername').text(jData.username)
            $('#txtEmail').text(jData.email)
            $('#Phone').text(jData.contact_no)
            $('#DateCreated').text(jData.date_added)
            $('#txtFullName').text(jData.first_name+' '+jData.last_name)
            $('#txtAddress').text(jData.address)
            $('#txtGender').text(jData.gender)
            $('#txtBirthday').text(jData.birthdate)
          
    
            $('#txtUserType').val(jData.usertype)
            $('#txtUserName').val(jData.username)
            $('#txtTitleUsername').val(jData.username)
            $('#txtEmail').val(jData.email)
            $('#Phone').val(jData.contact_no)
            $('#DateCreated').val(jData.date_added)
            $('#txtFirstName').val(jData.first_name)
            $('#txtLastName').val(jData.last_name)
            $('#txtAddress').val(jData.address)
            $('#selGender').val(jData.gender).change();
            $('#txtBirthday').val(jData.birthdate)
            $("#img_profile").attr("src","../assets/uploads/user/"+img)
        },
        error:function(data){
            // alert('huy')
    
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
    
};

$("#btnProfSaveChanges" ).on("click", function(e) {
    e.preventDefault();
    fncChangePhoto()
    fncProfileSaveChanges()
} );

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

  function validateEmail($email) {
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    return emailReg.test( $email );
  }

function fncProfileSaveChanges()
{
    var birthdate = $("#txtBirthday").val()
    var email = $('#txtEmail').val()

    var validate_birthdate
    console.log(birthdate);
    if(getAge(birthdate) < 18) {
      validate_birthdate = "below_18"
      console.log("You are not 18 years old and above");

        swal.fire({
            text: "We''re sorry, but you must be at least 18 years old.",
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "Ok, got it!",
            confirmButtonClass: "btn font-weight-bold btn-light"
        }).then(function() {
            KTUtil.scrollTop();
        });
    } 
    else if( !validateEmail(email)) { 
        swal.fire({
            text: "We''re sorry, but you must enter a valid email address.",
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "Ok, got it!",
            confirmButtonClass: "btn font-weight-bold btn-light"
        }).then(function() {
            KTUtil.scrollTop();
        });
     }
    else{
      validate_birthdate = "over_18"

    var username     = $('#txtUserName').val()
    var contact_no   = $('#Phone').val()
    var date_added   = $('#DateCreated').val()
    var first_name   = $('#txtFirstName').val()
    var last_name    = $('#txtLastName').val()
    var address      = $('#txtAddress').val()
    var gender       = $('#selGender').val();
    var birthdate    = $('#txtBirthday').val()
        $.ajax({
            url:"../controller/php/profile.php",
            method:"POST",
            data:{
                "profilesavechanges": 'profilesavechanges',
                "username"    : username  ,  
                "email"       : email       ,
                "contact_no"  : contact_no  ,
                "date_added"  : date_added  ,
                "first_name"  : first_name  ,
                "last_name"   : last_name   ,
                "address"     : address     ,
                "gender"      : gender      ,
                "birthdate"   : birthdate   
            },
            success:function(result){	
                console.log('hey', result)

                var json = JSON.parse(result);
                var _errmes= json.message;

                swal.fire({
                    text: "All is cool! " + _errmes,
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    confirmButtonClass: "btn font-weight-bold btn-light-primary"
                }).then(function() {
                    window.location="profile.php"
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
}

// $("#btnChangePhoto" ).on("click", function() {
//     fncChangePhoto()
// } );

function fncChangePhoto(){
    var ImgData = new FormData();

    var profileImage = $('#profileImage').prop('files')[0];
    ImgData.append('profileChangePhoto', 'profileChangePhoto');
    ImgData.append('profileImage', profileImage);

    console.log('profileImage',profileImage)

    $.ajax({
        url:"../controller/php/profile.php",
        method:"POST",
        processData: false,
        contentType: false,
        data:ImgData,
        success:function(result){	
            console.log('hey', result)

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


ApprovalTenant();

function ApprovalTenant() {

    $.ajax({
        url:"../controller/php/contract.php",
        method:"POST",
        data:{
            "AddContract": 'AddContract',
            "concourse_id": '1',
            "space_id": '1',
            "tenant_id" : '1',
            "approval_status": 'dissaproved'
        },
        success:function(data){	
            // var json = JSON.parse(data);
            console.log(data,'test contract')
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
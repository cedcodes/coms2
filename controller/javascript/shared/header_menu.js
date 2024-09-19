
function LoadAvailableMenu(ActivePage){
    const menu = [];
    const submenu = [];

    var activePageClass = "menu-item-rel menu-item-open menu-item-here";

    
    //HTML Menu
    var dashboard = ActivePage == 1 ?
                    '<li class="menu-item '+ activePageClass +'" aria-haspopup="true">' +
                        '<a href="dashboard.php" class="menu-link">' +
                            '<span class="menu-text">Dashboard</span>' +
                        '</a>' +
                    '</li>' 
                    :
                    '<li class="menu-item menu-item-rel" aria-haspopup="true">' +
                        '<a href="dashboard.php" class="menu-link">' +
                            '<span class="menu-text">Dashboard</span>' +
                        '</a>' +
                    '</li>' ;
    
    var concourse = ActivePage == 2 ?
                    '<li class="menu-item menu-item-submenu '+ activePageClass +'" data-menu-toggle="click" aria-haspopup="true">' +
                        '<a href="javascript:;" class="menu-link menu-toggle">' +
                            '<span class="menu-text">Concourse</span>' +
                            '<span class="menu-desc"></span>' +
                            '<i class="menu-arrow"></i>' +
                        '</a>' +
                        '<div class="menu-submenu menu-submenu-classic menu-submenu-left">' +
                            '<ul class="menu-subnav" id="menu-sub-concourse"></ul>' +
                        '</div>' +
                    '</li> '
                    :
                    '<li class="menu-item menu-item-submenu menu-item-rel" data-menu-toggle="click" aria-haspopup="true">' +
                        '<a href="javascript:;" class="menu-link menu-toggle">' +
                            '<span class="menu-text">Concourse</span>' +
                            '<span class="menu-desc"></span>' +
                            '<i class="menu-arrow"></i>' +
                        '</a>' +
                        '<div class="menu-submenu menu-submenu-classic menu-submenu-left">' +
                            '<ul class="menu-subnav" id="menu-sub-concourse"></ul>' +
                        '</div>' +
                    '</li> ';

    var utility = ActivePage == 3 ?
                    '<li class="menu-item menu-item-submenu '+ activePageClass +'" data-menu-toggle="click" aria-haspopup="true">' +
                       '<a href="javascript:;" class="menu-link menu-toggle">' +
                           '<span class="menu-text">Utility</span>' +
                           '<span class="menu-desc"></span>' +
                           '<i class="menu-arrow"></i>' +
                       '</a>' +
                       '<div class="menu-submenu menu-submenu-classic menu-submenu-left">' +
                           '<ul class="menu-subnav" id="menu-sub-utility"></ul>' +
                       '</div>' +
                   '</li>'
                   :
                   '<li class="menu-item menu-item-submenu  menu-item-rel" data-menu-toggle="click" aria-haspopup="true">' +
                       '<a href="javascript:;" class="menu-link menu-toggle">' +
                           '<span class="menu-text">Utility</span>' +
                           '<span class="menu-desc"></span>' +
                           '<i class="menu-arrow"></i>' +
                       '</a>' +
                       '<div class="menu-submenu menu-submenu-classic menu-submenu-left">' +
                           '<ul class="menu-subnav" id="menu-sub-utility"></ul>' +
                       '</div>' +
                   '</li>';

    var con_lstConcourse = 'sub_con@' + 
                        '<li class="menu-item" aria-haspopup="true">' +
                            '<a href="concourse.php" class="menu-link">' +
                                '<i class="flaticon2-map text-danger icon-lg menu-icon"></i>' +
                                '<span class="menu-text">List of Concourse</span>' +
                            '</a>' +
                        '</li>';


    var con_lstTenant = 'sub_con@' + 
                        '<li class="menu-item" aria-haspopup="true">' +
                            '<a href="tenant.php" class="menu-link">' +
                                '<i class="flaticon2-avatar text-danger icon-lg menu-icon"></i>' +
                                '<span class="menu-text">List of Tenants</span>' +
                            '</a>' +
                        '</li>';

    
    var con_spaceApplication = 'sub_con@' + 
                                '<li class="menu-item" aria-haspopup="true">' +
                                    '<a href="space-application.php" class="menu-link">' +
                                        '<i class="flaticon2-mail-1 text-danger icon-lg menu-icon"></i>' +
                                        '<span class="menu-text">Space Applications</span>' +
                                    '</a>' +
                                '</li>';


    var ut_billSummary = 'sub_ut@' + 
                        '<li class="menu-item" aria-haspopup="true">' +
                          '<a href="bill-summary.php" class="menu-link">' +
                              '<i class="flaticon-notepad text-danger icon-lg menu-icon"></i>' +
                              '<span class="menu-text">Bills summary</span>' +
                          '</a>' +
                      '</li>'; 

    var ut_requirementsList = 'sub_ut@' + 
                      '<li class="menu-item" aria-haspopup="true">' +
                        '<a href="requirements.php" class="menu-link">' +
                            '<i class="flaticon-attachment text-danger icon-lg menu-icon"></i>' +
                            '<span class="menu-text">Requirement List</span>' +
                        '</a>' +
                    '</li>';

    $.ajax({
        url:"../controller/php/login.php",
        method:"POST",
        data:{
            "userTypeAccess": 'access'
        },
        success:function(data){	
            var json = JSON.parse(data);
            var userType= json.user_type;
            if(userType == 'Tenant'){
                dashboard='';
                ut_requirementsList = '';
                con_lstTenant = '';
                
            console.log(userType)
            console.log('dashboard',dashboard)
            }
            if (userType == 'Accountant'){
                ut_requirementsList = '';
            }


            menu.push(dashboard, concourse, utility);
            submenu.push(con_lstConcourse, con_lstTenant, con_spaceApplication, ut_billSummary, ut_requirementsList);
        
            let i = 0
            while(i < menu.length){
                // console.log(menu[i]);
                
                $('#menu-nav').append(menu[i]);
                i++;
            }
        
            let j = 0;
            while(j < submenu.length){
                var navcode = submenu[j].split('@')[0];
                
                if(navcode == 'sub_con'){
                    $('#menu-sub-concourse').append(submenu[j].split('@')[1]);
                }
                else if(navcode == 'sub_ut'){
                    $('#menu-sub-utility').append(submenu[j].split('@')[1]);
                }
        
                j++;
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
            var img = jData.profile_img == '' || jData.profile_img === null ? 'IMG_ProfileImage_65dc0d6fb04e4.jpeg' :  jData.profile_img;
            console.log(json.data.data,'hey');
            $('#NavFullName').text(jData.first_name+' '+jData.last_name)
            $("#NavProfilePhoto").attr("src","../assets/uploads/user/"+img)
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
                    
    // menu.push(dashboard, concourse, utility);
    //         submenu.push(con_lstConcourse, con_lstTenant, con_spaceApplication, ut_billSummary);
        
    //         let i = 0
    //         while(i < menu.length){
    //             // console.log(menu[i]);
                
    //             $('#menu-nav').append(menu[i]);
    //             i++;
    //         }
        
        
    //         let j = 0;
    //         while(j < submenu.length){
    //             var navcode = submenu[j].split('@')[0];
                
    //             if(navcode == 'sub_con'){
    //                 $('#menu-sub-concourse').append(submenu[j].split('@')[1]);
    //             }
    //             else if(navcode == 'sub_ut'){
    //                 $('#menu-sub-utility').append(submenu[j].split('@')[1]);
    //             }
        
    //             j++;
    //         }
}

function SignOut(){
    $.ajax({
        url:"../controller/php/login.php",
        method:"POST",
        data:{
            "signout": 'signout'
        },
        success:function(data){	
            // alert('Logout')
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

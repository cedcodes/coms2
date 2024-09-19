$(document).ready(function () {
    // alert("notif Connected");
    GetNotification();
});

function GetNotification() {

    

    $.ajax({
        url: "../controller/php/shared/notificationcontroller.php",
        method: "POST",
        data: {
            "notif": 'retrieve_notif',
        },
        success: function (data) {
            var response = data[0];
            var notifData = response.notifData;
            var statusResponse = response.notifResponse;

            console.log(notifData);
            console.log(statusResponse);
            var notifparent = document.getElementById("notif-parent");
            var notifchild = document.getElementById("notif-child");
            
            notifparent.removeChild(notifchild);

            var notifdivchild = '<div id="notif-child">' +
                '<div id="btnReadAll"></div>' +
                '<div class="navi navi-icon-circle navi-spacer-x-0">' +
                '<div id="notifdata">' +
                '<div id="notifdata-unread"></div>' +
                '<div id="notifdata-read"></div>' +
                '</div>' +
                '</div>' +
                '</div>';
            $('#notif-parent').append(notifdivchild);

            

            if (statusResponse.length != 0) {
                if (statusResponse[0].status_code == 200) {

                    // console.log(statusResponse[0].status_message);
                    var isReadCount = 0;
                    if (notifData.length != 0) {

                        for (var i = 0; i < notifData.length; i++) {
                            isReadCount = notifData[i].isRead == 0 ? isReadCount + 1 : isReadCount;

                            var notifLogo = notifData[i].notifType == 1 ? '<i class="flaticon2-send text-primary icon-lg"></i>' :
                                (notifData[i].notifType == 2 ? '<i class="flaticon2-check-mark text-warning icon-lg"></i>' :
                                    (notifData[i].notifType == 3 ? '<i class="flaticon2-delete text-danger icon-lg"></i>' : 
                                    (notifData[i].notifType == 4 ? '<i class="flaticon2-exclamation text-warning icon-lg"></i>' :
                                        '<i class="flaticon2-bell text-primary icon-lg"></i>')));

                            var isReadnotif = notifData[i].isRead == 1 ? '<div class="font-weight-light font-size-m">' + notifData[i].notifheader + '</div>' +
                                '<div class="text-muted font-size-xs">' + notifData[i].notifdetails + '</div>' :
                                '<div class="font-weight-bolder font-size-m" style="color:red!important">' + notifData[i].notifheader + '</div>' +
                                '<div class="text-muted font-weight-bold font-size-xs" style="color:black!important">' + notifData[i].notifdetails + '</div>';

                            var fncLink = "ViewNotification('" + notifData[i].id + "', '" + notifData[i].notifdetails + "', '" + notifData[i].notifheader + "')"

                            var notifDisplay = '<a href="javascript:;" onclick="' + fncLink + '" class="navi-item">' +
                                '<div class="navi-link rounded">' +
                                '<div class="symbol symbol-50 mr-3">' +
                                '<div class="symbol-label">' +
                                notifLogo +
                                '</div>' +
                                '</div>' +
                                '<div class="navi-text">' +
                                isReadnotif +
                                '</div>' +
                                '</div>' +
                                '</a>';

                            if (notifData[i].isRead == 1) {
                                $('#notifdata-read').append(notifDisplay);
                            }
                            else {
                                $('#notifdata-unread').append(notifDisplay);
                            }

                            // console.log(notifData[i].id, isReadCount);
                        }

                        var notifnumberparent = document.getElementById("notif-number-parent");
                        var notifnumberchild = document.getElementById("notif-number-child");
                        notifnumberparent.removeChild(notifnumberchild);

                        if (isReadCount > 0) {
                            var notifUnreadChild = '<div id="notif-number-child"></div>';
                            var notifUnreadCount = '<div class="notif-number"> <span id="newnotif">' + isReadCount + '</span> </div>';

                            var ReadAllBtn = '<div class="d-flex flex-column pb-5">' +
                                '<button class="btn btn-primary mb-5" onclick="MarkAllAsRead()" style="width:100%!important">' +
                                '<i class="flaticon-envelope icon-m"></i><span class="ml-3">Mark all as read</span>' +
                                '</button>' +
                                '<button class="btn btn-danger mb-5" onclick="RemoveAllNotif()" style="width:100%!important">' +
                                '<i class="flaticon-delete text-color-white icon-m"></i><span class="ml-3">Clear all</span>' +
                                '</button>' +
                                '</div>';

                            $('#btnReadAll').append(ReadAllBtn);

                            $('#notif-number-parent').append(notifUnreadChild);
                            $('#notif-number-child').append(notifUnreadCount);
                        }
                        else {
                            var ReadAllBtn = '<div class="d-flex flex-column pb-5">' +
                                '<button class="btn btn-danger mb-5" onclick="RemoveAllNotif()" style="width:100%!important">' +
                                '<i class="flaticon-delete text-color-white icon-m"></i><span class="ml-3">Clear all</span>' +
                                '</button>' +
                                '</div>';

                            $('#btnReadAll').append(ReadAllBtn);

                            var notifUnreadChild = '<div id="notif-number-child"></div>';
                            $('#notif-number-parent').append(notifUnreadChild);
                        }



                    }

                }
                else {

                    var NoRecord = '<span class="navi-item">' +
                        '<div class="rounded">' +
                        '<div class="navi-text">' +
                        '<div class="font-weight-bolder text-muted font-size-xl"> No Notification Right Now! </div>' +
                        '</div>' +
                        '</div>' +
                        '</a>';

                        var notifnumberparent = document.getElementById("notif-number-parent");
                        var notifnumberchild = document.getElementById("notif-number-child");
                        notifnumberparent.removeChild(notifnumberchild);
                    $('#notifdata').append(NoRecord);
                    console.log(statusResponse[0].status_message);
                }
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
    })
}

function ViewNotification(notifid, notifdetails, notifheader) {
    $.ajax({
        url: "../controller/php/shared/notificationcontroller.php",
        method: "POST",
        data: {
            "notifID": notifid,
            "readType": "0",
            "notif": "read_notif",
        },
        success: function (data) {
            var response = data[0];
            var notifData = response.notifData;
            var statusResponse = response.notifResponse;

            GetNotification();

            Swal.fire({
                title: notifheader,
                text: notifdetails,
                showCloseButton: true,
                confirmButtonColor: "red",
                confirmButtonText: '<i class="flaticon-delete text-color-white icon-m"></i><span class="ml-3">Remove notification</span>'
            }).then((result) => {
                if (result.isConfirmed) {
                    RemoveNotification(notifid);
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
    })
}

function RemoveNotification(notifid) {
    $.ajax({
        url: "../controller/php/shared/notificationcontroller.php",
        method: "POST",
        data: {
            "notifID": notifid,
            "$removeType": "0",
            "notif": "remove_notif",
        },
        success: function (data) {
            var response = data[0];
            var notifData = response.notifData;
            var statusResponse = response.notifResponse;

            GetNotification();
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

function MarkAllAsRead() {
    $.ajax({
        url: "../controller/php/shared/notificationcontroller.php",
        method: "POST",
        data: {

            "readType": "1",
            "notif": "read_notif",
        },
        success: function (data) {
            var response = data[0];
            var notifData = response.notifData;
            var statusResponse = response.notifResponse;

            GetNotification();
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

function RemoveAllNotif() {
    $.ajax({
        url: "../controller/php/shared/notificationcontroller.php",
        method: "POST",
        data: {

            "$removeType": "1",
            "notif": "remove_notif",
        },
        success: function (data) {
            var response = data[0];
            var notifData = response.notifData;
            var statusResponse = response.notifResponse;

            GetNotification();
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
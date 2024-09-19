<!DOCTYPE html>
<html lang="en">

<head>
    <base href="">
    <meta charset="utf-8" />
    <title>COMS - Concourse</title>
    <?php include("shared/layout/top-layout.php") ?>
    <link href="../content/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
</head>
    <!--begin::Container-->
    <div class="d-flex flex-row flex-column-fluid container">
        <!--begin::Content Wrapper-->
        <div class="main d-flex flex-column flex-row-fluid">

            <!--begin::Subheader-->
            <div class="subheader py-2 py-lg-6" id="kt_subheader">
                <div class="w-100 d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
                    <!--begin::Info-->
                    <div class="d-flex align-items-center flex-wrap mr-1">
                        <!--begin::Page Heading-->
                        <div class="d-flex align-items-baseline flex-wrap mr-5">
                            <!--begin::Page Title-->
                            <h5 class="text-dark font-weight-bold my-1 mr-5">My Profile</h5>
                            <!--end::Page Title-->
                            <!--begin::Breadcrumb-->
                            <ul
                                class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                                <li class="breadcrumb-item">
                                    <a href="/new-coms/pages/account_settings.php" class="text-muted">Account Settings</a>
                                </li>
                            </ul>
                            <!--end::Breadcrumb-->
                        </div>
                        <!--end::Page Heading-->
                    </div>
                    <!--end::Info-->
                </div>
            </div>
            <!--end::Subheader-->

            <div class="content flex-column-fluid" id="kt_content">
                <!--begin::Card-->
                <div class="card card-custom" style="border-radius: 0px 0px 10px 10px!important">
                    <div class="card-header flex-wrap py-5">
                        <div class="card-title">
                            <h3 class="card-label">Profile</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row ">
                            <div class="col-4">
                                <div class="row">
                                    <div class="col d-flex justify-content-center">
                                    <img src="" id="img_profile" width="200px">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col d-flex justify-content-center">
                                        <p id="txtTitleUsername" class="h2"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col d-flex justify-content-center">
                                        <input type="button" class="btn btn-primary" value="Edit Profile" onclick="fncEditProfile()"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class='row p-1'>
                                    <div class="col-3 font-weight-bold">UserType: </div>
                                    <div class="col">
                                        <span id="txtUserType"></span>
                                    </div>
                                </div>
                                <div class='row p-1'>
                                    <div class="col-3 font-weight-bold">Username: </div>
                                    <div class="col">
                                        <span id="txtUserName"></span>
                                    </div>
                                </div>
                                <div class='row p-1'>
                                    <div class="col-3 font-weight-bold">Email: </div>
                                    <div class="col">
                                        <span id="txtEmail"></span>
                                    </div>
                                </div>
                                <div class='row p-1'>
                                    <div class="col-3 font-weight-bold">Phone: </div>
                                    <div class="col">
                                        <span id="Phone"></span>
                                    </div>
                                </div>
                                <div class='row p-1'>
                                    <div class="col-3 font-weight-bold">Date Created: </div>
                                    <div class="col">
                                        <span id="DateCreated"></span>
                                    </div>
                                </div>
                                <div class='row p-1'>
                                    <div class="col-3 font-weight-bold">Full Name: </div>
                                    <div class="col">
                                        <span id="txtFullName"></span>
                                    </div>
                                </div>
                                <div class='row p-1'>
                                    <div class="col-3 font-weight-bold">Address: </div>
                                    <div class="col">
                                        <span id="txtAddress"></span>
                                    </div>
                                </div>
                                <div class='row p-1'>
                                    <div class="col-3 font-weight-bold">Gender: </div>
                                    <div class="col">
                                        <span id="txtGender"></span>
                                    </div>
                                </div>
                                <div class='row p-1'>
                                    <div class="col-3 font-weight-bold">Birthday: </div>
                                    <div class="col">
                                        <span id="txtBirthday"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Card-->
            </div>
            <!--end::Content-->

        </div>
        <!--begin::Content Wrapper-->
    </div>
    <!--end::Container-->
    <!------------------------------------------------------------>
    <?php include("shared/layout/bottom-layout.php") ?>
    <!------------------------------------------------------------>

    <!--begin::Custom Scripts-->
    <script src="../content/plugins/custom/datatables/datatables.bundle.js"></script>
    <script src="/new-coms/controller/javascript/profile.js"></script>
    <!-- <script src="../content/js/pages/crud/datatables/advanced/column-rendering.js"></script> -->
    <!--end::Custom Scripts-->

</html>

<script>

    function fncEditProfile(){
        window.location.href = "/new-coms/pages/account_settings.php";
    }
    
</script>
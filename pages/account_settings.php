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
                            <h5 class="text-dark font-weight-bold my-1 mr-5">Account Settings</h5>
                            <!--end::Page Title-->
                            <!--begin::Breadcrumb-->
                            <ul
                                class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                                <li class="breadcrumb-item">
                                    <a href="/new-coms/pages/profile.php" class="text-muted">My Profile</a>
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
                            <h3 class="card-label">Account Settings</h3>
                        </div>
                    </div>
                    <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
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
                                        <input type="file" class="form-control-file" id="profileImage" name="profileImage" accept=".png, .jpg, .jpeg" style="display: none;">
                                        <label for="profileImage" class="btn btn-primary" id="btnChangePhoto">
                                            Change Photo
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class='row p-1'>
                                    <div class="col-3 font-weight-bold">Username: </div>
                                    <div class="col">
                                        <input id="txtUserName" class="form-control form-control-solid"></input>
                                    </div>
                                </div>
                                <div class='row p-1'>
                                    <div class="col-3 font-weight-bold">Email: </div>
                                    <div class="col">
                                        <input id="txtEmail" type="email" class="form-control form-control-solid"></input>
                                    </div>
                                </div>
                                <div class='row p-1'>
                                    <div class="col-3 font-weight-bold">Phone: </div>
                                    <div class="col">
                                        <input id="Phone" type="number" class="form-control form-control-solid"></input>
                                    </div>
                                </div>
                                <div class='row p-1'>
                                    <div class="col-3 font-weight-bold">First Name: </div>
                                    <div class="col">
                                        <input id="txtFirstName" class="form-control form-control-solid"></input>
                                    </div>
                                </div>
                                <div class='row p-1'>
                                    <div class="col-3 font-weight-bold">Last Name: </div>
                                    <div class="col">
                                        <input id="txtLastName" class="form-control form-control-solid"></input>
                                    </div>
                                </div>
                                <div class='row p-1'>
                                    <div class="col-3 font-weight-bold">Address: </div>
                                    <div class="col">
                                        <input id="txtAddress" class="form-control form-control-solid"></input>
                                    </div>
                                </div>
                                <div class='row p-1'>
                                    <div class="col-3 font-weight-bold">Gender: </div>
                                    <div class="col">
                                        <select id="selGender" class="form-control form-control-solid">
                                            <option value="Female">Female</option>
                                            <option value="Male">Male</option>
                                        </select>
                                    </div>
                                </div>
                                <div class='row p-1'>
                                    <div class="col-3 font-weight-bold">Birthday: </div>
                                    <div class="col">
                                        <input id="txtBirthday" type="date" class="form-control form-control-solid"></input>
                                    </div>
                                </div>
                                <div class='row pt-3'>
                                    <!-- <div class="col"></div> -->
                                    <div class="col d-flex justify-content-end">
                                        <input type="submit" class="btn btn-primary" value="Save Changes" id="btnProfSaveChanges"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
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

<style>
    .custom-file-upload{

    }
</style>
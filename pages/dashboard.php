<?php 
    session_name("user_session");
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header('Location: ../index.php'); 
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <base href="">
    <meta charset="utf-8" />
    <title>COMS - Dashboard</title>
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
                            <h5 class="text-dark font-weight-bold my-1 mr-5">Reports</h5>
                            <!--end::Page Title-->
                            <!--begin::Breadcrumb-->
                            <ul
                                class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                                <li class="breadcrumb-item">
                                    <a href="" class="text-muted">Dashboard</a>
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
                <!--begin::Dashboard-->
                <!--begin::Row-->
                <div class="row">
                    <div class="col-xl-4">
                        <!--begin::Mixed Widget 4-->
                        <div class="card card-custom bg-radial-gradient-danger gutter-b card-stretch">
                            <!--begin::Header-->
                            <div class="card-header border-0 py-5">
                                <h3 class="card-title font-weight-bolder text-white">Space Overview</h3>
                            </div>
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body d-flex flex-column p-0">
                                <!--begin::Stats-->
                                <div class="card-spacer bg-white card-rounded flex-grow-1">
                                    <!--begin::Row-->
                                    <div class="row m-0">
                                        <div class="col px-8 py-6 mr-8">
                                            <div class="font-size-sm text-muted font-weight-bold">Total Space</div>
                                            <div class="font-size-h4 font-weight-bolder">
                                                <span id="TotalSpace"></span>
                                            </div>
                                        </div>
                                        <div class="col px-8 py-6">
                                            <div class="font-size-sm text-muted font-weight-bold">Total Reserved Space
                                            </div>
                                            <div class="font-size-h4 font-weight-bolder"><span id="TotalReserved"></span></div>
                                        </div>
                                    </div>
                                    <!--end::Row-->
                                    <!--begin::Row-->
                                    <div class="row m-0">
                                        <div class="col px-8 py-6 mr-8">
                                            <div class="font-size-sm text-muted font-weight-bold">Total Occupied Space
                                            </div>
                                            <div class="font-size-h4 font-weight-bolder"><span id="TotalOccupied"></span></div>
                                        </div>
                                        <div class="col px-8 py-6">
                                            <div class="font-size-sm text-muted font-weight-bold">Total Available Space
                                            </div>
                                            <div class="font-size-h4 font-weight-bolder"><span id="TotalAvailable"></span></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col px-8 py-6 mr-8 text-muted font-size-lg font-weight-bold font-italic">
                                                <a click="" href="space-application.php" class="text-muted">View new applications
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"/>
                                                </svg></a>
                                        </div>
                                    </div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Stats-->
                            </div>
                            <!--end::Body-->
                        </div>
                        <!--end::Mixed Widget 4-->
                    </div>
                    <div class="col-xl-8">
                        <div class="row">
                            <div class="col-xl-4">
                                <!--begin::Tiles Widget 21-->
                                <div class="card card-custom gutter-b" style="height: 250px">
                                    <!--begin::Body-->
                                    <div class="card-body d-flex flex-column p-0">
                                        <!--begin::Stats-->
                                        <div class="flex-grow-1 card-spacer pb-0">
                                            <span class="svg-icon svg-icon-2x svg-icon-info">
                                                <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Group.svg-->
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                    height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <polygon points="0 0 24 0 24 24 0 24" />
                                                        <path
                                                            d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z"
                                                            fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                                        <path
                                                            d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z"
                                                            fill="#000000" fill-rule="nonzero" />
                                                    </g>
                                                </svg>
                                                <!--end::Svg Icon-->
                                            </span>
                                            <div class="font-weight-boldest font-size-h3 pt-2"><span id="NewApplication"></span></div>
                                            <div class="text-muted font-weight-bold">New Application</div>
                                        </div>
                                        <!--end::Stats-->
                                        
                                    </div>
                                    <!--end::Body-->
                                </div>
                                <!--end::Tiles Widget 21-->
                            </div>
                            <div class="col-xl-8">
                                <!--begin::Tiles Widget 25-->
                                <div class="card card-custom bgi-no-repeat bgi-size-cover gutter-b bg-primary"
                                    style="height: 250px; background-image: url(assets/media/svg/patterns/taieri.svg)">
                                    <div class="card-body d-flex">
                                        <div class="d-flex py-5 flex-column align-items-start flex-grow-1">
                                            <div class="flex-grow-1">
                                                <a href="concourse.php" class="text-white font-weight-bolder font-size-h3">Create
                                                    your Concourse now!</a>
                                                <p class="text-white opacity-75 font-weight-bold mt-3">Manage your
                                                    concourse and space now to earn more!</p>
                                            </div>
                                            <a href='concourse.php' class="btn btn-link btn-link-white font-weight-bold">Add
                                                Concourse
                                                <span class="svg-icon svg-icon-lg svg-icon-white">
                                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Arrow-right.svg-->
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                        height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none"
                                                            fill-rule="evenodd">
                                                            <polygon points="0 0 24 0 24 24 0 24" />
                                                            <rect fill="#000000" opacity="0.3"
                                                                transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)"
                                                                x="11" y="5" width="2" height="14" rx="1" />
                                                            <path
                                                                d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z"
                                                                fill="#000000" fill-rule="nonzero"
                                                                transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                                        </g>
                                                    </svg>
                                                    <!--end::Svg Icon-->
                                                </span></a>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Tiles Widget 25-->
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                <!--begin::Tiles Widget 23-->
                                <div class="card card-custom gutter-b" style="height: 250px">
                                    <!--begin::Body-->
                                    <div class="card-body d-flex flex-column p-0">
                                        <!--begin::Stats-->
                                        <div class="flex-grow-1 card-spacer pb-0">
                                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                                <div class="mr-2">
                                                    <a href="#" data-toggle="modal" data-target="#mdViewConBillings"
                                                        class="text-dark-75 text-hover-primary font-weight-bolder font-size-h2">Financial
                                                        Overview</a>
                                                </div>
                                                <div> 
                                                 <span class="font-weight-bolder font-size-h3 text-success" id="TotalBilling"></span>
                                                </div>                                                       
                                            </div>
                                            <div class="text-muted font-size-lg font-weight-bold font-italic">
                                                <a click="" href="#" class="text-muted" data-toggle="modal" data-target="#mdViewConBillings" >View Per Concourses</a>
                                            </div>
                                            <div class="mt-5">
                                                <p>Unpaid Security Deposit: Php <span id="lblunpaidSecDep"></span></p>
                                                <p>Unpaid Electricity: Php <span id="lblunpaidElectric"></span></p>
                                                <p>Unpaid Water: Php <span id="lblunpaidWater"></span></p>
                                                <p>Unpaid Rent: Php <span id="lblunpaidRent"></span></p>
                                               
                                            </div>
                                           
                                        </div>
                                        <!--end::Stats-->
                                        
                                    </div>
                                    <!--end::Body-->
                                </div>
                                <!--end::Tiles Widget 23-->
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Row-->
                <!--begin::Row-->
              
                <!--end::Row-->

                <!--end::Dashboard-->
            </div>
            <!--end::Content-->
        </div>
        <!--begin::Content Wrapper-->
    </div>
    <!--end::Container-->

    <div class="modal" id="mdViewConBillings" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document" >
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Concourse Billings</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" >
                <table class="table table-separate table-head-custom table-checkable" id="kt_ConBilling">
                    <thead>
                            <tr>
                                <th>Concourse</th>
                                <th>Bill Type</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>

    <?php include("shared/layout/bottom-layout.php") ?>

    <!--begin::Custom Scripts-->
    <script src="../content/js/pages/widgets.js"></script>
    <script src="../controller/javascript/dashboard.js"></script>
    <script src="../content/plugins/custom/datatables/datatables.bundle.js"></script>
    <!--end::Custom Scripts-->

</html>
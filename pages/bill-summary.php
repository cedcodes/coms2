<!DOCTYPE html>
<html lang="en">

<head>
    <base href="">
    <meta charset="utf-8" />
    <title>COMS - Concourse</title>
    <?php include("shared/layout/top-layout.php") ?>
    <link href="../content/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
    <!----------------------------------------------------------->

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
                            <h5 class="text-dark font-weight-bold my-1 mr-5">Bill Summary</h5>
                            <!--end::Page Title-->
                            <!--begin::Breadcrumb-->
                            <!-- <ul
                                class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                                <li class="breadcrumb-item">
                                    <a href="" class="text-muted">List of Bills</a>
                                </li>
                            </ul> -->
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
                            <h3 class="card-label">Bills</h3>
                        </div>
                    </div>
                    <div class="card-body ">
                  
                        <div class="create-accountant-form">
                            <div class="text-center mb-4 mb-lg-10 ">
                                <h3 class="font-size-h3">Create your accountant account</h3>
                                <p class="text-muted font-weight-bold">Enter details to create account</p>
                            </div>
                            <div class="d-flex justify-content-center">
                                <form class="form" novalidate="novalidate" id="kt_login_signup_form" style="width:70%">
                                    <div class="form-group">
                                        <input class="form-control form-control-solid h-auto py-5 px-6" type="text"
                                            placeholder="First Name" name="firstname" id="sfirstname" autocomplete="off" />
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control form-control-solid h-auto py-5 px-6" type="text"
                                            placeholder="Last Name" name="lastname" id="slastname"  autocomplete="off" />
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control form-control-solid h-auto py-5 px-6" type="username"
                                            placeholder="Username" name="username" id="susername"  autocomplete="off" />
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control form-control-solid h-auto py-5 px-6" type="email"
                                            placeholder="Email" name="email" id="semail" autocomplete="off" />
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control form-control-solid h-auto py-5 px-6" type="password"
                                            placeholder="Password" name="password" id="spassword" autocomplete="off" />
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control form-control-solid h-auto py-5 px-6" type="password"
                                            placeholder="Confirm password" name="cpassword" autocomplete="off" />
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control form-control-solid h-auto py-5 px-6" type="date"
                                            placeholder="Birthday" name="birthday" id="birthday" autocomplete="off" />
                                        <input type="hidden" name="validate_birthdate"  id="validate_birthdate">
                                    </div>
                                    <div class="form-group">
                                        <div class="d-flex flex-row">
                                            <span class="use-title font-weight-bold">User Type: </span>
                                            <input type="radio" value="Accountant" name="usertype" id="dot-1" class="ml-2 mb-2" checked required>
                                            <label for="dot-1"><span class="use mb-0 p-2"> Accountant </span><span></span></label>    
                                        </div>       
                                    </div>
                                    <div class="form-group d-flex flex-wrap flex-center">
                                        <button type="button" id="kt_login_signup_submit"
                                            class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-4">Submit</button>
                                        <button type="button" id="kt_login_signup_cancel"
                                            class="btn btn-light-primary font-weight-bold px-9 py-4 my-3 mx-4">Cancel</button>
                                    </div>
                                </form>
                            </div>
                            
                        </div>
                        <div class="bill-summary-form">
                            <input type="button" class="btn btn-primary mb-2" id="btnCreateAccountantAcc" value="Create Accountant"/>
                            <input type="button" class="btn btn-primary mb-2" id="btnCreateBillSetup" value="Manage Billing" data-toggle="modal" data-target="#mdBillingSetup"/>
                            <input type="button" class="btn btn-primary mb-2" id="btnManagePayment" value="Scan QR" data-toggle="modal" data-target="#mdQRSetup" onclick="getQR()"/>
                            <br/><br/>
                            <table class="table table-separate table-head-custom table-checkable" id="kt_datatable">
                                <thead>
                                    <tr>
                                        <th>Space Name</th>
                                        <th>Tenant Name</th>
                                        <!-- <th>Due Date</th> -->
                                        <th>Outstanding Amount</th>
                                        <!-- <th>Payment Status</th> -->
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <!-- <td></td> -->
                                        <!-- <td></td> -->
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!--end: Datatable-->
                    </div>
                </div>
                <!--end::Card-->
            </div>
            <!--end::Content-->

        </div>
        <!--begin::Content Wrapper-->
    </div>

    <div class="modal" id="mdViewPrevBillings" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document" >
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">All Billings</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" >
                <table class="table table-separate table-head-custom table-checkable" id="kt_PrevBilling"  >
                    <thead>
                            <tr>
                                <th>Bill ID</th>
                                <th>Tenant Name</th>
                                <th>Due Date</th>
                                <th>Bill Type</th>
                                <th>Amount</th>
                                <th>Penalty</th>
                                <th>Total</th>
                                <th>Payment Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
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

    <div class="modal" tabindex="-1" role="dialog" id="mdLoadingScreen" data-backdrop="static"  style="z-index:10000">
        <div class="modal-dialog modal-dialog-centered" role="document">      
            <div class="modal-content">
                <div class="modal-body">
                    <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                    Loading, please wait...
                </div>
            </div>   
        </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="mdBillingSetup">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Billing Setup</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body ">
            <div class="row">
                <div class="col"><label>Electricity (per kW)</label></div>
            </div>
            <div class="row">
                <div class="col"><input class="form-control form-control-small" type="number" id="txtElectricAmount"/></div>
            </div>
            <div class="row mt-2">
                <div class="col"><label>Water (per cbm)</label></div>
            </div>
            <div class="row">
                <div class="col"><input class="form-control form-control-small" type="number"  id="txtWaterAmount"/></div>
            </div>
            <div class="row mt-2">
                <div class="col"><label>Provincial Rate (per sqm)</label></div>
            </div>
            <div class="row">
                <div class="col"><input class="form-control form-control-small" type="number"  id="txtProvPricePerMeter"/></div>
            </div>
            <div class="row mt-2">
                <div class="col"><label>Manila Rate (per sqm)</label></div>
            </div>
            <div class="row">
                <div class="col"><input class="form-control form-control-small" type="number"  id="txtMNLPricePerMeter"/></div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="btnBillingSaveChanges">Save changes</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
    </div>

    <form method="POST" enctype="multipart/form-data">
        <div class="modal" tabindex="-1" role="dialog" id="mdUploadReceipt">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Payment Receipt</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mt-2 col_upload">
                        <div class="col">
                            <input type="file" class="form-control-file" id="receiptImage" name="receiptImage" accept=".png, .jpg, .jpeg" style="display: none;">
                            <label for="receiptImage" class="btn btn-primary" id="btnChangePhoto">
                                Select Photo
                            </label>
                            <label id="lblSelectedPhoto"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class='col'>
                            <img id="imgDisplayReceipt" width="100%"></img>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btnUploadSaveChanges">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                </div>
            </div>
        </div>
    </form>

    <div class="modal" tabindex="-1" role="dialog" id="mdUpdateBilling">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Bill for Space</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
                    <div class="row">
                        <div class="col">Amount</div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input class="form-control form-control-small" type="number" id="txt_selectedAmount" />
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">Payment Status</div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <select class="form-control form-control-small" id="txtPaymentStatus">
                                <option value="paid">Paid</option>
                                <option value="unpaid">Unpaid</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btnBillingSaveChanges2">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="mdQRSetup">
        <div class="modal-dialog modal-dialog-centered " role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Payment Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
                    <div class="row">
                        <div class="col">Account Number</div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input class="form-control form-control-small" type="number" id="txt_AccountNumber" />
                        </div>
                    </div>
                    <hr/>
                    <div class="row mt-2 row_uploadQR">
                        <div class="col">
                            <input type="file" class="form-control-file" id="QRImage" name="QRImage" accept=".png, .jpg, .jpeg" style="display: none;">
                            <label for="QRImage" class="btn btn-primary" id="btnChangePhoto">
                                Select Photo
                            </label>
                            <label id="lblQRPhoto"></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class='col'>
                            <img id="imgDisplayQR" width="100%"></img>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btnQRSaveChanges">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <!--end::Container-->

    <!------------------------------------------------------------>
    <?php include("shared/layout/bottom-layout.php") ?>
    <!------------------------------------------------------------>

    <!--begin::Custom Scripts-->
    <script src="../content/plugins/custom/datatables/datatables.bundle.js"></script>
    <script src="../controller/javascript/bill-summary.js"></script>
    <!-- <script src="../content/js/pages/crud/datatables/advanced/column-rendering.js"></script> -->
    <!--end::Custom Scripts-->

</html>
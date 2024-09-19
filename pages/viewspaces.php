<!DOCTYPE html>
<html lang="en">

<head>
    <base href="">
    <meta charset="utf-8" />
    <title>COMS - Spaces</title>

    <style>
        img {
            max-width: 100%;
            height: auto;
        }

        .imagemap {
            position: relative;
        }

        .imagemap img {
            display: block;
        }

        .imagemap .area {
            display: block;
            position: absolute;
            transition: box-shadow 0.15s ease-in-out;
        }

        .imagemap .area:hover {
            box-shadow: 0px 0px 1vw rgba(0, 0, 0, 1);
        }

        .imagemap .area {
            background-color: transparent;
            box-shadow: 0px 0px 1vw rgba(0, 0, 0, 0.3);
            background-repeat: no-repeat;
            border: solid black 3px;
            border-radius: 5px;
            cursor: pointer;
            overflow: hidden;
            outline: none;
        }
    </style>

    <?php include("shared/layout/top-layout.php") ?>
    <link href="../content/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-jcrop/0.9.15/css/jquery.Jcrop.css">
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
                            <h5 class="text-dark font-weight-bold my-1 mr-5">Concourse - Space</h5>
                            <!--end::Page Title-->
                            <!--begin::Breadcrumb-->
                            <ul
                                class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                                <li class="breadcrumb-item">
                                    <a href="" class="text-muted">List of Spaces</a>
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
                <div class="card card-custom" style="border-radius: 10px 10px 0px 0px!important" id="divmap">
                    <!--begin::Header-->
                    <div class="card-header py-5">
                        <div class="card-title">
                            <span id="con_id" style="display:none;">
                                <?php if (isset($_GET['concourse'])) {
                                    echo $_GET['concourse'];
                                } ?>
                            </span>
                            <span id="conRate" style="display:none;"></span>
                            <h3 class="card-label">Spaces
                                <div class="text-muted pt-2 font-size-sm">Hover to space layout to see details</div>
                            </h3>
                        </div>
                        <div class="card-toolbar">
                            <!--begin::Button-->
                            <button class="btn btn-primary font-weight-bolder" id="btnAddspace"
                                onclick="CropSpaceLayout()">
                                <span class="svg-icon svg-icon-md">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24" />
                                            <circle fill="#000000" cx="9" cy="15" r="6" />
                                            <path
                                                d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z"
                                                fill="#000000" opacity="0.3" />
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>Add Space
                            </button>
                            <button class="btn btn-danger font-weight-bolder" id="btnCancelCrop" onclick="CropCancel()">
                                <span class="svg-icon svg-icon-md">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24" />
                                            <circle fill="#000000" cx="9" cy="15" r="6" />
                                            <path
                                                d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z"
                                                fill="#000000" opacity="0.3" />
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>Cancel Crop
                            </button>
                            <!--end::Button-->
                        </div>
                    </div>
                    <!--end::Header-->

                    <!--begin::Body-->
                    <div class="card-body overflow-hidden">
                        <div id="img-src">
                            <div id="img-src-con">
                                <img id="image" src="" width="100%" height="1500" usemap="#image-map">
                            </div>
                        </div>

                        <map name="image-map" id="layoutmap">
                            <div id="layoutarea">
                                <area target="" spaceid="space1" alt="1" title="custom" href="" coords="654,257,884,504"
                                    shape="rect">
                                <area target="" spaceid="space2" alt="2" title="custom2" href="" coords="32,207,242,458"
                                    shape="rect">
                            </div>
                        </map>

                    </div>
                    <!--end::Body-->
                </div>

                <!--begin::Card-->
                <div class="card card-custom" style="border-radius: 0px 0px 10px 10px!important">
                    <div class="card-header flex-wrap py-5">
                        <div class="card-title">
                            <h3 class="card-label">
                                <div class="text-muted pt-2 font-size-sm">List of spaces</div>
                            </h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <!--begin: Datatable-->
                        <table class="table table-separate table-head-custom table-checkable" id="kt_datatable">
                            <thead>
                                <tr>
                                    <th>Space Name</th>
                                    <th>Tenant Name</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <!--end: Datatable-->
                    </div>
                </div>
                <!--end::Card-->
            </div>
            <!--end::Content-->

        </div>
        <!--begin::Content Wrapper-->
    </div>
    <!--end::Container-->


    <div class="modal fade" id="NewSpacesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Space Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row" hidden>
                        <div class="col-md-3">
                            <div class="form-group">
                                <span class="form-control form-control-solid h-auto py-5 px-6" type="text" id="coordx1"
                                    autocomplete="off" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <span class="form-control form-control-solid h-auto py-5 px-6" type="text" id="coordx2"
                                    autocomplete="off" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <span class="form-control form-control-solid h-auto py-5 px-6" type="text" id="coordy1"
                                    autocomplete="off" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <span class="form-control form-control-solid h-auto py-5 px-6" type="text" id="coordy2"
                                    autocomplete="off" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Space Name:</label>
                                <input class="form-control form-control-solid h-auto py-5 px-6" type="text"
                                    placeholder="Space Name" id="spacename" autocomplete="off" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Space Price: (PHP)</label>
                                <input class="form-control form-control-solid h-auto py-5 px-6" type="number"
                                    placeholder="Space Price" id="spaceprice" autocomplete="off" value="0" disabled />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Additional Rate: (PHP)</label>
                                <input class="form-control form-control-solid h-auto py-5 px-6"
                                    placeholder="Additional Rate" type="number" id="additional_rate" name="space_length"
                                    required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Space Width: (M)</label>
                                <input class="form-control form-control-solid h-auto py-5 px-6" type="number"
                                    placeholder="Space Width" id="spacewidth" autocomplete="off" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Space Length: (M)</label>
                                <input class="form-control form-control-solid h-auto py-5 px-6" type="number"
                                    placeholder="Space Length" id="spacelength" autocomplete="off" />
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" onclick="CancelNewConcourse()" class="btn btn-secondary"
                        data-dismiss="modal">Cancel</button>
                    <button id="btnAddConcourse" type="button" class="btn btn-primary" onclick="AddNewSpace()">Add
                        Space</button>
                    <button id="btnUpdateConcourse" type="button" class="btn btn-danger">Update Space</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal" tabindex="-1" role="dialog" id="mdBillingSetup">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Bill for Space</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
                    <div class="row">
                        <div class="col">Electricity </span> (kW * <span class="lblElectricAmount"></span>)</div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input class="form-control form-control-small" type="number" id="txtElectricUnit"
                                onkeyup="computeBilling()" />
                            <input class="form-control form-control-small" type="number" id="txtElectricTotal" disabled/>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">Water (cbm * <span class="lblWaterAmount"></span>)</div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input class="form-control form-control-small" type="number" id="txtWaterUnit"
                                onkeyup="computeBilling()" />
                            <input class="form-control form-control-small" type="number" id="txtWaterTotal" disabled/>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">Rent</div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input class="form-control form-control-small" type="number" id="txtRentTotal" disabled/>
                        </div>
                    </div>
                    <!-- <div class="row mt-2">
                        <div class="col">Due Date: </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input class="form-control form-control-small" type="date" id="txtDueDate" />
                        </div>
                    </div> -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btnCreateUtilityBilling">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    

    <div class="modal" tabindex="-1" role="dialog" id="mDeposit">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Security Deposit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mt">
                        <div class="col">Amount</div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input class="form-control form-control-small" type="number" id="txtBAmount" />
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">Due Date: </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input class="form-control form-control-small" type="date" id="txtBDueDate" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btnBillDeposit">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal" tabindex="-1" role="dialog" id="mdViewAddbill">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Bill for Space</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body ">
                    <div class="row mt-2">
                        <div class="col">Bill Type</div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <select class="form-control form-control-small" id="txtBillType">
                                <option value="SecurityDeposit">Security Deposit</option>
                                <option value="Rent">Monthly Bill (Utility & Rent)</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btnViewAddbill"  data-dismiss="modal">Add Bill</button>
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

    <div class="modal" id="mdViewPrevBillings" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">All Billings</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-separate table-head-custom table-checkable" id="kt_PrevBilling">
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
                    <hr/>
                    <div class="row d-none" id="row_uploadedphoto">
                        <div class='col'>
                            <label id="lblSelectedPhoto">Uploaded Receipt:</label>
                            <img id="imgDisplayReceipt" width="100%"></img>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btnBillingSaveChanges">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ViewSpace" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Space Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <span id="selectedspace" style="display:none;"></span>
                        <span id="owner" style="display:none;"></span>
                        <span id="owner_email" style="display:none;"></span>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Space Name:</label>
                                <span class="form-control form-control-solid h-auto py-5 px-6" id="vspacename"></span>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Status:</label>
                                <span class="form-control form-control-solid h-auto py-5 px-6" id="vspacestatus"></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Space Dimension: (L X W)</label>
                                <span class="form-control form-control-solid h-auto py-5 px-6" id="vspacedimension">
                                </span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Space Area: (SQM)</label>
                                <span class="form-control form-control-solid h-auto py-5 px-6" id="vspacearea"></span>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Space Price: (PHP)</label>
                                <span class="form-control form-control-solid h-auto py-5 px-6" id="vspaceprice"></span>
                            </div>
                        </div>

                        <div class="col-md-7">
                            <div class="form-group">
                                <label>Space Owner:</label>
                                <span class="form-control form-control-solid h-auto py-5 px-6" id="vspaceowner"></span>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button id="btnPrepareSpace" type="button" onclick="ApplySpacesModal()"
                        class="btn btn-warning">Apply Space</button>

                    <button id="btnNotifyMe" type="button" onclick="NotifyMe()"
                        class="btn btn-danger">Notify Me Once Available</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ApplySpace" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Space Application</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="reqparent">
                        <div id="reqchild">

                            <h4 class="mb-10">Upload the Requirements:</h4>
                            <div class="row" id="reqrow">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Letter of Intent</label>
                                        <input type="file" class="form-control form-control-solid h-auto py-5 px-6"
                                            id="fileInput" name="files[]" accept="*" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Letter of Intent</label>
                                        <input type="file" class="form-control form-control-solid h-auto py-5 px-6"
                                            id="fileInput" name="files[]" accept="*" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Letter of Intent</label>
                                        <input type="file" class="form-control form-control-solid h-auto py-5 px-6"
                                            id="fileInput" name="files[]" accept="*" />
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <hr />
                    <div class="row">
                        <div class="col-md-12 mt-5" margin:auto!important">
                            <div class="row">

                                <div class="col-md-12 mt-5" margin:auto!important">
                                    <div class="form-group">
                                        <label>Lease Terms:</label>
                                        <select class="form-control form-control-solid h-auto py-5 px-6"
                                            id="leaseTerms">
                                            <option value="3mos">3 Months</option>
                                            <option value="6mos">6 Months</option>
                                            <option value="1yr">1 Year</option>
                                            <option value="2yrs">2 Years</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12 mt-5" margin:auto!important">
                                    <div class="form-group">
                                        <label>What kind of
                                            business will be placed? (Eg. Foods, drinks, clothes, etc)</label>
                                        <textarea class="form-control form-control-solid h-auto py-5 px-6"
                                            id="applicant_remarks"></textarea>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- <div class="col-md-12 mt-5" style="text-align: center;" margin:auto!important">
                            <h4>Upload the needed requirements:</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>(Select multiple files to be uploaded)</label>
                                </div>
                                <div class="col-md-12 mt-5">
                                    <form id="uploadForm" enctype="multipart/form-data">
                                        <input type="file" id="fileInput" name="files[]" accept="image/*" />
                                    </form>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button id="uploadButton" type="button" class="btn btn-warning">Submit Application</button>
                </div>
            </div>
        </div>
    </div>

    <!------------------------------------------------------------>
    <?php include("shared/layout/bottom-layout.php") ?>
    <!------------------------------------------------------------>

    <!--begin::Custom Scripts-->
    <script src="../content/plugins/custom/datatables/datatables.bundle.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-jcrop/0.9.15/js/jquery.Jcrop.js"></script>
    <script src="../controller/javascript/viewspaces.js"></script>
    <!--end::Custom Scripts-->

</html>
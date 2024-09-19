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
                            <h5 class="text-dark font-weight-bold my-1 mr-5">Space Application</h5>
                            <!--end::Page Title-->
                            <!--begin::Breadcrumb-->
                            <ul
                                class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                                <li class="breadcrumb-item">
                                    <a href="" class="text-muted" id="lptLabel1">List of Potential Tenants</a>
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
                            <h3 class="card-label">Application
                                <div class="text-muted pt-2 font-size-sm" id="lptLabel2">List of potential tenants</div>
                            </h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <!--begin: Datatable-->
                        <table class="table table-separate table-head-custom table-checkable" id="kt_datatable">
                            <thead>
                                <tr>
                                    <th>Concourse</th>
                                    <th>Space Name</th>
                                    <th>Applicant</th>
                                    <th>Date of Application</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
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




    <div class="modal fade" id="ViewApplication" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><span id="con_name">Basketball Court</span> - <span id="space_name">Office
                            1</span> - <span id="applicant_name">Joshua Kim Balanza</span></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <span id="application_id" style="display:none;"></span>
                    <span id="con_address" style="display:none;"></span>
                    <span id="tenant_email" style="display:none;"></span>
                    <span id="owner" style="display:none;"></span>
                    <span id="owner_email" style="display:none;"></span>

                    <div class="row">
                        <div class="col-md-4">
                            <img id="profile_img" src="../assets/uploads/user/IMG_ProfileImage_65ca442434ce1.jpg"
                                class="w-100" />
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Application Date:</label>
                                        <span id="application_date"
                                            class="form-control form-control-solid h-auto py-5 px-6"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Lease Term:</label>
                                        <span id="lease_term"
                                            class="form-control form-control-solid h-auto py-5 px-6"></span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Applicant Purpose:</label>
                                        <textarea id="applicant_purpose" class="form-control h-auto py-5 px-6"
                                            disabled></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr />
                    <h6 class="mb-10" id="uploadLabel">Uploaded Requirements</h6>
                    <div id="reqparent">
                        <div id="reqchild">

                            

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="btnApproved" onclick="ActionApplication('Approved')" type="button"
                        class="btn btn-primary">Approved</button>
                    <button id="btnOnhold" onclick="ActionApplication('OnHold')" type="button"
                        class="btn btn-warning">On-Hold</button>
                    <button id="btnReject" onclick="ActionApplication('Reject')" type="button"
                        class="btn btn-danger">Reject</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="FileViewer" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fileName">#</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img id="viewfileimg" src="#" class="w-100" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ActionApplication" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fileName">Add Remarks</h5>
                </div>
                <div class="modal-body">
                    <textarea id="owner_remarks" class="form-control h-auto py-5 px-6"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="ApprovedApp" class="btn btn-primary">Approved Application</button>
                    <button type="button" id="OnholdApp" class="btn btn-warning">Hold Application</button>
                    <button type="button" id="RejectApp" class="btn btn-danger">Reject Application</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ReSubmitApplication" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Re Submit Application</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="re_reqparent">
                        <div id="re_reqchild">

                            <h4 class="mb-10">Upload the Remaining Requirements:</h4>
                            <div class="row" id="re_reqrow">
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button id="uploadButton" type="button" class="btn btn-warning">Submit Application</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ViewContract" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Contract Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span id="contract_con_id" style="display:none;" class="form-control form-control-solid h-auto py-5 px-6"></span>
                    <span id="contract_space_id" style="display:none;" class="form-control form-control-solid h-auto py-5 px-6"></span>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Space Name:</label>
                                <span id="contract_space_name"
                                    class="form-control form-control-solid h-auto py-5 px-6"></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Lease Term:</label>
                                <span id="lease_terms" class="form-control form-control-solid h-auto py-5 px-6"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Contract Start:</label>
                                <span id="contract_start"
                                    class="form-control form-control-solid h-auto py-5 px-6"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Contract End:</label>
                                <span id="contract_end" class="form-control form-control-solid h-auto py-5 px-6"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button id="btnRenew" onclick="RenewLeaseApplication()" type="button" class="btn btn-warning">Renew Lease</button>
                </div>
            </div>
        </div>
    </div>


    <!------------------------------------------------------------>
    <?php include("shared/layout/bottom-layout.php") ?>
    <!------------------------------------------------------------>

    <!--begin::Custom Scripts-->
    <script src="../content/plugins/custom/datatables/datatables.bundle.js"></script>
    <script src="../controller/javascript/space-application.js"></script>
    <!-- <script src="../content/js/pages/crud/datatables/advanced/column-rendering.js"></script> -->
    <!--end::Custom Scripts-->

</html>
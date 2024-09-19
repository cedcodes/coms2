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
                            <h5 class="text-dark font-weight-bold my-1 mr-5">Tenants</h5>
                            <!--end::Page Title-->
                            <!--begin::Breadcrumb-->
                            <ul
                                class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                                <li class="breadcrumb-item">
                                    <a href="" class="text-muted">List of Tenants</a>
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
                            <h3 class="card-label"> Tenants
                                <div class="text-muted pt-2 font-size-sm">List of tenants</div>
                            </h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <!--begin: Datatable-->
                        <table class="table table-separate table-head-custom table-checkable" id="kt_datatable">
                            <thead>
                                <tr>
                                    <th>Tenant ID</th>
                                    <th>Tenant Name</th>
                                    <th>Concourse</th>
                                    <th>Space</th>
                                    <th>Rent Started</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody> </tbody>
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

    <div class="modal" id="mdViewTenantContract" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document" >
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Contract</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                    <p><b>Space:</b> <label id="lblSpaceName"></label></p>
                    <p><b>Lease Terms:</b> <label id="lblLeaseTerm"></label></p>
                    <p><b>Contract Start:</b> <label id="lblContractStart"></label></p>
                    <p><b>Contract End:</b> <label id="lblContractEnd"></label></p>               
                </div>  
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="btnTerminateContract">Terminate Contract</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>

    



    <!------------------------------------------------------------>
    <?php include("shared/layout/bottom-layout.php") ?>
    <!------------------------------------------------------------>

    <!--begin::Custom Scripts-->
    <script src="../content/plugins/custom/datatables/datatables.bundle.js"></script>
    <script src="../controller/javascript/tenant.js"></script>
    <!-- <script src="../content/js/pages/crud/datatables/advanced/column-rendering.js"></script> -->
    <!--end::Custom Scripts-->

</html>
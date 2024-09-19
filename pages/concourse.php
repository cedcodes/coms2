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
                            <h5 class="text-dark font-weight-bold my-1 mr-5">Concourse</h5>
                            <!--end::Page Title-->
                            <!--begin::Breadcrumb-->
                            <ul
                                class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">
                                <li class="breadcrumb-item">
                                    <a href="" class="text-muted">List of Concourse</a>
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


                <!--begin::MAP-->
                <!--begin::Mixed Widget 1-->
                <div class="card card-custom" style="border-radius: 10px 10px 0px 0px!important" id="divmap">
                    <!--begin::Header-->
                    <div class="card-header py-5">
                        <div class="card-title">
                            <h3 class="card-label">Concourse
                                <div class="text-muted pt-2 font-size-sm">You can also pin to add concourse</div>
                            </h3>
                        </div>
                        <div class="card-toolbar">
                            <!--begin::Button-->
                            <button class="btn btn-primary font-weight-bolder" onclick="OpenNewConcourseModal()"
                                id="btnNewConcourse">
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
                                </span>New Concourse</button>
                            <!--end::Button-->
                        </div>
                    </div>
                    <!--end::Header-->

                    <!--begin::Body-->
                    <div class="card-body overflow-hidden">
                        <input id="searchloc" class="form-control mb-5" placeholder="Search Location..." />
                        <!--begin::Chart-->
                        <div id="map" style="border-radius: 5px 5px; height: 560px;"></div>
                        <!-- <script src="../content/plugins/global/plugins.bundle.js"></script> -->
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js"></script>
                        <script src="../controller/javascript/concoursemap.js"></script>
                        <span id="mapsource">
                            <script
                                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCgACQGAmZrylfg5sktK_jYVunOm_4kAes&libraries=places&amp;callback=initMap">
                                </script>
                        </span>
                        <!--end::Chart-->
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::MAP-->

                <!--begin::Card-->
                <div class="card card-custom" style="border-radius: 0px 0px 10px 10px!important">
                    <div class="card-header flex-wrap py-5">
                        <div class="card-title">
                            <h3 class="card-label">
                                <div class="text-muted pt-2 font-size-sm">List of concourse</div>
                            </h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <!--begin: Datatable-->
                        <table class="table table-separate table-head-custom table-checkable" id="kt_datatable">
                            <thead>
                                <tr>
                                    <th>Concourse</th>
                                    <th>Address</th>
                                    <th>Spaces</th>
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


    <div class="modal fade" id="NewConcourseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Concourse Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row" style="display:none;">
                        <div class="col-md-6">
                            <div class="form-group">
                                <span class="form-control form-control-solid h-auto py-5 px-6" type="text" id="txtlat"
                                    autocomplete="off" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <span class="form-control form-control-solid h-auto py-5 px-6" type="text" id="txtlongt"
                                    autocomplete="off" />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Concourse Name:</label>
                                <input class="form-control form-control-solid h-auto py-5 px-6" type="text"
                                    placeholder="Concourse Name" id="conName" autocomplete="off" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Concourse Address:</label>
                                <input class="form-control form-control-solid h-auto py-5 px-6" type="text"
                                    placeholder="Concourse Address" id="conAddress" autocomplete="off" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Concourse Rate:</label>
                                <div id="ParentRate">
                                    <div id="ChildRate">
                                        <select class="form-control form-control-solid h-auto py-5 px-6" id="conRate">
                                            <option value=""> -- SELECT RATE --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <form id="form_upload">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="hidden" name="con_img_name" id="con_img_name">
                                        <div class="row">
                                            <div class="col-12 mb-5" style="text-align:center!important;">
                                                <label>Concourse Image:</label>
                                            </div>
                                            <div class="col-12" style="text-align:center!important;">
                                                <div class="image-input image-input-empty image-input-outline"
                                                    id="concourse_image">
                                                    <div class="image-input-wrapper"></div>
                                                    <label
                                                        class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                        data-action="change" data-toggle="tooltip" title=""
                                                        data-original-title="Change Image">
                                                        <i class="fa fa-pen icon-sm text-muted"></i>
                                                        <input type="file" name="conImage" id="conImage"
                                                            accept=".png, .jpg, .jpeg" />
                                                        <input type="hidden" name="profile_avatar_remove" />
                                                    </label>

                                                    <span
                                                        class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                        data-action="cancel" data-toggle="tooltip" title="Clear Image">
                                                        <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                    </span>

                                                    <span
                                                        class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                        data-action="remove" data-toggle="tooltip" title="Remove Image"
                                                        id="removeConImage">
                                                        <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="hidden" name="con_layout_name" id="con_layout_name">
                                        <div class="row">
                                            <div class="col-12 mb-5" style="text-align:center!important;">
                                                <label>Space Layout:</label>
                                            </div>
                                            <div class="col-12" style="text-align:center!important;">
                                                <div class="image-input image-input-empty image-input-outline"
                                                    id="concourse_layout">
                                                    <div class="image-input-wrapper"></div>
                                                    <label
                                                        class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                        data-action="change" data-toggle="tooltip" title=""
                                                        data-original-title="Change Layout">
                                                        <i class="fa fa-pen icon-sm text-muted"></i>
                                                        <input type="file" name="conLayout" id="conLayout"
                                                            accept=".png, .jpg, .jpeg" />
                                                        <input type="hidden" name="profile_avatar_remove" />
                                                    </label>

                                                    <span
                                                        class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                        data-action="cancel" data-toggle="tooltip" title="Clear Layout">
                                                        <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                    </span>

                                                    <span
                                                        class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                        data-action="remove" data-toggle="tooltip" title="Remove Layout"
                                                        id="removeConLayout">
                                                        <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <input type="submit" name="submit" value="upload_image" style="display: none;" /> -->
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" onclick="CancelNewConcourse()" class="btn btn-secondary"
                        data-dismiss="modal">Cancel</button>
                    <button id="btnAddConcourse" type="button" class="btn btn-primary" onclick="AddNewConcourse()">Add
                        Concourse</button>
                    <button id="btnUpdateConcourse" type="button" class="btn btn-danger">Update Concourse</button>
                </div>
            </div>
        </div>
    </div>





    <!------------------------------------------------------------>
    <?php include("shared/layout/bottom-layout.php") ?>
    <!------------------------------------------------------------>

    <!--begin::Custom Scripts-->
    <script src="../content/plugins/custom/datatables/datatables.bundle.js"></script>
    <script src="../controller/javascript/concourse.js"></script>
    <!--end::Custom Scripts-->

</html>
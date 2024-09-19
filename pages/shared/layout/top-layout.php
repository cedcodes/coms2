<meta name="description" content="Updates and statistics" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
<!--begin::Head-->
<?php include('shared/header.php') ?>
<!--end::Head-->
<link rel="shortcut icon" href="../assets/logo/Logo-9b593c.png">
</head>

<!--begin::Body-->

<body id="kt_body" class="header-fixed subheader-enabled page-loading">
    <div id="custom_preloader">
        <div id="custom_loader" class="custom_center"></div>
    </div>
    <span id="usertype" style="display:none;"><?php session_name("user_session");
              session_start();
              $usertype = $_SESSION["usertype"];

              if(isset($_SESSION["usertype"])){
                echo $usertype;
              }
              else{

              }
        ?></span>

    <!--begin::Main-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="d-flex flex-row flex-column-fluid page">
            <!--begin::Wrapper-->
            <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">

                <!--begin::Header Menu-->
                <?php include('shared/header_menu.php') ?>
                <!--end::Header Menu-->
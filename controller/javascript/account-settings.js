$(document).ready(function () {
    // alert("Concourse");
});

//Page Loader
document.onreadystatechange = function () {
    if (document.readyState !== "complete") {
        $('#custom_preloader').delay(350).fadeIn('slow')
    } else {
        LoadAvailableMenu(0);
        $('#custom_preloader').delay(350).fadeOut('slow');
    }
};
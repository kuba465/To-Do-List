$(document).ready(function () {
    $("button#addCategoryBtn").click(function () {
        $("div.addCategory").toggle();
    })

    $('.js-datepicker').datepicker();
});
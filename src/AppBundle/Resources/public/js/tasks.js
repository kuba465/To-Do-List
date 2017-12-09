$(document).ready(function () {
    $("button#addCategoryBtn").click(function () {
        $("div.addCategory").toggle();
    });

    $('#datetimepicker1').datetimepicker();


    var taskIsDone = $("#taskIsDone");
    taskIsDone.click(function (e) {
        e.stopPropagation();
    });

    var taskList = $(".task");
    var divWithTaskList = taskList.parent().parent();
    var showTaskDiv = $("#showTask");

    var editBtn = showTaskDiv.find('#editTaskButton');
    var deleteBtn = showTaskDiv.find('button.deleteTaskBtn');

    taskList.on('click', function () {
        if (divWithTaskList.hasClass('col-md-9')) {
            divWithTaskList.removeClass('col-md-9').addClass('col-md-6');
            showTaskDiv.toggle();
        }
        $.ajax({
            method: 'POST',
            url: '/tasks/' + $(this).attr('id'),
            dataType: "json"
        }).done(function (success) {
            var tds = showTaskDiv.find('td');

            editBtn.attr('href', '/tasks/' + success.id + '/edit');
            deleteBtn.attr('id', success.id);

            tds.eq(0).text(success.name);
            tds.eq(1).text(success.description);
            tds.eq(2).text(moment(success.input_date).format('Do MMMM YYYY, h:mm:ss'));
            tds.eq(3).text(moment(success.date_to_done).format('Do MMMM YYYY, h:mm:ss'));
            tds.eq(4).text(success.priority);
            tds.eq(5).text(success.category);
            tds.eq(6).text('');
            tds.eq(6).append(putInfoOfComment(success.comments));
        });
        var taskId = $(this).attr('id');
        var addCommentBtn = $('#addComment');
        var divComment = $('.addComment');
        var tdToPutNewComment = $('td#comments');
        addCommentBtn.click(function (e) {

            var commentValue = divComment.find('textarea').val();

            $.ajax({
                method: 'POST',
                url: '/tasks/addComment',
                data: {
                    'taskId': taskId,
                    'commentValue': commentValue,
                }
            }).done(function (success) {
                var newComment = '<dl>' +
                    '<dt>' + success.user.username + '</dt>' +
                    '<dd>' + success.comment.description + '</dd>' +
                    '</dl>';
                tdToPutNewComment.append(newComment);
            });
            e.preventDefault();
        });

        deleteBtn.click(function () {
            var id = $(this).attr('id');
            $.ajax({
                method: 'DELETE',
                url: '/tasks/' + id + '/delete'
            }).done(function (success) {
                divWithTaskList.removeClass('col-md-6').addClass('col-md-9');
                showTaskDiv.toggle();
                $('p#' + id).remove();
            });
        });
    });

    var buttonToHideShowTask = showTaskDiv.find('button#hideShowTask');
    buttonToHideShowTask.click(function () {
        divWithTaskList.removeClass('col-md-6').addClass('col-md-9');
        showTaskDiv.toggle();
    });

    var categoryId = $('#lists .active').data('id');
    var buttonDonedTasks = $('button#donedTasks');

    buttonDonedTasks.click(function () {
        $.ajax({
            method: 'GET',
            url: categoryId + "/showDone",
            dataType: 'json'
        }).done(function (success) {
            var elem = buttonDonedTasks.parent().find('#showDonedTasks');

            if (elem.is(':visible')) {
                elem.remove();
            } else {
                buttonDonedTasks.after(createParagraphWithCompletedTask(success.doneTasks));
            }
        });
    });
});

function putInfoOfComment(comments) {
    var newList = '<dl>';

    for (var i = 0; i < comments.length; i++) {
        newList += '<dt>' + comments[i].user + '</dt>';
        newList += '<dd>' + comments[i].description + '</dd>';
        newList += '<br>';
    }
    newList += '</dl>';

    return newList;
}

function createParagraphWithCompletedTask(tasks) {
    var newDiv = '<div id="showDonedTasks" class="list-group">';

    for (var i = 0; i < tasks.length; i++) {
        newDiv += '<p class="list-group-item taskDoned">' + tasks[i].name + '</p>'
    }
    newDiv += '</div>';

    return newDiv;
}

function deleteTask() {
    $.ajax({
        method: 'DELETE',
        url: $(this).attr('id')
    }).done(function (success) {
        console.log(success);
    });
}

function saveButtonWithId(id) {
    var saveButton = '<button id=' + id + ' class="btn btn-primary btn-md saveButton">' +
        '<span class="glyphicon glyphicon-floppy-save">Save</span>' +
        '</button>';

    return saveButton;
}

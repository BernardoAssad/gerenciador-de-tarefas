$(document).ready(function () {
    $(".sortable-list").sortable({
        update: function (event, ui) {
            var taskOrder = $(this).sortable('toArray', { attribute: 'data-task-id' });
            $.ajax({
                url: 'update_position.php',
                method: 'POST',
                data: { taskOrder: taskOrder },
                success: function (response) {
                    console.log(response);
                }
            });
        }
    });

    $("#taskForm").submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: 'index.php',
            method: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                console.log(response);
                location.reload();
            }
        });
    });
    
    $(".sortable-list").on('click', '.mark-complete', function () {
        var taskId = $(this).closest('.task').attr('data-task-id');
        var taskElement = $(this).closest('.task');

        $.ajax({
            url: 'mark_complete.php',
            method: 'POST',
            data: { taskId: taskId },
            success: function (response) {
                console.log(response);
                taskElement.remove();
            }
        });
    });
    
    $(".open-task-modal").on('click', function () {
        var taskId = $(this).data('task-id');
    
        $.ajax({
            url: 'get_task_details.php',
            method: 'POST',
            data: { taskId: taskId },
            success: function (response) {
                var taskDetails = JSON.parse(response);
                $('#taskDate').text(formatDate(taskDetails.date_added));
                $('#taskDueDate').text(formatDate(taskDetails.date_max));
            }
        });
    });
    
});

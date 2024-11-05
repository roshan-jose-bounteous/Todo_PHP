<!DOCTYPE html>
<html>
<head>
    <title>Todo List</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Todo List</h2>
        <div id="addTaskForm" class="form-inline mb-3">
            <input type="text" id="newTask" class="form-control mr-2" placeholder="New Task" required>
            <button id="addTaskBtn" class="btn btn-primary">Add Task</button>
        </div>
        <table class="table table-bordered" id="todoTable">
            <thead>
                <tr>
                    <th>Task</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Function to load tasks from the database
        function loadTasks() {
            $.ajax({
                url: 'api/todo.php?action=read',
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#todoTable tbody').empty();
                    $.each(data, function(index, item) {
                        $('#todoTable tbody').append(`
                            <tr data-id="${item.id}">
                                <td>
                                    <span class="task-name">${item.task}</span>
                                    <input type="text" class="form-control edit-input" value="${item.task}" style="display:none;">
                                </td>
                                <td>
                                    <button class="btn btn-success btn-sm update-task">Update</button>
                                    <button class="btn btn-danger btn-sm delete-task">Delete</button>
                                    <button class="btn btn-primary btn-sm save-task" style="display:none;">Save</button>
                                    <button class="btn btn-secondary btn-sm cancel-update" style="display:none;">Cancel</button>
                                </td>
                            </tr>
                        `);
                    });
                }
            });
        }

        $('#addTaskBtn').on('click', function() {
            const task = $('#newTask').val();
            if (task) {
                $.ajax({
                    url: 'api/todo.php?action=create',
                    method: 'POST',
                    data: { task: task },
                    success: function() {
                        $('#newTask').val('');
                        loadTasks();
                    }
                });
            }
        });

        $('#todoTable').on('click', '.update-task', function() {
            const row = $(this).closest('tr');
            row.find('.edit-input').show().focus();
            row.find('.save-task, .cancel-update').show();
            row.find('.update-task, .delete-task').hide();
            row.find('.task-name').hide();
        });

        $('#todoTable').on('click', '.cancel-update', function() {
            const row = $(this).closest('tr');
            row.find('.edit-input').hide();
            row.find('.save-task, .cancel-update').hide();
            row.find('.update-task, .delete-task').show();
            row.find('.task-name').show();
        });

        $('#todoTable').on('click', '.save-task', function() {
            const row = $(this).closest('tr');
            const id = row.data('id');
            const newTask = row.find('.edit-input').val();

            $.ajax({
                url: 'api/todo.php?action=update',
                method: 'POST',
                data: { id: id, task: newTask },
                success: function() {
                    loadTasks();
                }
            });
        });

        $('#todoTable').on('click', '.delete-task', function() {
            const id = $(this).closest('tr').data('id');
            $.ajax({
                url: 'api/todo.php?action=delete',
                method: 'POST',
                data: { id: id },
                success: function() {
                    loadTasks();
                }
            });
        });

        loadTasks();
    </script>
</body>
</html>

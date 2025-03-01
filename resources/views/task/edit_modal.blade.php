{{-- Edit Task Modal --}}
<div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('task-update') }}" method="POST" id="updateTaskForm">
                    @csrf
                    <input type="hidden" name="taskId" id="taskId_edit">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title_edit" name="title">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description_edit" name="description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status_edit" class="form-select">
                            <option value="Pending">Pending</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="dueDate" class="form-label">Due Date</label>
                        <input type="date" class="form-control" id="dueDate_edit" name="due_date">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $('.edit').click(function() {
    var taskId = $(this).data('task-id');
    $.ajax({
        type: "get",
        url: "{{ route('task-edit') }}",
        data: { taskId: taskId },
        dataType: "json",
        success: function (response) {
            if (response.status == 'success') {
                $('#title_edit').val(response.task.title);
                $('#description_edit').val(response.task.description);
                $('#dueDate_edit').val(response.task.due_date);
                $('#status_edit').val(response.task.status);
                $('#taskId_edit').val(response.task.id);
                $('#editTaskModal').modal('show');
            }
        }
    });
});
$('#updateTaskForm').submit(function(e) {
    e.preventDefault();
    var formData = $(this).serialize();
    var url = "{{ route('task-update') }}";
    $.ajax({
        url: url,
        method: "POST",
        data: formData,
        dataType: "json",
        success: function(response) {
            if (response.status == 'success') {
                $('#editTaskModal').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: response.message,
                    showConfirmButton: false,
                    timer: 1500
                }).then(function() {
                    location.reload();
                })
            }
            else {
                $('#editTaskModal').modal('hide');
                Swal.fire({
                    icon: 'error',
                    title: response.message,
                    showConfirmButton: false,
                    timer: 1500
                }).then(function() {
                    location.reload();
                })
            }
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                $('.text-danger').text('');
                var errors = xhr.responseJSON.errors;
                $.each(errors, function(key, messages) {
                    var inputField = $('input[name="' + key + '"]');
                    var errorContainer = $('#' + key + 'Error');
                    inputField.addClass('is-invalid');
                    if (errorContainer.length) {
                        errorContainer.text(messages[0]);
                    } else {
                        inputField.after('<span class="text-danger">' + messages[0] + '</span>');
                    }
                });
            }
            else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while updating the task.',
                });
            }
        }
    });
});
</script>
{{-- Add Task Modal --}}
<div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="taskForm">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Task Title</label>
                        <input type="text" class="form-control" id="" name="title">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <input type="text" class="form-control" id="" name="description">
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="" class="form-select">
                            <option value="Pending">Pending</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="due_date" class="form-label">Due Date</label>
                        <input type="date" class="form-control" id="" name="due_date">
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

{{-- Update status modal --}}
<div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('task-status-update') }}" method="POST" id="updateStatusForm">
                    @csrf
                    <input type="hidden" name="taskId" id="taskId">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="Pending">Pending</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $('#taskForm').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var url = "{{ route('task-store') }}";
        $.ajax({
            url: url,
            method: "POST",
            data: formData,
            dataType: "json",
            success: function(response) {
                if(response.status == 'success'){
                    $('#addTaskModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: response.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        location.reload();
                    })
                }
                else{
                    $('#addTaskModal').modal('hide');
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
            }
        });
    });

    $('.status').click(function() {
        var taskId = $(this).data('task-id');
        $('#taskId').val(taskId);
        $('#status').val($(this).text());
        $('#updateStatusModal').modal('show');
    })


            
    </script>

    
    @if (session()->has('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Task created successfully',
            showConfirmButton: false,
            timer: 1500
        });
    </script>
    @endif
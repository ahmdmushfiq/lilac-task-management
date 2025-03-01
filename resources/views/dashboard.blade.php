<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="{{ URL::asset('assets/css/custom.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.css" integrity="sha512-kJlvECunwXftkPwyvHbclArO8wszgBGisiLeuDFwNM8ws+wKIw0sv1os3ClWZOcrEB2eRXULYUsm8OVRGJKwGA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .status {
            cursor: pointer;
        }
        .status:hover {
            opacity: 0.8;
        }
    </style>
</head>

<body>
    <div>
        @include('layouts.topbar')


        <div class="container">
            <div class="row">
                <div class="col d-flex justify-content-center mt-3">
                    <h1>Task Management</h1>
                </div>
                <hr>
            </div>
            <div class="row mb-3">
                <div>
                    <button class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addTaskModal"><i class="ri-add-line"></i>Add
                        Task</button>
                        <div class="d-flex align-items-center float-end me-3">
                            <form action="{{ route('task-filter') }}" method="POST" class="d-flex gap-2">
                            @csrf
                            <select name="status" id="" class="form-select">
                                <option value="Pending">Pending</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Completed">Completed</option>
                            </select>
                            <button type="submit" class="btn btn-success"><i class="ri-filter-line"></i>Filter</button>
                        </form>
                    </div>
                    <div>
                        <a href="{{ route('dashboard') }}" class="btn btn-primary float-end me-3"><i class="ri-refresh-line"></i>Reset</a>
                    </div>

                </div>
            </div>
            <div class="row">
                <div>
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">SN</th>
                                <th scope="col">Task Title</th>
                                <th scope="col">Description</th>
                                <th scope="col">Status</th>
                                <th scope="col">Due Date</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tasks as $task)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $task->title }}</td>
                                <td>{{ $task->description }}</td>
                                <td>
                                    @if ($task->status == 'Pending')
                                    <span class="badge bg-warning status" data-task-id="{{ $task->id }}">{{
                                        $task->status }}</span>
                                    @elseif($task->status == 'In Progress')
                                    <span class="badge bg-info status" data-task-id="{{ $task->id }}">{{ $task->status
                                        }}</span>
                                    @else
                                    <span class="badge bg-success status" data-task-id="{{ $task->id }}">{{
                                        $task->status }}</span>
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($task->due_date)->format('F j, Y') }}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary edit"
                                        data-task-id="{{ $task->id }}">Edit</button>
                                    <form action="{{ route('task-delete', $task->id) }}" method="POST"
                                        style="display: inline-block">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
    @include('layouts.footer')
    @include('task.edit_modal')
    @include('task.create_modal')
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>
<script>
    @if (session()->has('success'))
        Swal.fire({
            icon: 'success',
            title: 'Task Deleted successfully',
            showConfirmButton: false,
            timer: 1500
        });
    @endif
</script>


</html>
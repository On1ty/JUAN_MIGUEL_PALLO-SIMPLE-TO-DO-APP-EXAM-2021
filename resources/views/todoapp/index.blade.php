<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ToDoApp</title>
    <!-- Fonts -->
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <span class="navbar-brand mb-0 h1">ToDoSimpleApp by Juan Miguel Pallo</span>
    </nav>
    <div class="container mt-4">
        <h1>ToDo Simple App</h1>
        <p>For this exam, same <b>Owner</b> and <b>Task</b> cannot duplicate</p>
        @if (session()->has('msg'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                @if (session()->has('msg_duplicate'))
                    <strong>Duplicate!</strong> {{ session('msg_duplicate') }}
                @else
                    <strong>Success!</strong> {{ session('msg') }}
                @endif
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if (session()->has('msg_empty'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> {{ session('msg_empty') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <form action="/" method="POST" id="todo_form_add">
            @csrf
        </form>
        <form action="/" method="POST" id="todo_form_delete">
            @csrf
            @method('DELETE')
        </form>
        <table class="table table-hover table-sm">
            <thead class="thead-light">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Task</th>
                    <th scope="col">Owner</th>
                    <th scope="col">Status</th>
                    <th scope="col">Date Created</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($toDoList as $toDo)
                    <tr>
                        <th scope="row"><span class="cell_val">{{ $toDo->id }}</span></th>
                        <td><span class="cell_val">{{ $toDo->task }}</span></td>
                        <td><span class="cell_val">{{ $toDo->owner }}</span></td>
                        <td>
                            <span class="cell_val">{{ $toDo->status }}</span>
                        </td>
                        <td><span class="cell_val">{{ date('M d, Y', strtotime($toDo->created_at)) }}</span></td>
                        <td>
                            <button class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#editFormModal"
                                data-id="{{ $toDo->id }}" data-task="{{ $toDo->task }}"
                                data-owner="{{ $toDo->owner }}" data-status="{{ $toDo->status }}"><i
                                    class="fa fa-edit"></i></button>
                            <button class="btn btn-danger btn-sm" value="{{ $toDo->id }}" name="todo_id"
                                form="todo_form_delete"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3">
                        <div class="form-group">
                            <input type="text" class="form-control" required form="todo_form_add"
                                name="task" placeholder="Task">
                        </div>
                    </td>
                    <td colspan="2">
                        <div class="form-group">
                            <input type="text" class="form-control" required form="todo_form_add" name="owner"
                                placeholder="Owner">
                        </div>
                    </td>
                    <td>
                        <button class="btn btn-primary btn-sm mt-1" form="todo_form_add"><i
                                class="fa fa-plus"></i></button>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="modal fade" id="editFormModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="">Update Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/" method="POST" id="todo_form_updt">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <input type="hidden" class="form-control" name="id">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Task</label>
                            <input type="text" class="form-control" name="task">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Owner</label>
                            <input type="text" class="form-control" name="owner">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Status</label>
                            <select class="form-control" name="status">
                                <option value="Working on">Working on</option>
                                <option value="Completed">Completed</option>
                              </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" form="todo_form_updt">Update</button>
                </div>
            </div>
        </div>
    </div>
    <script src="/js/app.js"></script>
</body>
</html>

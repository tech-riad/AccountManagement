@extends('backend.layouts.master')

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">All Employee</h4>
            <button type="button" class="btn btn-gradient-warning btn-rounded btn-fw " data-bs-toggle="modal" data-bs-target="#addModal">Add Employee</button>

            <table id="example" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th> Employee Name</th>
                  <th> Action </th>
                </tr>
              </thead>
              <tbody>
                @foreach($employees as $item)
                <tr>
                  <td> {{ $item->employee_name }} </td>
                  <td>
                    <div class="actions ml-3">
                        <a href="#" class="action-item customModal" data-toggle="modal" data-target="#editModal" data-employee="{{ $item }}" data-original-title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="#" class="action-item deleteEmployee" data-employee-id="{{ $item->id }}" data-original-title="Delete">
                            <i class="fas fa-trash-alt"></i>
                        </a>

                    </div>
                  </td>
                </tr>
                @endforeach


              </tbody>
            </table>
          </div>
        </div>
      </div>
</div>


  <!-- Modal -->
<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Employee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editEmployeeForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="employee_id" id="editEmployeeId">
                    <div class="form-group">
                        <label for="editEmployeeName">Employee Name</label>
                        <input type="text" name="employee_name" id="editEmployeeName" class="form-control">
                    </div>
                    <button type="button" id="updateEmployeeBtn" class="btn btn-primary" data-bs-dismiss="modal">Update Employee</button>
                </form>
            </div>
        </div>
    </div>
</div>



  <!-- Modal -->
  <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addModalLabel">Employee Add</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="card-body">
                <form>
                    @csrf
                    <div class="form-group">
                        <label for="employee_name">Employee Name</label>
                        <input type="text" id="employee_name" class="form-control" required>
                    </div>
                    <button type="button" id="createEmployee" class="btn btn-primary">Create Employee</button>
                </form>

            </div>
        </div>
      </div>
    </div>
  </div>

@endsection

@push('js')
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
<script>
    $(document).ready(function() {
        $('#createEmployee').on('click', function() {
            $.ajax({
                url: "{{ route('admin.employees.store') }}",
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    employee_name: $('#employee_name').val(),
                },
                success: function(response) {

                    console.log(response);

                    $('#addModal').modal('hide');
                    toastr.info('Employee created successfully');
                    setTimeout(function() {
                        location.reload();
                    }, 2000);

                },
                error: function(error) {
                    console.error(error);
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('.customModal').click(function(e) {
            e.preventDefault();
            console.log(employee);
            var employee = $(this).data('employee');
            $('#editEmployeeId').val(employee.id);
            $('#editEmployeeName').val(employee.employee_name);
            $('#editModal').modal('show');
        });

        $('#updateEmployeeBtn').click(function() {
            var formData = $('#editEmployeeForm').serialize();
            var employeeId = $('#editEmployeeId').val();


            $.ajax({
                url: "/admin/employees/" + employeeId,
                method: 'PUT',
                data: formData,
                success: function(response) {
                    toastr.success('Employees Updated Successfully');
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                    $('#editModal').modal('hide');
                },
                error: function(error) {
                    console.error(error);
                }
            });
        });
    });


</script>

<script>
    $(document).ready(function() {
    $('.deleteEmployee').click(function(e) {
        e.preventDefault();
        var employeeId = $(this).data('employee-id');
        var deleteButton = $(this);

        $.ajax({
            url: "{{ route('employees.destroy', '') }}" + '/' + employeeId,
            method: 'DELETE',
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                toastr.warning('Employee Deleted Successfully');
                    setTimeout(function() {
                        deleteButton.closest('tr').remove();
                    }, 2000);
            },
            error: function(error) {
                console.error(error);
            }
        });
    });
});
</script>

@endpush



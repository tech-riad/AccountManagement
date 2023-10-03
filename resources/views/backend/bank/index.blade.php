@extends('backend.layouts.master')

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">All Bank</h4>
            <button type="button" class="btn btn-gradient-warning btn-rounded btn-fw " data-bs-toggle="modal" data-bs-target="#addModal">Add Banking Method</button>

            <table id="example" class="table table-striped table-bordered " style="padding-top:20px;">
              <thead>
                <tr>
                  <th> Bank Method Name </th>
                  <th> Action </th>
                </tr>
              </thead>
              <tbody>
                @foreach($bank as $item)
                <tr>
                  <td> {{ $item->method_name }} </td>
                  <td>
                    <div class="actions ml-3">
                        <a href="#" class="action-item customModal" data-toggle="modal" data-target="#editModal" data-bank="{{ $item }}" data-original-title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="#" class="action-item deleteBank" data-bank-id="{{ $item->id }}" data-original-title="Delete">
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
                <h5 class="modal-title" id="editModalLabel">Edit Bank Method</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editBankForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="bank_id" id="editBankId">
                    <div class="form-group">
                        <label for="editBankName">Bank Method Name</label>
                        <input type="text" name="method_name" id="editBankName" class="form-control" required>
                    </div>
                    <button type="button" id="updateBankBtn" class="btn btn-primary">Update Bank</button>
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
          <h5 class="modal-title" id="addModalLabel">Bank Add</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="card-body">
                <form>
                    @csrf
                    <div class="form-group">
                        <label for="method_name">Method Name</label>
                        <input type="text" id="method_name" class="form-control" required>
                    </div>
                    <button type="button" id="createMethod" class="btn btn-primary">Create Method</button>
                </form>

            </div>
        </div>
      </div>
    </div>
  </div>

@endsection

@push('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#createMethod').on('click', function() {
            $.ajax({
                url: "{{ route('admin.bank.store') }}",
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    method_name: $('#method_name').val()
                },
                success: function(response) {

                    toastr.info('Account Method Created Successfully');
                    setTimeout(function() {
                        location.reload();
                    }, 2000);

                    $('#addModal').modal('hide');

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
            var bank = $(this).data('bank');
            $('#editBankId').val(bank.id);
            $('#editBankName').val(bank.method_name);
            $('#editModal').modal('show');
        });

        $('#updateBankBtn').click(function() {
            var formData = $('#editBankForm').serialize();
            var bankId = $('#editBankId').val();

            $.ajax({
                url: "/admin/bank/" + bankId,
                method: 'PUT',
                data: formData,
                success: function(response) {
                    toastr.success('Account Method Updated Successfully');
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
    $('.deleteBank').click(function(e) {
        e.preventDefault();
        var bankId = $(this).data('bank-id');
        var deleteButton = $(this); 

        $.ajax({
            url: "{{ route('bank.destroy', '') }}" + '/' + bankId,
            method: 'DELETE',
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                toastr.warning('Deleted Successfully');
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



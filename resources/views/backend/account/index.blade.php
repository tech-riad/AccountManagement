@extends('backend.layouts.master')

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Transction</h4>
            <button type="button" class="btn btn-gradient-warning btn-rounded btn-fw " data-bs-toggle="modal" data-bs-target="#addModal">Add Transction</button>

            <table id="example" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th> Date </th>
                  <th> Customer Name</th>
                  <th> Account Method </th>
                  <th> Amount</th>
                  <th> Created By</th>
                  <th> Transction By</th>
                  <th> Transction Type</th>
                  <th> Product name</th>
                  <th> Description</th>
                  <th> Action </th>
                </tr>
              </thead>
              <tbody>
                @foreach($accounts as $item)
                <tr>
                  <td> {{ @$item->payment_date }} </td>
                  <td> {{ @$item->customer_name }} </td>
                  <td> {{ @$item->bank->method_name }} </td>
                  <td> {{ @$item->amount }} </td>
                  <td> {{ @$item->created_by }} </td>
                  <td> {{ @$item->received_by }} </td>
                  <td> {{ @$item->transaction_type }} </td>
                  <td> {{ @$item->product->product_name }} </td>
                  <td> {{ @$item->description }} </td>
                  <td>
                    <div class="actions ml-3">
                        <a href="#" class="action-item customModal" data-toggle="modal" data-target="#editModal" data-accounts="{{ $item }}" data-original-title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        {{-- <a href="#" class="action-item deleteCategory" data-category-id="{{ $item->id }}" data-original-title="Delete">
                            <i class="fas fa-trash-alt"></i>
                        </a> --}}

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
                <h5 class="modal-title" id="editModalLabel">Edit Transction</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editTransctionForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="transction_id" id="editTransctionId">
                    <div class="row">
                        <div class="col-lg-6">
                        <div class="form-group">
                            <label for="editTransctionType">Transction Type</label>
                            <select name="transaction_type" id="editTransctionType" class="form-select" required>
                                <option value="income">Income</option>
                                <option value="expense">Expense</option>
                            </select>
                        </div>
                        </div>
                        <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="editBankaAccountMethod">Transction Method Method</label>
                                    <select name="account_method" id="editBankaAccountMethod" class="form-select" required>
                                        @foreach ($bank as $item)
                                        <option value="{{$item->id}}">{{$item->method_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="editCustomerName">Customer Name</label>
                                <input type="text" name="customer_name" id="editCustomerName" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="editPaymentDate">Payment Date</label>
                                <input class="form-control" name="payment_date"  type="date" value="" id="editPaymentDate">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="editAmount">Amount</label>
                                <input type="number" id="editAmount" name="amount" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="editCreatedBy">Created By</label>
                                <input type="text" name="created_by" id="editCreatedBy" class="form-control" value="{{Auth::user()->name}}" readonly>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="editReceivedBy">Transction By</label>
                                <input type="text" id="editReceivedBy" name="received_by" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="etitProductName">Product Name</label>
                                <select name="product_name" id="etitProductName" class="form-select" required>
                                    @foreach ($product as $item)
                                    <option value="{{$item->id}}">{{$item->product_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="editDescription">Description</label>
                                <textarea class="form-control" name="description" id="editDescription"
                                    rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="editTransaction" class="btn btn-primary">Update Trasction</button>
                </form>

            </div>

        </div>
    </div>
</div>


  <!-- Modal -->
  <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addModalLabel">Transction Add</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="card-body">
                <form>
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                        <div class="form-group">
                            <label for="transctionType">Transction Type</label>
                            <select name="transaction_type" id="transctionType" class="form-select" required>
                                <option value="income">Income</option>
                                <option value="expense">Expense</option>
                            </select>
                        </div>
                        </div>
                        <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="bankaAccountMethod">Transction Method Method</label>
                                    <select name="account_method" id="accountMethod" class="form-select" required>
                                        @foreach ($bank as $item)
                                        <option value="{{$item->id}}">{{$item->method_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="customer_name">Customer Name</label>
                                <input type="text" name="customer_name" id="customerName" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="payment_date">Payment Date</label>
                                <input class="form-control" name="payment_date" required="required" type="date" value="" id="paymentDate">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="number" id="amount" name="amount" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="created_by">Created By</label>
                                <input type="text" name="created_by" id="createdBy" class="form-control" value="{{Auth::user()->name}}" readonly>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="received_by">Transction By</label>
                                <input type="text" id="receivedBy" name="received_by" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="productName">Product Name</label>
                                <select name="product_name" id="productName" class="form-select" required>
                                    @foreach ($product as $item)
                                    <option value="{{$item->id}}">{{$item->product_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" name="description" id="description"
                                    rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="createTransaction" class="btn btn-primary">Create Trasction</button>
                </form>

            </div>
        </div>
      </div>
    </div>
  </div>

@endsection

@push('js')
<!-- Include jQuery library if not already included -->
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}

<script>
    $(document).ready(function() {
        $('#createTransaction').on('click', function() {
            $.ajax({
                url: "{{ route('admin.accounts.store') }}",
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    transaction_type: $('#transctionType').val(),
                    account_method: $('#accountMethod').val(),
                    customer_name: $('#customerName').val(),
                    payment_date: $('#paymentDate').val(),
                    amount: $('#amount').val(),
                    created_by: $('#createdBy').val(),
                    received_by: $('#receivedBy').val(),
                    product_name: $('#productName').val(),
                    description: $('#description').val()
                },
                success: function(response) {
                    console.log(response);
                    $('#addModal').modal('hide');
                    location.reload();
                    alert('Transaction created successfully');
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
        var transaction = $(this).data('accounts');
        $('#editTransctionId').val(transaction.id);
        $('#editTransctionType').val(transaction.transaction_type);
        $('#editBankaAccountMethod').val(transaction.account_method);
        $('#editCustomerName').val(transaction.customer_name);
        $('#editPaymentDate').val(transaction.payment_date);
        $('#editAmount').val(transaction.amount);
        $('#editReceivedBy').val(transaction.received_by);
        $('#etitProductName').val(transaction.product_name);
        $('#editDescription').val(transaction.description);
        $('#editModal').modal('show');
    });

    $('#editTransaction').click(function() {
        var formData = $('#editTransctionForm').serialize();
        var transactionId = $('#editTransctionId').val();

        $.ajax({
            url: "/admin/accounts/" + transactionId,
            method: 'PUT',
            data: formData,
            success: function(response) {
                location.reload();
                $('#editModal').modal('hide');
            },
            error: function(error) {
                console.error(error);
            }
        });
    });
});
</script>

@endpush



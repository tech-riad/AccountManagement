@extends('backend.layouts.master')

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Transactions</h4>
                <button type="button" class="btn btn-gradient-warning btn-rounded btn-fw" data-bs-toggle="modal" data-bs-target="#addModal">Add Transaction</button>

                <table id="example" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Customer Name</th>
                            <th>Employee Name</th>
                            <th>Account Method</th>
                            <th>Amount</th>
                            <th>Transaction Type</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($accounts as $item)
                        <tr>
                            <td>{{ @$item->payment_date }}</td>
                            <td>{{ @$item->customer_name }}</td>
                            <td>{{ @$item->employee->employee_name }}</td>
                            <td>{{ @$item->bank->method_name }}</td>
                            <td>{{ @$item->amount }}</td>
                            <td>{{ @$item->transaction_type }}</td>
                            <td>
                                @if($item->status == 'paid')
                                <div class="badge badge-success">Paid</div>
                                @elseif($item->status == 'pending')
                                <div class="badge badge-danger">Pending</div>
                                @elseif($item->status == 'canceled')
                                <div class="badge badge-warning text-dark">Canceled</div>
                                @endif
                            </td>
                            <td>
                                <div class="actions ml-3">
                                    <a href="#" class="action-item customModal" data-toggle="modal" data-target="#editModal" data-accounts="{{ $item }}" data-original-title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" class="action-item deleteAccount" data-account-id="{{ $item->id }}" data-original-title="Delete">
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

<!-- Add Transaction Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Transaction Add</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <form id="addTransactionForm">
                        @csrf
                        <div class="row">
                            <!-- Add Transaction Form Fields -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="categoryId">Category Name</label>
                                    <select name="category_id" id="categoryId" class="form-select" required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $item)
                                        <option value="{{ $item->id }}">{{ $item->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="transactionTypeId">Transaction Type</label>
                                    <select name="transaction_type" id="transactionTypeId" class="form-control ">
                                        <option value="income" id="trxIncome">Income</option>
                                        <option value="expense" id="trxExpense">Expense</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="bankaAccountMethod">Transaction Method Method</label>
                                    <select name="account_method" id="accountMethod" class="form-select" required>
                                        @foreach($bank as $item)
                                        <option value="{{ $item->id }}">{{ $item->method_name }}</option>
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
                            <div class="col-lg-6 d-none">
                                <div class="form-group">
                                    <label for="created_by">Created By</label>
                                    <input type="text" name="created_by" id="createdBy" class="form-control" value="{{ Auth::user()->name }}" readonly>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="employeeName">Employee Name</label>
                                    <select name="employee_name" id="employeeName" class="form-select" required>
                                        @foreach($employee as $item)
                                        <option value="{{ $item->id }}">{{ $item->employee_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="statusType" class="form-select">
                                        <option value="pending">Pending</option>
                                        <option value="paid">Paid</option>
                                        <option value="canceled">Canceled</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" name="description" id="description" rows="3"></textarea>
                                </div>
                            </div>
                            <!-- End Add Transaction Form Fields -->
                        </div>
                        <button type="button" id="createTransaction" class="btn btn-primary">Add Transaction</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Transaction Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Transaction</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <form id="editTransactionForm">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="transaction_id" id="editTransactionId">
                        <div class="row">
                            <!-- Edit Transaction Form Fields -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="editCategoryId">Category Name</label>
                                    <select name="category_id" id="editCategoryId" class="form-select" required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $item)
                                        <option value="{{ $item->id }}">{{ $item->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="editTransactionType">Transaction Type</label>
                                    <select name="transaction_type" id="editTransactionType" class="form-control" >
                                        <option value="income" id="editTrxIncome">Income</option>
                                        <option value="expense" id="editTrxExpense">Expense</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="editBankaAccountMethod">Transaction Method Method</label>
                                    <select name="account_method" id="editBankaAccountMethod" class="form-select" required>
                                        @foreach($bank as $item)
                                        <option value="{{ $item->id }}">{{ $item->method_name }}</option>
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
                                    <input class="form-control" name="payment_date" type="date" value="" id="editPaymentDate">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="editAmount">Amount</label>
                                    <input type="number" id="editAmount" name="amount" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-lg-6 d-none">
                                <div class="form-group">
                                    <label for="editCreatedBy">Created By</label>
                                    <input type="text" name="created_by" id="editCreatedBy" class="form-control" value="{{ Auth::user()->name }}" readonly>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="etitEmployeeName">Employee Name</label>
                                    <select name="employee_name" id="etitEmployeeName" class="form-select" required>
                                        @foreach($employee as $item)
                                        <option value="{{ $item->id }}">{{ $item->employee_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" id="statusType" class="form-select">
                                        <option id="editStatus_pending"  value="pending">Pending</option>
                                        <option id="editStatus_paid" value="paid">Paid</option>
                                        <option id="editStatus_canceled" value="canceled">Canceled</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="editDescription">Description</label>
                                    <textarea class="form-control" name="description" id="editDescription" rows="3"></textarea>
                                </div>
                            </div>
                            <!-- End Edit Transaction Form Fields -->
                        </div>
                        <button type="button" id="editTransaction" class="btn btn-primary">Update Transaction</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')

<script>
    $(document).ready(function () {
    $('#categoryId, #editCategoryId').change(function () {
        var categoryId = $(this).val();
        $.ajax({
            url: '/getTransactionTypes/' + categoryId,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#transactionType, #editTransactionType').attr('disabled', true);
                $('#trxIncome, #trxExpense').attr('selected', false);
                $('#editTrxIncome, #editTrxExpense').attr('selected', false);

                if (data.category.transction_type == 'income') {
                    $('#trxIncome, #editTrxIncome').attr('selected', true);
                }
                if (data.category.transction_type == 'expense') {
                    $('#trxExpense, #editTrxExpense').attr('selected', true);
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });

});
</script>
<script>


    // Add Transaction
    $(document).ready(function() {
        // $('#transactionType').attr('disabled', true);
        $('#createTransaction').on('click', function() {
            // $('#transactionType, #editTransactionType').attr('disabled', true);
            var formData = $('#addTransactionForm').serialize();

            $.ajax({
                url: "{{ route('admin.accounts.store') }}",
                method: 'POST',
                data: formData,
                success: function(response) {
                    $('#addModal').modal('hide');
                    toastr.info('Transaction created successfully');
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

    // Edit Transaction
    $(document).ready(function() {
        $('.customModal').click(function(e) {
        e.preventDefault();
        var transaction = $(this).data('accounts');

        $('#editTransactionId').val(transaction.id);
        $('#editCategoryId').val(transaction.category_id);
        $('#editTransactionType').val(transaction.transaction_type);
        $('#editBankaAccountMethod').val(transaction.account_method);
        $('#editCustomerName').val(transaction.customer_name);
        $('#editPaymentDate').val(transaction.payment_date);
        $('#editAmount').val(transaction.amount);
        $('#etitEmployeeName').val(transaction.employee_name);
        $('#editStatus_'+ transaction.status).attr('selected',true);
        $('#editDescription').val(transaction.description);


        $('#editModal').modal('show');
    });

        $('#editTransaction').click(function() {
            $('#editTransactionType').attr('disabled', false);
            var formData = $('#editTransactionForm').serialize();
            var transactionId = $('#editTransactionId').val();

            $.ajax({
                url: "/admin/accounts/" + transactionId,
                method: 'PUT',
                data: formData,
                success: function(response) {
                    $('#editModal').modal('hide');
                    toastr.info('Transaction updated successfully');
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

    // Delete Transaction
    $(document).ready(function() {
        $('.deleteAccount').click(function(e) {
            e.preventDefault();
            var accountId = $(this).data('account-id');

            if (confirm('Are you sure you want to delete this transaction?')) {
                $.ajax({
                    url: "/admin/accounts/" + accountId,
                    method: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        toastr.info('Transaction deleted successfully');
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            }
        });
    });

</script>
@endpush

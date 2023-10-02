@extends('backend.layouts.master')

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">All Product</h4>
            <button type="button" class="btn btn-gradient-warning btn-rounded btn-fw " data-bs-toggle="modal" data-bs-target="#addModal">Add Category</button>

            <table class="table table-striped">
              <thead>
                <tr>
                  <th> Product Name</th>
                  <th> Action </th>
                </tr>
              </thead>
              <tbody>
                @foreach($product as $item)
                <tr>
                  <td> {{ $item->product_name }} </td>
                  <td>
                    <div class="actions ml-3">
                        <a href="#" class="action-item customModal" data-toggle="modal" data-target="#editModal" data-product="{{ $item }}" data-original-title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="#" class="action-item deleteProduct" data-product-id="{{ $item->id }}" data-original-title="Delete">
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
                <h5 class="modal-title" id="editModalLabel">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editProductForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="product_id" id="editProductId">
                    <div class="form-group">
                        <label for="editProductName">Product Name</label>
                        <input type="text" name="product_name" id="editProductName" class="form-control">
                    </div>
                    <button type="button" id="updateProductBtn" class="btn btn-primary" data-bs-dismiss="modal">Update Product</button>
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
          <h5 class="modal-title" id="addModalLabel">Product Add</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="card-body">
                <form>
                    @csrf
                    <div class="form-group">
                        <label for="product_name">Product Name</label>
                        <input type="text" id="product_name" class="form-control" required>
                    </div>
                    <button type="button" id="createProduct" class="btn btn-primary">Create Product</button>
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
        $('#createProduct').on('click', function() {
            $.ajax({
                url: "{{ route('admin.products.store') }}",
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    product_name: $('#product_name').val(),
                },
                success: function(response) {

                    console.log(response);

                    $('#addModal').modal('hide');
                    location.reload();
                    alert('Product created successfully');
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
            var product = $(this).data('product');
            $('#editProductId').val(product.id);
            $('#editProductName').val(product.product_name);
            $('#editModal').modal('show');
        });

        $('#updateProductBtn').click(function() {
            var formData = $('#editProductForm').serialize();
            var productId = $('#editProductId').val();


            $.ajax({
                url: "/admin/products/" + productId,
                method: 'PUT',
                data: formData,
                success: function(response) {
                    alert('Products Updated Successfully');
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

<script>
    $(document).ready(function() {
    $('.deleteProduct').click(function(e) {
        e.preventDefault();
        var productId = $(this).data('product-id');

        $.ajax({
            url: "{{ route('products.destroy', '') }}" + '/' + productId,
            method: 'DELETE',
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                alert('Product Deleted Successfully');
                location.reload(); 
            },
            error: function(error) {
                console.error(error);
            }
        });
    });
});
</script>

@endpush



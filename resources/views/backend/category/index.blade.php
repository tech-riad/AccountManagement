@extends('backend.layouts.master')

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">All Category</h4>
            <button type="button" class="btn btn-gradient-warning btn-rounded btn-fw " data-bs-toggle="modal" data-bs-target="#addModal">Add Category</button>

            <table class="table table-striped">
              <thead>
                <tr>
                  <th> Category </th>
                  <th> Type </th>
                  <th> Action </th>
                </tr>
              </thead>
              <tbody>
                @foreach($category as $item)
                <tr>
                  <td> {{ $item->category_name }} </td>
                  <td> {{ $item->category_type }} </td>
                  <td>
                    <div class="actions ml-3">
                        <a href="#" class="action-item customModal" data-toggle="modal" data-target="#editModal" data-category="{{ $item }}" data-original-title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="#" class="action-item deleteCategory" data-category-id="{{ $item->id }}" data-original-title="Delete">
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
                <h5 class="modal-title" id="editModalLabel">Edit Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editCategoryForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="category_id" id="editCategoryId">
                    <div class="form-group">
                        <label for="editCategoryName">Category Name</label>
                        <input type="text" name="category_name" id="editCategoryName" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="editCategoryType">Category Type</label>
                        <select name="category_type" id="editCategoryType" class="form-select" required>
                            <option value="income">Income</option>
                            <option value="expense">Expense</option>
                        </select>
                    </div>
                    <button type="button" id="updateCategoryBtn" class="btn btn-primary">Update Category</button>
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
          <h5 class="modal-title" id="addModalLabel">Category Add</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="card-body">
                <form>
                    @csrf
                    <div class="form-group">
                        <label for="category_name">Category Name</label>
                        <input type="text" id="category_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="category_type">Category Type</label>
                        <select id="category_type" class="form-select" required>
                            <option value="income">Income</option>
                            <option value="expense">Expense</option>
                        </select>
                    </div>
                    <button type="button" id="createCategory" class="btn btn-primary">Create Category</button>
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
        $('#createCategory').on('click', function() {
            $.ajax({
                url: "{{ route('admin.categories.store') }}",
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    category_name: $('#category_name').val(),
                    category_type: $('#category_type').val()
                },
                success: function(response) {

                    console.log(response);

                    $('#addModal').modal('hide');
                    location.reload();
                    alert('Category created successfully');
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
            var category = $(this).data('category');
            $('#editCategoryId').val(category.id);
            $('#editCategoryName').val(category.category_name);
            $('#editCategoryType').val(category.category_type);
            $('#editModal').modal('show');
        });

        $('#updateCategoryBtn').click(function() {
            var formData = $('#editCategoryForm').serialize();
            var categoryId = $('#editCategoryId').val();


            $.ajax({
                url: "/admin/categories/" + categoryId,
                method: 'PUT',
                data: formData,
                success: function(response) {
                    alert('Categories Updated Successfully');
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
    $('.deleteCategory').click(function(e) {
        e.preventDefault();
        var categoryId = $(this).data('category-id');

        $.ajax({
            url: "{{ route('categories.destroy', '') }}" + '/' + categoryId,
            method: 'DELETE',
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                alert('Categories Deleted Successfully');
                location.reload();
                $(this).closest('tr').remove();
            },
            error: function(error) {
                console.error(error);
            }
        });
    });
});

</script>
@endpush



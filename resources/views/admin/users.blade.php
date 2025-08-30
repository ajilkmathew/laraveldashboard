@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Manage Customers</h2>
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addUserModal">+ Add Customer</button>

    
    <div id="alert-container" class="mt-3"></div>

    
    <div id="customersTable">
        @include('admin.partials.customers_table', ['customers' => $customers])
    </div>
</div>


@include('admin.layouts.partials.add_user_modal')
@include('admin.layouts.partials.edit_user_modal')

@endsection

@push('scripts')
<script>
$(document).ready(function(){

   
    function showAlert(message, type = "success") {
        let alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`;
        $("#alert-container").html(alertHtml);
    }

    
    $(document).on('click', '.pagination a', function(e){
        e.preventDefault();
        let url = $(this).attr('href');
        $.get(url, function(data){
            $('#customersTable').html(data);
        });
    });

    
$('#addUserForm').submit(function(e){
    e.preventDefault();

    $.ajax({
        url: "{{ route('admin.users.store') }}",
        type: "POST",
        data: $(this).serialize(),
        success: function(res){
            $('#addUserModal').modal('hide');
            $('#addUserForm')[0].reset();
            loadCustomers(); 
        },
        error: function(xhr){
            alert("Error adding customer");
        }
    });
});

   
    $(document).on('click', '.edit-btn', function(){
        let id = $(this).data('id');
        $.get("{{ route('admin.users') }}/" + id + "/edit", function(data){
            $('#editUserForm [name=id]').val(data.id);
            $('#editUserForm [name=name]').val(data.name);
            $('#editUserForm [name=email]').val(data.email);
            $('#editUserModal').modal('show');
        });
    });

   
$('#editUserForm').submit(function(e){
    e.preventDefault();
    let id = $('#editUserForm [name=id]').val();

    $.ajax({
        url: "/admin/users/" + id,
        type: "POST", // Laravel needs POST
        data: $(this).serialize() + "&_method=PUT", // Append _method=PUT
        success: function(res){
            $('#editUserModal').modal('hide');
            loadCustomers();
        },
        error: function(xhr){
            console.log(xhr.responseText);
            alert("Error updating customer");
        }
    });
});

   
$(document).on('click', '.delete-btn', function(){
    if(!confirm("Are you sure you want to delete this customer?")) return;

    let id = $(this).data('id');

    $.ajax({
        url: "/admin/users/" + id,
        type: "POST", // Laravel needs POST
        data: {_token: "{{ csrf_token() }}", _method: "DELETE"}, 
        success: function(res){
            loadCustomers();
        },
        error: function(xhr){
            console.log(xhr.responseText);
            alert("Error deleting customer");
        }
    });
});



    // 🔹 Function to reload customers
    function loadCustomers(){
        $.get("{{ route('admin.users') }}", function(data){
            $('#customersTable').html(data);
        });
    }

});
</script>
@endpush

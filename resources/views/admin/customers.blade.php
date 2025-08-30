@extends('layouts.admin') 

@section('content')
<div class="container mt-4">
    <h2>Manage Customers</h2>

   
    <div class="modal fade" id="customerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="customerForm">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Add Customer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="customerId">
                        <div class="mb-3">
                            <label>Name</label>
                            <input type="text" id="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" id="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" id="password" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="saveCustomer">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

   
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#customerModal" onclick="resetForm()">Add Customer</button>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="customerTableBody">
           
        </tbody>
    </table>
</div>

@endsection

@section('scripts')
<script>
function resetForm(){
    $("#modalTitle").text("Add Customer");
    $("#customerId").val('');
    $("#name").val('');
    $("#email").val('');
    $("#password").val('');
}


function loadCustomers(){
    $.get("/admin/users", function(res){
        let rows = '';
        res.forEach(function(c){
            rows += `<tr>
                <td>${c.id}</td>
                <td>${c.name}</td>
                <td>${c.email}</td>
                <td>
                    <button class="btn btn-sm btn-primary" onclick="editCustomer(${c.id})">Edit</button>
                    <button class="btn btn-sm btn-danger" onclick="deleteCustomer(${c.id})">Delete</button>
                </td>
            </tr>`;
        });
        $("#customerTableBody").html(rows);
    });
}


$("#customerForm").submit(function(e){
    e.preventDefault();

    let id = $("#customerId").val();
    let data = {
        name: $("#name").val(),
        email: $("#email").val(),
        password: $("#password").val(),
        _token: "{{ csrf_token() }}"
    };

    let url = id ? `/admin/users/${id}` : "/admin/users";
    let type = id ? "PUT" : "POST";

    $.ajax({
        url: url,
        type: type,
        data: data,
        success: function(res){
            $("#customerModal").modal('hide');
            loadCustomers();
        },
        error: function(xhr){
            console.log(xhr.responseText);
        }
    });
});


function editCustomer(id){
    $.get(`/admin/users/${id}/edit`, function(res){
        $("#modalTitle").text("Edit Customer");
        $("#customerId").val(res.id);
        $("#name").val(res.name);
        $("#email").val(res.email);
        $("#password").val(''); // blank for new password
        $("#customerModal").modal('show');
    });
}


function deleteCustomer(id){
    if(!confirm("Are you sure?")) return;
    $.ajax({
        url: `/admin/users/${id}`,
        type: "DELETE",
        data: {_token: "{{ csrf_token() }}"},
        success: function(res){
            loadCustomers();
        },
        error: function(xhr){
            console.log(xhr.responseText);
        }
    });
}


$(document).ready(function(){
    loadCustomers();
});
</script>
@endsection

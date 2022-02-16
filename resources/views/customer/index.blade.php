<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Details</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" >

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container mt-2">

    <div class="row">

        <div class="col-md-12 card-header text-center font-weight-bold">
            <h2>Customer Details</h2>
        </div>
        <div class="col-md-2 mt-1 mb-2"><a href="{{ url('/home') }}" type="button" class="btn btn-success">Back</a></div>
        <div class="col-md-2 mt-1 mb-2"><button type="button" id="addNewCustomer" class="btn btn-success">Add</button></div>

        <div class="col-md-12">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">name</th>
                    <th scope="col">email</th>
{{--                    <th scope="col">password</th>--}}
                    <th scope="col">address</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($customers as $key => $c)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $c->name }}</td>
                        <td>{{ $c->email }}</td>
{{--                        <td>{{ $c->password }}</td>--}}
                        <td>{{ $c->address }}</td>
                        <td>
                            <a href="javascript:void(0)" class="btn btn-primary edit" data-id="{{ $c->id }}">Edit</a>
                            <a href="javascript:void(0)" class="btn btn-primary delete" data-id="{{ $c->id }}">Delete</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {!! $customers->links() !!}
        </div>
    </div>
</div>

<!-- boostrap model -->
<div class="modal fade" id="ajax-customer-model" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="ajaxCustomerModel"></h4>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" id="addEditCustomerForm" name="addEditCustomerForm" class="form-horizontal" method="POST">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Customer Name" value="" maxlength="50" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">email</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="email" name="email" placeholder="Enter Customer email" value="" maxlength="50" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">password</label>
                        <div class="col-sm-12">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" value="" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Address</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="address" name="address" placeholder="Enter address" value="" required="">
                        </div>
                    </div>

                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="btn-save" value="addNewCustomer">Save changes
                        </button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
<!-- end bootstrap model -->
<script type="text/javascript">
    $(document).ready(function($){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#addNewCustomer').click(function () {
            $('#addEditCustomerForm').trigger("reset");
            $('#ajaxCustomerModel').html("Add customer");
            $('#ajax-customer-model').modal('show');
        });

        $('body').on('click', '.edit', function () {

            var id = $(this).data('id');

            // ajax
            $.ajax({
                type:"POST",
                url: "{{ url('edit-customer') }}",
                data: { id: id },
                dataType: 'json',
                success: function(res){
                    $('#ajaxCustomerModel').html("Edit Customer");
                    $('#ajax-customer-model').modal('show');
                    $('#id').val(res.id);
                    $('#name').val(res.name);
                    $('#email').val(res.email);
                    // $('#password').val(res.password);
                    $('#address').val(res.address);
                }
            });

        });

        $('body').on('click', '.delete', function () {

            if (confirm("Delete Record?") == true) {
                var id = $(this).data('id');

                // ajax
                $.ajax({
                    type:"POST",
                    url: "{{ url('delete-customer') }}",
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){

                        window.location.reload();
                    }
                });
            }

        });

        $('body').on('click', '#btn-save', function (event) {

            var id = $("#id").val();
            var name = $("#name").val();
            var email = $("#email").val();
            var password = $("#password").val();
            var address = $("#address").val();

            $("#btn-save").html('Please Wait...');
            $("#btn-save"). attr("disabled", true);

            // ajax
            $.ajax({
                type:"POST",
                url: "{{ url('add-update-customer') }}",
                data: {
                    id:id,
                    name:name,
                    email:email,
                    password:password,
                    address:address,
                },
                dataType: 'json',
                success: function(res){
                    window.location.reload();
                    $("#btn-save").html('Submit');
                    $("#btn-save"). attr("disabled", false);
                }
            });

        });

    });
</script>
</body>
</html>

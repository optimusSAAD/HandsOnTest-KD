<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bill Details</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" >

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container mt-2">

    <div class="row">

        <div class="col-md-12 card-header text-center font-weight-bold">
            <h2>Bill Details</h2>
        </div>
        <div class="col-md-2 mt-1 mb-2"><a href="{{ url('/home') }}" type="button" class="btn btn-success">Back</a></div>
        <div class="col-md-2 mt-1 mb-2"><button type="button" id="addNewBill" class="btn btn-success">Add</button></div>

        <div class="col-md-12">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">customer name</th>
                    <th scope="col">month</th>
                    <th scope="col">year</th>
                    <th scope="col">amount</th>
                    <th scope="col">status</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($bills as $key => $c)
                    @php($monthName = date('F', mktime(0, 0, 0, $c->month, 10)))
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{$c->user->name }}</td>
                        <td>{{$monthName}}</td>
                        <td>{{ $c->year }}</td>
                        <td>{{ $c->amount }}</td>
                        <td>{{ $c->status }}</td>
                        <td>
                            <a href="javascript:void(0)" class="btn btn-primary edit" data-id="{{ $c->id }}">Edit</a>
                            <a href="javascript:void(0)" class="btn btn-primary delete" data-id="{{ $c->id }}">Delete</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {!! $bills->links() !!}
        </div>
    </div>
</div>

<!-- boostrap model -->
<div class="modal fade" id="ajax-bill-model" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="ajaxBillModel"></h4>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" id="addEditBillForm" name="addEditBillForm" class="form-horizontal" method="POST">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group" >
                        <label for="name" class="col-sm-2 control-label">Customer Name</label>
                        <div class="col-sm-12">
                            @php($user_id = DB::table('users')->select('id', 'name')->where('isadmin','0')->get())
                            <select class="browser-default custom-select" name="userid" id="userid">
                                <option selected>Select customer</option>
                                @foreach ($user_id as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">month</label>
                        <div class="col-sm-12">
                            <select class="browser-default custom-select" name="month" id="month">
                                <option selected>Select</option>
                                <option value="1">January</option>
                                <option value="2">February</option>
                                <option value="3">March</option>
                                <option value="4">April</option>
                                <option value="5">May</option>
                                <option value="6">June</option>
                                <option value="7">July</option>
                                <option value="8">August</option>
                                <option value="9">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">year</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="year" name="year" placeholder="Enter Bill year" value="" maxlength="50" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Amount</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="amount" name="amount" placeholder="Enter Bill amount" value="" maxlength="50" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">stauts</label>
                        <div class="col-sm-12">
                            <select class="browser-default custom-select" name="status" id="status">
                                <option selected>Select</option>
                                    <option value="due">due</option>
                                    <option value="paid">paid</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="btn-save" value="addNewBill">Save changes
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

        $('#addNewBill').click(function () {
            $('#addEditBillForm').trigger("reset");
            $('#ajaxBillModel').html("Add Bill");
            $('#ajax-bill-model').modal('show');
        });

        $('body').on('click', '.edit', function () {

            var id = $(this).data('id');

            // ajax
            $.ajax({
                type:"POST",
                url: "{{ url('edit-bill') }}",
                data: { id: id },
                dataType: 'json',
                success: function(res){
                    $('#ajaxBillModel').html("Edit Bill");
                    $('#ajax-bill-model').modal('show');
                    $('#id').val(res.id);
                    $('#userid').val(res.user_id);
                    $('#month').val(res.month);
                    $('#year').val(res.year);
                    $('#amount').val(res.amount);
                    $('#status').val(res.status);
                }
            });

        });

        $('body').on('click', '.delete', function () {

            if (confirm("Delete Record?") == true) {
                var id = $(this).data('id');

                // ajax
                $.ajax({
                    type:"POST",
                    url: "{{ url('delete-bill') }}",
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
            var userid = $("#userid").val();
            var month = $("#month").val();
            var year = $("#year").val();
            var amount = $("#amount").val();
            var status = $("#status").val();

            $("#btn-save").html('Please Wait...');
            $("#btn-save"). attr("disabled", true);

            // ajax
            $.ajax({
                type:"POST",
                url: "{{ url('add-update-bill') }}",
                data: {
                    id:id,
                    userid:userid,
                    month:month,
                    year:year,
                    amount:amount,
                    status:status,
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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <div class="container">
        <h1 class=" text-center">CRUD Using Ajax-Jquery Laravel </h1>
        <div class="row">
            <div class="col">

                <form id="myform" class="col-6 offset-3 mt-5">
                    @csrf
                    <div class="form-group">
                        <label for="">Select State</label>
                        <select name="state_id" class="form-control">
                            @foreach ($states as $state)
                                <option value="{{ $state->id }}">{{ $state->state_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group  my-2">
                        <label for="">City Name</label>
                        <input type="text" name="city_name" required class="form-control">
                    </div>
                    <button id="submit" class="btn btn-success">Add City</button>
                </form>

            </div>
        </div>

        <hr>
        <div class="row">
            <div class="col">
                <table id="myTable" class="table table-bordered">
                    <thead>
                        <tr>
                    <th>City</th>
                    <th>State</th>
                    <th>Status</th>
                    <th>Edit</th>
                    <th>Delete</th>
                        </tr>
                   </thead>
                
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Button trigger modal -->

  
  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Update City</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="updateForm">
            @csrf
            <input type="hidden" name="id">

            <label for="">Select State</label>
            <select name="edit_state_id" class="form-control">
            @foreach ($states as $state)
            <option value="{{ $state->id }}">{{ $state->state_name }}</option>
            @endforeach
            </select>

            <div class="form-group">
            <label for="">City Name</label>
            <input name="edit_city_name" type="text" class="form-control">
            </div>
            
            <label for="">Status</label>
             <select name="edit_status" class="form-control">
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
             </select>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button id="update" type="button" class="btn btn-primary">Update city</button>
        </div>
      </div>
    </div>
  </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" ></script>

    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    {{-- <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script> --}}


    <script>
        
        $(document).ready(function() {

            //data inserted
            $('#submit').click(function(e) {
                e.preventDefault();

                $.ajax({
                    url: " {{ url('addCity') }}",
                    type: "post",
                    dataType: "json",
                    data: $('#myform').serialize(),
                    success: function(response) {
                        $('#myform')[0].reset();                
                        $('#myTable').DataTable().ajax.reload();      //to reload the table after data  insert
                        console.log("response is: ", response);
                    }
                });
            })
        });

       // get or data displayed
        var table = $(document).ready(function() {
            $("#myTable").DataTable({
                // ajax:"{{ url('getCities') }}",
                ajax: {
                    url: "{{ url('getCities') }}",
                    dataSrc: 'cities' // Assuming 'cities' is the key in your JSON response containing the array of cities
                },
                columns: [{
                        data: 'city_name'
                    },
                    {
                        data: 'state_name'
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            if (row.status == 'Active') {
                                return `<button class='btn btn-sm btn-success'>${ row.status }</button>`;
                            } else {
                                return `<button class='btn btn-sm btn-warning'>${ row.status }</button>`;
                            }
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `<button data-id='${row.id}' id="edit" class='btn btn-info'><li class="fa fa-edit" data-bs-toggle="modal" data-bs-target="#exampleModal"></li></button>`;
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `<button data-id="${row.id}" id="delete" class='btn btn-danger'><li class="fa fa-trash"></li></button>`;
                        }
                    },
                ]
            });

        });


        //edit city
        $(document).on("click","#edit",function(){
            // var cityId = $(this).data('id');
            $.ajax({
                url:"{{ url('getCityByID') }}",
                type:"get",
                dataType:"json",
                data:{
                    "id":$(this).data('id')
                },
                success:function(response){
                    // console.log(response.data);
                    $('input[name="id"]').val(response.data.id);
                    $('select[name="edit_state_id"]').val(response.data.state_id);
                    $('input[name="edit_city_name"]').val(response.data.city_name);
                    $('select[name="edit_status"]').val(response.data.status);
                }
            })
        })


        //update city
        $(document).on('click','#update',function(){
            if(confirm('Are you sure want to update?')){
                $.ajax({
                    url:"{{ url("updateCity") }}",
                    type:"post",
                    dataType:"json",
                    data:$("#updateForm").serialize(),
                    success:function(response){
                        console.log(response);
                        $('#updateForm')[0].reset();
                        $("#exampleModal").modal('hide');
                        $("#myTable").DataTable().ajax.reload();
                    }
                })
            }
        })

        //Delete
        $(document).on("click",'#delete',function(){
            if(confirm("Are you sure want to delete?")){
                $.ajax({
                    url:"{{ url("deleteCity") }}",
                    type:"post",
                    dataType:"json",
                    data:{
                         "_token":"{{ csrf_token() }}",
                         "id":$(this).data('id')
                    },
                    success:function(response){
                        console.log(response);
                        $("#myTable").DataTable().ajax.reload();
                    }
                })
            }
        })
    </script>
</body>
</html>

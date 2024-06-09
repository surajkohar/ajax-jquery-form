<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .blur {
            filter: blur(0px);
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2>Bootstrap Form Example</h2>
        <form>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="exampleInputName" class="form-label">Name</label>
                    <input type="text" class="form-control" id="exampleInputName" placeholder="Enter your name">
                </div>
                <div class="col-md-6">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                </div>
                <div class="col-md-6">
                    <label for="exampleInputPhone" class="form-label">Phone Number</label>
                    <input type="tel" class="form-control" id="exampleInputPhone"
                        placeholder="Enter your phone number">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="exampleInputAddress" class="form-label">Address</label>
                    <input type="text" class="form-control" id="exampleInputAddress"
                        placeholder="Enter your address">
                </div>
                <div class="col-md-6 position-relative">
                    <label for="exampleInputStreet" class="form-label">Street</label>
                    <div class="input-group">
                        <input type="text" class="form-control blur" id="exampleInputStreet"
                            placeholder="Enter your street" disabled>
                        <button class="btn btn-outline-secondary" type="button" id="editStreetBtn">
                            <i class="bi bi-pencil"></i>
                        </button>
                    </div>
                    <button class="btn btn-success mt-2 d-none" type="button" id="saveStreetBtn">Save</button>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="exampleInputCity" class="form-label">City</label>
                    <input type="text" class="form-control" id="exampleInputCity" placeholder="Enter your city">
                </div>
                <div class="col-md-4">
                    <label for="exampleInputState" class="form-label">State</label>
                    <input type="text" class="form-control" id="exampleInputState" placeholder="Enter your state">
                </div>
                <div class="col-md-4">
                    <label for="exampleInputZip" class="form-label">Zip</label>
                    <input type="text" class="form-control" id="exampleInputZip" placeholder="Enter your zip">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('editStreetBtn').addEventListener('click', function() {
            var streetInput = document.getElementById('exampleInputStreet');
            streetInput.disabled = false;
            streetInput.classList.remove('blur');
            document.getElementById('saveStreetBtn').classList.remove('d-none');
        });

        document.getElementById('saveStreetBtn').addEventListener('click', function() {
            var streetInput = document.getElementById('exampleInputStreet');
            streetInput.disabled = true;
            streetInput.classList.add('blur');
            this.classList.add('d-none');
        });
    </script>
</body>

</html>


<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <div class="row text-center mt-3">
        <form method="POST" action="{{ route('customer.import') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <label for="uploadfile" class="form-label">Import File Excel</label>
            <input class="form_control" type="file" name="csv_file">
            <button class="btn btn-primary" type="submit">Import</button>
            <a class="btn btn-danger" href="{{ route('customer.delete') }}">Delete All</a>
        </form>

    </div>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->has('csv_file'))
        <div class="alert alert-danger">
            {{ $errors->first('csv_file') }}
        </div>
    @endif
    <hr>
    <div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Phone</th>
            <th scope="col">Email</th>
        </tr>
        </thead>
        <tbody>
        @if(!empty($customers))
            @foreach($customers as $customer)
                <tr>
                    <th scope="row">{{ $customer->id }}</th>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->phone }}</td>
                    <td>{{ $customer->address }}</td>
                </tr>
            @endforeach
        @else
            <p>No data</p>
        @endif

        </tbody>
    </table>
        @if(!empty($customers))
            {{ $customers->links() }}
        @endif
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>
</html>

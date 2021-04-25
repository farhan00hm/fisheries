@extends('admin.main-template')
@section('others')
    <div class="span9">
        @if(Session::has('success'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">×</button>
                {{ Session::get('success') }}
            </div>
        @endif
        <div id="excel-upload-form">
            <form action="{{url('/admin/others')}}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="file" name="other_files[]" id="excel-file-uploader"  multiple>
                <button type="submit" class="btn"  >Upload</button>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </form>
        </div>


        {{--            TODO need to show success and failure file--}}

        {{--            Table Section--}}
        @if(count($others)> 0)
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>File</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($others as $other)
                    <tr>
                        <td>{{ $other->id }}</td>
                        <td>{{ $other->file_name }}</td>
                        <td><a class="btn btn-danger">Delete</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <h5 style="color: red"> No Files Found!!!</h5>
        @endif
    </div>
@endsection

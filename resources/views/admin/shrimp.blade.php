@extends('admin.main-template')
@section('shrimp')
    <div class="span9">
        @if(Session::has('success'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">×</button>
                {{ Session::get('success') }}
            </div>
        @endif
        <div id="excel-upload-form">
            <form action="{{url('/admin/shrimp')}}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="file" name="shrimp_files[]" id="excel-file-uploader"  multiple>
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
                {{--                @error('excelFile')--}}
                {{--                <span class="invalid-feedback" role="alert">--}}
                {{--                            <strong> {{ $message }} </strong>--}}
                {{--                        </span>--}}
                {{--                @enderror--}}
            </form>
        </div>


        {{--            TODO need to show success and failure file--}}

        {{--            Table Section--}}
        @if(count($shrimps)> 0)
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>File</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($shrimps as $shrimp)
                    <tr>
                        <td>{{ $shrimp->id }}</td>
                        <td>{{ $shrimp->file_name }}</td>
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

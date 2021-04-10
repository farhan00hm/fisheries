@extends('admin.main-template')
@section('capture')
    <div class="span9">
        @if(Session::has('success'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert">×</button>
                {{ Session::get('success') }}
            </div>
        @endif
        <div id="excel-upload-form">
            <form action="{{url('/admin/capture')}}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="file" name="capture_files[]" id="excel-file-uploader">
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
    </div>
@endsection

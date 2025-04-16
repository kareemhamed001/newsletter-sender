<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app-url" content="{{ url('/') }}">
    <title>Madar Kids</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">

    <link rel="stylesheet" href="https://unpkg.com/@yaireo/tagify/dist/tagify.css">
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

</head>

<body>
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @elseif (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>


                    @endif
                    <h5 class="mb-0 h6">Send Newsletter</h5>

                </div>

                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('newsletters.send') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row mb-2">
                            <label class="col-sm-2 col-from-label" for="name">Emails (Users)</label>
                            <div class="col-sm-10">
                                <select class="form-control aiz-selectpicker" name="user_emails[]" multiple
                                    data-selected-text-format="count" data-actions-box="true">
                                    @foreach($users as $user)
                                        <option value="{{$user->email}}">{{$user->email}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if ($errors->has('user_emails'))
                                <div class="invalid-feedback d-block">
                                    {{ $errors->first('user_emails') }}
                                </div>

                            @endif
                        </div>
                        <div class="form-group row mb-2">
                            <label class="col-sm-2 col-from-label" for="name">Emails (press enter)
                            </label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control aiz-tag-input" id="tags" name="emails"
                                    placeholder="Enter email and press enter" value="">

                            </div>
                            @if ($errors->has('emails'))
                                <div class="invalid-feedback d-block">
                                    {{ $errors->first('emails') }}
                                </div>

                            @endif
                        </div>
                        <div class="form-group row mb-2">
                            <label class="col-sm-2 col-from-label" for="name">Emails Excel
                            </label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" name="emails_file"
                                    accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                            </div>
                            @if ($errors->has('emails_file'))
                                <div class="invalid-feedback d-block">
                                    {{ $errors->first('emails_file') }}
                                </div>

                            @endif
                        </div>
                        <div class="form-group row mb-2">
                            <label class="col-sm-2 col-from-label" for="subject">Newsletter subject</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="subject" id="subject" required>
                            </div>
                            @if ($errors->has('subject'))
                                <div class="invalid-feedback d-block">
                                    {{ $errors->first('subject') }}
                                </div>

                            @endif
                        </div>
                        <div class="form-group row mb-2">
                            <label class="col-sm-2 col-from-label" for="name">Newsletter content</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="text-ckeditor" name="content"></textarea>
                            </div>
                            @if ($errors->has('content'))
                                <div class="invalid-feedback d-block">
                                    {{ $errors->first('content') }}
                                </div>

                            @endif
                        </div>
                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-primary">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="https://unpkg.com/@yaireo/tagify"></script>
    <script>
        let tagsInput = document.querySelector('#tags');

        let tagify = new Tagify(tagsInput);

    </script>
    <script>
        ClassicEditor
            .create(document.querySelector('#text-ckeditor'))
            //validate email 
            .catch(error => {
                console.error(error);
            });
    </script>
</body>

</html>
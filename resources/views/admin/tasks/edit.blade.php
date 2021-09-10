@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="fade-in">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        @if ($errors->store_task->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->store_task->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form
                            action="{{ route('admin.checklists.tasks.update', [$checklist, $task]) }}"
                            method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-header"><h3>{{ __('Edit Task') }}</h3></div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="name">{{ __('Name') }}</label>
                                            <input value="{{$task->name}}" class="form-control" id="name"
                                                   name="name" type="text">
                                        </div>
                                        <div class="form-group">
                                            <label for="task-textarea">{{ __('Description') }}</label>
                                            <textarea class="form-control text-left" id="task-textarea"
                                                   name="description" rows="5">{{$task->description}}
                                            </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-sm btn-success" type="submit">{{ __('Save Task') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @include('admin.ckeditor')
@endsection

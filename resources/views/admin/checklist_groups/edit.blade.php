@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="fade-in">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.checklist-groups.update', $checklistGroup) }}" method="POST">
                        @csrf
                        @method('PUT')
                    <div class="card-header"><h3>{{ __('Edit Checklist Group') }}</h3></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="name">{{ __('Name') }}</label>
                                    <input value="{{ $checklistGroup->name }}" class="form-control" id="name" name="name" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-sm btn-success" type="submit">{{ __('Save') }}</button>
                        </div>
                    </div>
                    </form>

                </div>
                <form action="{{ route('admin.checklist-groups.destroy', $checklistGroup) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger" type="submit" onclick="return confirm('{{ __('Are you sure?') }}')">
                        {{ __('Delete This Checklist Group') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

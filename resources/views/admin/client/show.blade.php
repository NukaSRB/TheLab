@extends('backpack::layout')

@section('content-header')
  <section class="content-header">
    <h1>
      {{ trans('backpack::crud.preview') }} <span class="text-lowercase">{{ $crud->entity_name }}</span>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a>
      </li>
      <li><a href="{{ url($crud->route) }}" class="text-capitalize">{{ $crud->entity_name_plural }}</a></li>
      <li class="active">{{ trans('backpack::crud.preview') }}</li>
    </ol>
  </section>
@endsection

@section('content')
  <a href="{{ url($crud->route) }}">
    <i class="fa fa-angle-double-left"></i>
    {{ trans('backpack::crud.back_to_all') }}
    <span class="text-lowercase">{{ $crud->entity_name_plural }}</span>
  </a>
  <br />
  <br />

  <div class="row">
    <div class="col-sm-3">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">
            {{ ucwords($crud->entity_name) }}: {{ $entry->label }}
          </h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-sm-3">
              <strong>Projects</strong>
            </div>
            <div class="col-sm-9">
              @if ($entry->projects->count() > 0)
                @foreach ($entry->projects as $project)
                  <a href="{{ route('admin.project.show', $project->id) }}" class="text-blue">
                    {{ $project->label }}
                  </a>
                  <br />
                @endforeach
              @else
                No projects for this client.
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

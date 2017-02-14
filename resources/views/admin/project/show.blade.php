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
          @if ($entry->billable_flag)
            <span class="label label-success">Billable</span>
          @endif
          @if ($entry->active_flag)
            <span class="label label-info">Active</span>
          @else
            <span class="label label-default">Inactive</span>
          @endif
          @if ($entry->private_flag)
            <span class="label label-danger">Private</span>
          @endif
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-sm-2">
              <strong>Tasks</strong>
            </div>
            <div class="col-sm-10">
              @if ($entry->tasks->count() > 0)
                @foreach ($entry->tasks as $task)
                  <a href="{{ route('crud.task.show', $task->id) }}" class="text-blue">
                    {{ $task->label }}
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
{{--<div class="columns">--}}
  {{--<div class="column is-one-quarter">--}}
    {{--<div class="card is-fullwidth">--}}
      {{--<header class="card-header">--}}
        {{--<p class="card-header-title">Project: {{ $project->label }}</p>--}}
        {{--<div class="card-header-right">--}}
          {{--@if ($project->billable_flag)--}}
            {{--<span class="tag is-success is-small">Billable</span>--}}
          {{--@endif--}}
          {{--@if ($project->active_flag)--}}
            {{--<span class="tag is-info is-small">Active</span>--}}
          {{--@else--}}
            {{--<span class="tag is-grey is-small">Inactive</span>--}}
          {{--@endif--}}
          {{--@if ($project->private_flag)--}}
            {{--<span class="tag is-danger is-small">Private</span>--}}
          {{--@endif--}}
        {{--</div>--}}
      {{--</header>--}}
      {{--<div class="card-content">--}}
        {{--<div class="columns">--}}
          {{--<div class="column is-one-third">--}}
            {{--<strong>Client</strong>--}}
          {{--</div>--}}
          {{--<div class="column is-two-thirds">--}}
            {{--<a href="{{ route('admin.client.show', $project->client_id) }}" class="text-blue">--}}
              {{--{{ $project->client->label }}--}}
            {{--</a>--}}
          {{--</div>--}}
        {{--</div>--}}
        {{--<div class="columns">--}}
          {{--<div class="column is-one-third">--}}
            {{--<strong>Tasks</strong>--}}
          {{--</div>--}}
          {{--<div class="column is-two-thirds">--}}
            {{--@foreach ($project->tasks as $task)--}}
              {{--<a href="{{ route('admin.task.show', $task->id) }}" class="text-blue">--}}
                {{--{{ $task->label }}--}}
              {{--</a>--}}
              {{--<br />--}}
            {{--@endforeach--}}
          {{--</div>--}}
        {{--</div>--}}
      {{--</div>--}}
    {{--</div>--}}
  {{--</div>--}}
{{--</div>--}}

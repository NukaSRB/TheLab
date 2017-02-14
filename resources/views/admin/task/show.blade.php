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
    <div class="col-sm-4">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">
            {{ ucwords($crud->entity_name) }}: {{ $entry->label }}
          </h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-sm-3">
              <strong>Client</strong>
            </div>
            <div class="col-sm-9">
              <a href="{{ route('crud.client.show', $entry->project->client_id) }}" class="text-blue">
                {{ $entry->project->client->label }}
              </a>
            </div>
          </div>
          <br />
          <div class="row">
            <div class="col-sm-3">
              <strong>Project</strong>
            </div>
            <div class="col-sm-9">
              <a href="{{ route('crud.project.show', $entry->project_id) }}" class="text-blue">
                {{ $entry->project->label }}
              </a>
            </div>
          </div>
          <br />
          <div class="row">
            <div class="col-sm-3">
              <strong>Project Tasks</strong>
            </div>
            <div class="col-sm-9">
              @foreach ($entry->project->tasks as $projectTask)
                @if ($projectTask->id !== $entry->id)
                  <a href="{{ route('crud.task.show', $projectTask->id) }}" class="text-blue">
                    {{ $projectTask->label }}
                  </a>
                  <br />
                @endif
              @endforeach
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
        {{--<p class="card-header-title">Task: {{ $task->label }}</p>--}}
        {{--<div class="card-header-right">--}}
          {{--@if ($task->active_flag)--}}
            {{--<span class="tag is-info is-small">Active</span>--}}
          {{--@else--}}
            {{--<span class="tag is-grey is-small">Inactive</span>--}}
          {{--@endif--}}
        {{--</div>--}}
      {{--</header>--}}
      {{--<div class="card-content">--}}
        {{--<div class="columns">--}}
          {{--<div class="column is-one-third">--}}
            {{--<strong>Client</strong>--}}
          {{--</div>--}}
          {{--<div class="column is-two-thirds">--}}
            {{--<a href="{{ route('admin.client.show', $task->project->client_id) }}" class="text-blue">--}}
              {{--{{ $task->project->client->label }}--}}
            {{--</a>--}}
          {{--</div>--}}
        {{--</div>--}}
        {{--<div class="columns">--}}
          {{--<div class="column is-one-third">--}}
            {{--<strong>Project</strong>--}}
          {{--</div>--}}
          {{--<div class="column is-two-thirds">--}}
            {{--<a href="{{ route('admin.project.show', $task->project_id) }}" class="text-blue">--}}
              {{--{{ $task->project->label }}--}}
            {{--</a>--}}
          {{--</div>--}}
        {{--</div>--}}
        {{--<div class="columns">--}}
          {{--<div class="column is-one-third">--}}
            {{--<strong>Project Tasks</strong>--}}
          {{--</div>--}}
          {{--<div class="column is-two-thirds">--}}
            {{--@foreach ($task->project->tasks as $projectTask)--}}
              {{--@if ($projectTask->id !== $task->id)--}}
                {{--<a href="{{ route('admin.task.show', $projectTask->id) }}" class="text-blue">--}}
                  {{--{{ $projectTask->label }}--}}
                {{--</a>--}}
                {{--<br />--}}
              {{--@endif--}}
            {{--@endforeach--}}
          {{--</div>--}}
        {{--</div>--}}
      {{--</div>--}}
    {{--</div>--}}
  {{--</div>--}}
{{--</div>--}}

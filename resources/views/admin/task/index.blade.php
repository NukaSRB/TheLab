{{ $tasks->render() }}
<br />
<table class="table is-striped">
  <thead>
    <tr>
      <th>Name</th>
      <th style="width: 200px;">Project</th>
      <th style="width: 200px;">Client</th>
      <th style="width: 100px;">Toggl</th>
      <th style="width: 40px;">Color</th>
      <th style="width: 100px;">
        <a href="{{ route('admin.task.create') }}" class="button is-primary is-icon-only is-small is-pulled-right">
          <span class="icon is-small">
            <i class="fa fa-fw fa-plus"></i>
          </span>
        </a>
      </th>
    </tr>
  </thead>
  <tbody>
    @if (count($tasks) > 0)
      @foreach ($tasks as $task)
        <tr>
          <td>{{ $task->label }}</td>
          <td>{{ $task->project->label }}</td>
          <td>{{ $task->project->client->label }}</td>
          <td>
            <a href="https://www.toggl.com/app/workspaces/{{ env('TOGGL_WORKSPACE_ID') }}/tasks/{{ $task->toggl_id }}"
               target="_blank"
               class="button has-icon is-danger is-outlined is-small"
            >
              <span class="icon is-small">
                <i class="fa fa-power-off"></i>
              </span>
              <span>Toggl</span>
            </a>
          </td>
          <td>
            <div style="width: 25px; height: 25px; background-color: #{{ $task->color }};">&nbsp;</div>
          </td>
          <td>
            <p class="control has-addons is-pulled-right">
              <a href="{{ route('admin.task.show', $task->id) }}" class="button is-small is-icon-only is-primary is-outlined">
                <span class="icon is-small">
                  <i class="fa fa-fw fa-eye"></i>
                </span>
              </a>
              <a href="{{ route('admin.task.edit', $task->id) }}" class="button is-small is-icon-only is-primary is-outlined">
                <span class="icon is-small">
                  <i class="fa fa-fw fa-edit"></i>
                </span>
              </a>
              <a href="{{ route('admin.task.delete', $task->id) }}" class="button is-small is-icon-only is-danger is-outlined">
                <span class="icon is-small">
                  <i class="fa fa-fw fa-trash"></i>
                </span>
              </a>
            </p>
          </td>
        </tr>
      @endforeach
    @else
      <tr>
        <td colspan="4">No tasks found.</td>
      </tr>
    @endif
  </tbody>
</table>
{{ $tasks->render() }}

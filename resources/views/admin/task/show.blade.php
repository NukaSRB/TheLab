<div class="columns">
  <div class="column is-one-quarter">
    <div class="card is-fullwidth">
      <header class="card-header">
        <p class="card-header-title">Task: {{ $task->label }}</p>
        <div class="card-header-right">
          @if ($task->active_flag)
            <span class="tag is-info is-small">Active</span>
          @else
            <span class="tag is-grey is-small">Inactive</span>
          @endif
        </div>
      </header>
      <div class="card-content">
        <div class="columns">
          <div class="column is-one-third">
            <strong>Client</strong>
          </div>
          <div class="column is-two-thirds">
            <a href="{{ route('admin.client.show', $task->project->client_id) }}" class="text-blue">
              {{ $task->project->client->label }}
            </a>
          </div>
        </div>
        <div class="columns">
          <div class="column is-one-third">
            <strong>Project</strong>
          </div>
          <div class="column is-two-thirds">
            <a href="{{ route('admin.project.show', $task->project_id) }}" class="text-blue">
              {{ $task->project->label }}
            </a>
          </div>
        </div>
        <div class="columns">
          <div class="column is-one-third">
            <strong>Project Tasks</strong>
          </div>
          <div class="column is-two-thirds">
            @foreach ($task->project->tasks as $projectTask)
              @if ($projectTask->id !== $task->id)
                <a href="{{ route('admin.task.show', $projectTask->id) }}" class="text-blue">
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

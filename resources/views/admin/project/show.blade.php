<div class="columns">
  <div class="column is-one-quarter">
    <div class="card is-fullwidth">
      <header class="card-header">
        <p class="card-header-title">Project: {{ $project->label }}</p>
      </header>
      <div class="card-content">
        <div class="columns">
          <div class="column">
            @if ($project->billable_flag)
              <span class="tag is-success is-small">Billable</span>
            @endif
            @if ($project->active_flag)
              <span class="tag is-info is-small">Active</span>
            @endif
            @if ($project->private_flag)
              <span class="tag is-danger is-small">Private</span>
            @endif
          </div>
        </div>
        <div class="columns">
          <div class="column is-one-third">
            <strong>Client</strong>
          </div>
          <div class="column is-two-thirds">
            <a href="{{ route('admin.client.show', $project->client_id) }}" class="text-blue">
              {{ $project->client->label }}
            </a>
          </div>
        </div>
        <div class="columns">
          <div class="column is-one-third">
            <strong>Tasks</strong>
          </div>
          <div class="column is-two-thirds">
            @foreach ($project->tasks as $task)
              <a href="{{ route('admin.client.show', $task->id) }}" class="text-blue">
                {{ $task->label }}
              </a>
              <br />
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="columns">
  <div class="column is-one-quarter">
    <div class="card is-fullwidth">
      <header class="card-header">
        <p class="card-header-title">Client: {{ $client->label }}</p>
      </header>
      <div class="card-content">
        <div class="columns">
          <div class="column is-one-third">
            <strong>Projects</strong>
          </div>
          <div class="column is-two-thirds">
            @if ($client->projects->count() > 0)
              @foreach ($client->projects as $project)
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

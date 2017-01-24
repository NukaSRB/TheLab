<div class="columns">
  <div class="column is-4 is-offset-4 is-centered">
    {{ $clients->render() }}
  </div>
</div>
<table class="table is-striped">
  <thead>
    <tr>
      <th>Name</th>
      <th>Abbreviation</th>
      <th style="width: 100px;">Toggl</th>
      <th style="width: 100px;">Asana</th>
      <th style="width: 40px;">Color</th>
      <th style="width: 210px;">
        <a href="{{ route('admin.client.create') }}" class="button is-primary is-small is-pulled-right">
          <span class="icon is-small">
            <i class="fa fa-fw fa-plus"></i>
          </span>
          <span>Create new client</span>
        </a>
      </th>
    </tr>
  </thead>
  <tbody>
    @if (count($clients) > 0)
      @foreach ($clients as $client)
        <tr>
          <td>{{ $client->label }}</td>
          <td>{{ $client->abbreviation }}</td>
          <td>
            <a href="https://www.toggl.com/app/workspaces/{{ env('TOGGL_WORKSPACE_ID') }}/clients/{{ $client->toggl_id }}"
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
            <a href=""
               target="_blank"
               class="button has-icon is-danger text-orange is-outlined is-small"
            >
              <span class="icon is-small">
                <i class="fa fa-tasks"></i>
              </span>
              <span>Asana</span>
            </a>
          </td>
          <td>
            <div style="width: 25px; height: 25px; background-color: #{{ $client->color }};">&nbsp;</div>
          </td>
          <td>
            <p class="control has-addons is-pulled-right">
              <a href="{{ route('admin.client.show', $client->id) }}" class="button is-small is-primary is-outlined">
                <span class="icon is-small">
                  <i class="fa fa-fw fa-eye"></i>
                </span>
                <span>View</span>
              </a>
              <a href="{{ route('admin.client.edit', $client->id) }}" class="button is-small is-primary is-outlined">
                <span class="icon is-small">
                  <i class="fa fa-fw fa-edit"></i>
                </span>
                <span>Edit</span>
              </a>
              <a href="{{ route('admin.client.delete', $client->id) }}" class="button is-small is-danger is-outlined">
                <span class="icon is-small">
                  <i class="fa fa-fw fa-trash"></i>
                </span>
                <span>Delete</span>
              </a>
            </p>
          </td>
        </tr>
      @endforeach
    @else
      <tr>
        <td colspan="4">No clients found.</td>
      </tr>
    @endif
  </tbody>
</table>
<div class="columns">
  <div class="column is-4 is-offset-4 is-centered">
    {{ $clients->render() }}
  </div>
</div>

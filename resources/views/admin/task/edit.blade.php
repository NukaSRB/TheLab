<div class="columns">
  <div class="column is-half is-offset-one-quarter">
    <div class="content">
      <h1>Edit: Client</h1>
    </div>
    <div class="control is-horizontal">
      <div class="control-label">
        <label class="label">Label</label>
      </div>
      <div class="control">
        <input type="text" class="input" value="{{ $client->label }}" />
      </div>
    </div>

    <div class="control is-horizontal">
      <div class="control-label">
        <label class="label">Name</label>
      </div>
      <div class="control">
        <input class="input" type="text" value="{{ $client->name }}" disabled>
      </div>
    </div>

    <div class="control is-horizontal">
      <div class="control-label">
        <label class="label">Toggl ID</label>
      </div>
      <div class="control has-addons">
        <input type="text" class="input" value="{{ $client->toggl_id }}" />
        <a href="" class="button">
          <span class="icon is-small">
            <i class="fa fa-fw fa-search"></i>
          </span>
          <span>Toggl Search</span>
        </a>
      </div>
    </div>

    <div class="control is-horizontal">
      <div class="control-label">
        <label class="label">Asana ID</label>
      </div>
      <div class="control has-addons">
        <input type="text" class="input" value="{{ $client->asana_id }}" />
        <a href="" class="button">
          <span class="icon is-small">
            <i class="fa fa-fw fa-search"></i>
          </span>
          <span>Asana Search</span>
        </a>
      </div>
    </div>

    <div class="control is-horizontal">
      <div class="control-label">
        <label class="label">Color</label>
      </div>
      <div class="control has-addons">
        <input class="input jscolor{valueElement: 'valueInput', styleElement: 'styleElement'}" id="valueInput" value="{{ $client->color }}">
        <a class="button" id="styleElement">
          &nbsp;
        </a>
      </div>
    </div>

    <div class="control is-horizontal">
      <div class="control-label"></div>
      <div class="control">
        <button class="button is-primary is-medium">
          <span class="icon">
            <i class="fa fa-fw fa-save"></i>
          </span>
          <span>Save</span>
        </button>
      </div>
    </div>
  </div>
</div>

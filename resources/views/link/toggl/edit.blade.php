<div class="columns">
  <div class="column is-one-third is-offset-one-third ">
    <div class="card m-t-1">
      <header class="card-header">
        <p class="card-header-title">
          Add your toggl token to use the site
        </p>
      </header>
      <div class="card-content">
        <form method="POST">
          {!! csrf_field() !!}
          <p class="control">
            Go to
            <a href="https://www.toggl.com/app/profile" class="text-blue" target="_blank">your Toggl profile page</a>
            and copy the "API Key" from the bottom into the box below.
          </p>
          <p class="control">
            <input class="input" name="token" required="required" value="{{ auth()->user()->getProvider('toggl')->token }}" type="text" placeholder="Toggl Token">
          </p>
          <p class="control">
            <button class="button is-primary">Save Toggl Token</button>
          </p>
        </form>
      </div>
    </div>
  </div>
</div>

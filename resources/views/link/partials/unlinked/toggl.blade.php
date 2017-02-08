<div class="flex-row grey-lighter text-black p-a-1 m-t-1" style="border-radius: 4px;">
  <form method="POST">
    {!! csrf_field() !!}
    <p class="control">
      Go to <a href="https://www.toggl.com/app/profile" class="text-blue" target="_blank">your Toggl profile page</a> and copy the "API Key"
      from the bottom into the box below.
    </p>
    <p class="control">
      <input class="input" type="text" placeholder="Toggl Token">
    </p>
    <p class="control">
      <button class="button is-primary">Save Toggl Token</button>
    </p>
  </form>
</div>

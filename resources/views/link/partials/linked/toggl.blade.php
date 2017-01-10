<div class="flex-row grey-lighter text-black p-a-1 m-t-1" style="border-radius: 4px;">
  <div class="toggl text-toggl text-center p-a-2 m-r-1" style="border-radius: 4px; width: 20%;">
    <h3 class="m-a-0"><i class="fa fa-fw fa-power-off"></i>&nbsp;Toggl</h3>
  </div>
  <div class="flex-2 flex-row">
    <article class="media">
      <figure class="media-left">
        <p class="img is-64">
          @if (! is_null(auth()->user()->getProvider('toggl')->avatar))
            <img src="{{ auth()->user()->getProvider('toggl')->avatar }}" style="width: 56px;" />
          @else
            <img src="/img/placeholders/google_user.png" />
          @endif
        </p>
      </figure>
      <div class="media-body">
        <h3 class="media-heading">
          {{ auth()->user()->getProvider('toggl')->email }}
        </h3>
        <small class="text-gray">Refreshed:&nbsp;{{ auth()->user()->getProvider('toggl')->updated_at->format('F jS Y g:ia') }}</small>
      </div>
    </article>
  </div>
</div>

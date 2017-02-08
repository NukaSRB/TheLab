<div class="columns">
  <div class="column is-8 is-offset-2">
    <div class="content">
      <h4>Linked Accounts</h4>
    </div>
    @include('link.partials.linked.google')
{{--    @if (is_null(auth()->user()->getProvider('toggl')) || auth()->user()->getProvider('toggl')->token === '')--}}
    @if (is_null(auth()->user()->getProvider('toggl')))
      @include('link.partials.unlinked.toggl')
    @else
      @include('link.partials.linked.toggl')
    @endif
    {{--@if (is_null(auth()->user()->getProvider('gitlab')))--}}
      {{--@include('link.partials.unlinked.gitlab')--}}
    {{--@else--}}
      {{--@include('link.partials.linked.gitlab')--}}
    {{--@endif--}}
  </div>
</div>

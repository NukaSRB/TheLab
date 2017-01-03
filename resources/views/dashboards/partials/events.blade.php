<div class="content">
  <h2>Upcoming Meetings:</h2>
</div>
@if ($events->count() > 0)
  @foreach ($events->chunk(4) as $eventGroup)
    <div class="columns" style="display: flex; flex-direction: row;">
      @foreach ($eventGroup as $event)
        <div class="column is-one-quarter" style="flex: 1;">
          <div class="card is-fullwidth" style="max-height: 161px; height: 161px; display: flex;flex-direction: column;">
            <header class="card-header is-clearfix">
              <div class="card-header-title is-pulled-left">
                {{ $event->getSummary() }}
              </div>
              <div class="card-header-title is-pulled-right has-text-right">
                @if (is_null($event->getStart()->dateTime))
                  {{ \Carbon\Carbon::parse($event->start->getDate())->format('F jS') }} All Day
                @elseif (is_null($event->getRecurringEventId))
                  <small>
                    {{ \Carbon\Carbon::parse($event->start->getDateTime())->format('F jS: g:ia') }}
                    -
                    {{ \Carbon\Carbon::parse($event->end->getDateTime())->format('g:ia') }}
                  </small>
                @else
                  <small>
                    {{ \Carbon\Carbon::parse($event->getRecurrence()->start->getDateTime())->format('F jS - g:ia') }}
                    -
                    {{ \Carbon\Carbon::parse($event->getRecurrence()->end->getDateTime())->format('F jS - g:ia') }}
                  </small>
                @endif
              </div>
            </header>
            <div class="card-content" style="flex-grow: 1;height: 80px;overflow-y: auto;">
              <div class="content">
                {{ $event->getDescription() }}
              </div>
            </div>
            <footer class="card-footer" style="min-height: 41px; height: 41px;">
              <a class="card-footer-item" href="{{ $event->hangoutLink }}" target="_blank">
                <span class="icon is-small">
                  <i class="fa fa-fw fa-google"></i>
                </span>
                <span>&nbsp;Hangout</span>
              </a>
              <a class="card-footer-item" href="{{ $event->htmlLink }}" target="_blank">
                <span class="icon is-small">
                  <i class="fa fa-fw fa-calendar-o"></i>
                </span>
                <span>&nbsp;Calendar</span>
              </a>
            </footer>
          </div>
        </div>
      @endforeach
    </div>
  @endforeach
@else
  <div class="box">
    No Meetings Today.
  </div>
@endif

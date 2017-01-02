<nav class="panel">
  <div class="panel-block">
    @if (! is_null($timer))
      <div class="columns">
        <div class="column is-half">
          <div class="content">
            {{ $timer['description'] }}
          </div>
          <div class="columns">
            <div class="column is-half">
              <div class="content">
                <div style="font-size: 2rem;">
                  <span id="hours">0</span>:<span id="minutes">00</span>:<span id="seconds">00</span></div>
              </div>
            </div>
            <div class="column is-one-quarter">
              @if ($timer)
                <a href="{{ route('timer.stop', $timer['id']) }}">
                  <i class="fa fa-fw fa-stop"></i>
                </a>
              @else
                <i class="fa fa-fw fa-play"></i>
              @endif
            </div>
            <div class="column">
              @if ($timer['billable'])
                <i class="fa fa-fw fa-dollar"></i>
              @else
                <i class="fa fa-fw fa-dollar text-grey-light"></i>
              @endif
            </div>
          </div>
        </div>
        <div class="column is-half">
          <ul>
            <li title="Client">C: {{ $timer['client']['name'] }}</li>
            <li title="Project">P: {{ $timer['project']['name'] or null }}</li>
            <li title="Task">T: {{ $timer['task']['name'] or null }}</li>
            <li><a href="https://www.toggl.com/app/timer" class="text-blue" target="_blank">toggl.com</a></li>
          </ul>
        </div>
      </div>
    @else
      <div class="control has-addons">
        <input type="text" class="input" placeholder="What are you working on?" style="width: 100%" />
        <a href="" class="button">
              <span class="icon">
                <i class="fa fa-fw fa-play"></i>
              </span>
          <span>Start</span>
        </a>
      </div>
    @endif
  </div>
</nav>

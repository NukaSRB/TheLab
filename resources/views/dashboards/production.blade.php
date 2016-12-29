<div class="columns">
  <div class="column is-three-quarters">
    <div class="content">
      <h2>Meetings Today:</h2>
    </div>
    <div class="level">
      <div class="level-item">
        <div class="box">
          No Meetings Today.
        </div>
      </div>
    </div>
    <div class="content">
      <h2>Today's Tasks:</h2>
    </div>
    <div class="box">
      <article class="media">
        <div class="media-content">
          <div class="content">
            <p>
              <a><strong class="text-blue">David Emerson</strong></a>
              <small>May 15</small>
            </p>
          </div>
          <div class="media-content">
            <div class="content">
              <p>
                When you add a contact who can read reports and receive alerts but cannot log into the system, I am
                pretty
                sure that we still need them to confirm their identity by entering a 4-digit code – and it should not
                send
                them reports or alerts until they confirm their identity in this way. However, the system does not
                generate
                a 4-digit code for these users nor send them emails. (Strangely, however, it does show a "Resend invite"
                link
                on the "Contacts" page, which works... even though no code was ever generated.) Can you please fix this.
                I
                know that there's some workflow stuff that needs to be figured out here so let me know if you'd like to
                discuss
                this.
              </p>
            </div>
            <div class="content">
              <p><a href="" class="text-blue">7 more comments</a></p>
            </div>
            <div class="content">
              <p>
                <a><strong class="text-blue">David Emerson</strong></a>
                <small>Oct 9 at 2:36pm</small>
              </p>
            </div>
            <div class="media-content">
              <div class="content">
                <p>
                  It's true that all of the users will be read only when we launch (because they'll all be invited from
                  the
                  clinical portal) – but we will eventually need to make sure that the system works for consumer
                  patients as
                  well. That means ensuring that fred can edit david's info and can also invite other users…
                  <a href="" class="text-blue">See More</a>
                </p>
              </div>
              <small class="content text-grey">
                <ul>
                  <li>David Emerson moved from Requirements have changed (needs clarification) to On hold (Production
                      (IL)).Oct 9
                  </li>
                  <li>David Emerson changed Progress from "Problems" to "Waiting".Oct 9</li>
                  <li>David Emerson unassigned from you.Oct 9</li>
                </ul>
              </small>
              <nav class="level is-pulled-right">
                <div class="level-left">
                  <a class="level-item">
                    <span class="icon is-small"><i class="fa fa-external-link"></i></span>
                  </a>
                  <a class="level-item">
                    <span class="icon is-small"><i class="fa fa-comment"></i></span>
                  </a>
                  <a class="level-item">
                    <span class="icon is-small"><i class="fa fa-check-circle-o"></i></span>
                  </a>
                </div>
              </nav>
            </div>
      </article>
    </div>
  </div>
  <div class="column is-one-quarter">
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
                <li>C: {{ $timer['client']['name'] }}</li>
                <li>P: {{ $timer['project']['name'] or null }}</li>
                <li>T: {{ $timer['task']['name'] or null }}</li>
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
    <nav class="panel">
      <p class="panel-heading">
        Daily Schedule
      </p>
      @foreach ($dailySchedule as $schedule)
        <div class="panel-block">
          <div class="columns" style="color: #{{ $schedule->client->color }};">
            <div class="column is-half">
              {{ $schedule->client->label }}
              ({{ percent($schedule->time, $schedule->hours) }}%)
            </div>
            <div class="column is-one-quarter">{{ $schedule->time }}hrs</div>
            <div class="column is-one-quarter">{{ $schedule->hours }}hrs</div>
          </div>
          <progress class="progress {{ $schedule->client->name }}"
                    value="{{ percent($schedule->time, $schedule->hours) }}"
                    max="100"
          >
            {{ percent($schedule->time, $schedule->hours) }}%
          </progress>
        </div>
      @endforeach
    </nav>
    <nav class="panel">
      <p class="panel-heading">
        Weekly Schedule
      </p>
      @foreach ($weeklySchedule as $schedule)
        <div class="panel-block">
          <div class="columns" style="color: #{{ $schedule->client->color }};">
            <div class="column is-half">
              {{ $schedule->client->label }}
              ({{ percent($schedule->time, $schedule->hours) }}%)
            </div>
            <div class="column is-one-quarter">{{ $schedule->time }}hrs</div>
            <div class="column is-one-quarter">{{ $schedule->hours }}hrs</div>
          </div>
          <progress class="progress {{ $schedule->client->name }}"
                    value="{{ percent($schedule->time, $schedule->hours) }}"
                    max="100"
          >
            {{ percent($schedule->time, $schedule->hours) }}%
          </progress>
        </div>
      @endforeach
    </nav>
  </div>
</div>
@section('css')
  <style>
    @foreach ($weeklySchedule as $schedule)
    .{{ $schedule->client->name }}::-webkit-progress-value {
      background-color: #{{ $schedule->client->color }};
    }
    @endforeach
  </style>
@endsection
<script>
  @section('onReadyJs')
    upTime('{{ $timer['start'] }}');
  @endsection
</script>
@section('js')
  <script>
    function upTime(countTo)
    {
      now        = new Date();
      countTo    = new Date(countTo);
      difference = (now - countTo);

      hours = Math.floor((difference % (60 * 60 * 1000 * 24)) / (60 * 60 * 1000) * 1);
      mins  = Math.floor(((difference % (60 * 60 * 1000 * 24)) % (60 * 60 * 1000)) / (60 * 1000) * 1);
      secs  = Math.floor((((difference % (60 * 60 * 1000 * 24)) % (60 * 60 * 1000)) % (60 * 1000)) / 1000 * 1);

      document.getElementById('hours').firstChild.nodeValue   = pad(hours, 1);
      document.getElementById('minutes').firstChild.nodeValue = pad(mins, 2);
      document.getElementById('seconds').firstChild.nodeValue = pad(secs, 2);

      clearTimeout(upTime.to);
      upTime.to = setTimeout(function () { upTime(countTo); }, 1000);
    }

    function pad(n, width, z)
    {
      z = z || '0';
      n = n + '';
      return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n;
    }
  </script>
@endsection

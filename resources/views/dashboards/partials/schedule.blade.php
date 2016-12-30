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

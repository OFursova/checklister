<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                {{ $list_name }}
            </div>
            <div class="card-body">
                @if ($list_tasks->count())
                    <table class="table">
                        @foreach($list_tasks as $task)
                            <tr>
                                <td width="5%">
                                    <input type="checkbox" name="" id="" wire:click="complete_task({{ $task->id }})"
                                           @if(in_array($task->id, $completed_tasks)) checked @endif />
                                </td>
                                <td width="90%">
                                    <p wire:click.prevent="toggle_task( {{$task->id}} )">
                                        {{ $task->name }}
                                    </p>
                                    @if(!is_null($list_type))
                                        <div style="font-style: italic; font-size: 11px">
                                            {{ $task->checklist->name }} |
                                            @if(optional($user_tasks->where('task_id', $task->id)->first())->due_date)
                                                | {{ __('Due') }} {{ $user_tasks->where('task_id', $task->id)->first()->due_date->format('M d, Y') }}
                                            @endif
                                        </div>
                                    @endif
                                </td>
                                <td width="5%">
                                    @if (optional($user_tasks->where('task_id', $task->id)->first())->is_important)
                                        <a wire:click.prevent="mark_as_important({{ $task->id }})" href="#">&starf;</a>
                                    @else
                                        <a wire:click.prevent="mark_as_important({{ $task->id }})" href="#">&star;</a>
                                    @endif
                                </td>
                            </tr>
                            @if (in_array($task->id, $opened_tasks))
                                <tr>
                                    <td></td>
                                    <td colspan="3">{!! $task->description !!}</td>
                                </tr>
                            @endif
                        @endforeach
                    </table>
                @else
                    {{ __('No tasks found') }}
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-4">
        @if (!is_null($current_task))
            <div class="card">
                <div class="card-body">
                    <div class="float-right">
                        <a href="#">&star;</a>
                        @if ($current_task->is_important)
                            <a wire:click.prevent="mark_as_important({{ $current_task->id }})" href="#">&starf;</a>
                        @else
                            <a wire:click.prevent="mark_as_important({{ $current_task->id }})" href="#">&star;</a>
                        @endif
                    </div>
                    <b>{{$current_task->name}}</b>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    &#9788;
                    &nbsp;
                    @if ($current_task->added_to_my_day_at)
                        <a wire:click.prevent="add_to_my_day({{ $current_task->id }})"
                           href="#">{{ __('Remove from My Day') }}</a>
                    @else
                        <a wire:click.prevent="add_to_my_day({{ $current_task->id }})"
                           href="#">{{ __('Add to My Day') }}</a>
                    @endif
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    &#9993;
                    &nbsp;
                    @if($current_task->reminder_at)
                        {{ __('Reminder to be sent at') }} {{ $current_task->reminder_at->format('M j, Y H:i') }}
                        &nbsp;&nbsp;
                        <a href="#" wire:click.prevent="set_reminder({{$current_task->id}})">{{ __('Remove') }}</a>
                    @else
                        <a href="#" wire:click.prevent="toggle_reminder">{{ __('Remind me') }}</a>
                        @if($reminder_opened)
                            <ul>
                                <li>
                                    <a href="#"
                                       wire:click.prevent="set_reminder({{$current_task->id}}, '{{today()->addDay()->toDateString()}}')">{{
                    __('Tommorrow') }} {{ date('H') }}:00</a>
                                </li>
                                <li>
                                    <a href="#"
                                       wire:click.prevent="set_reminder({{$current_task->id}}, '{{today()->addWeek()->startOfWeek()->toDateString()}}')">{{
                    __('Next Monday') }} {{ date('H') }}:00</a>
                                </li>
                                <li>
                                    {{ __('Or pick a date & time') }}
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input wire:model="reminder_date" class="form-control" type="date"/>
                                        </div>
                                        <div class="col-md-3">
                                            <select wire:model="reminder_hour" class="form-control">
                                                @foreach (range(0,23) as $hour)
                                                    <option value="{{ $hour }}">{{ $hour }}:00</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <button wire:click.prevent="set_reminder({{ $current_task->id }}, 'custom')"
                                                    class="btn btn-primary">{{ __('Save') }}</button>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        @endif
                    @endif
                    <hr/>
                    &#9745;
                    &nbsp;
                    @if($current_task->due_date)
                        Due {{ $current_task->due_date->format('M j, Y') }}
                        &nbsp;&nbsp;
                        <a href="#" wire:click.prevent="set_due_date({{$current_task->id}})">{{ __('Remove') }}</a>
                    @else
                        <a href="#" wire:click.prevent="toggle_due_date">{{ __('Add Due Date') }}</a>
                        @if($due_date_opened)
                            <ul>
                                <li>
                                    <a href="#"
                                       wire:click.prevent="set_due_date({{$current_task->id}}, '{{today()->toDateString()}}')">{{
                    __('Today') }}</a>
                                </li>
                                <li>
                                    <a href="#"
                                       wire:click.prevent="set_due_date({{$current_task->id}}, '{{today()->addDay()->toDateString()}}')">{{
                    __('Tommorrow') }}</a>
                                </li>
                                <li>
                                    <a href="#"
                                       wire:click.prevent="set_due_date({{$current_task->id}}, '{{today()->addWeek()->startOfWeek()->toDateString()}}')">{{
                    __('Next week') }}</a>
                                </li>
                                <li>
                                    {{ __('Or pick a date') }}
                                    <br>
                                    <input wire:model="due_date" type="date" name="picker_date">
                                </li>
                            </ul>
                        @endif
                    @endif
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    &#9998;
                    &nbsp;
                    @if($current_task->note)
                        <a wire:click.prevent="toggle_note" href="#">{{ __('Note') }}</a>
                        @if(!$note_opened)
                            <p>
                                {{ $current_task->note }}
                                <br>
                                <a wire:click.prevent="toggle_note" href="#">{{ __('Edit') }}</a>
                            </p>
                        @endif
                    @else
                        <a wire:click.prevent="toggle_note" href="#">{{ __('Note') }}</a>
                    @endif
                    @if($note_opened)
                        <div class="mt-4">
                            <textarea wire:model="note" class="form-control" rows="5"></textarea>
                            <button wire:click="save_note"
                                    class="btn btn-sm btn-primary mt-2">{{ __('Save Note') }}</button>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>

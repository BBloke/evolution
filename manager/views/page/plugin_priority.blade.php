<?php

use EvolutionCMS\Facades\ManagerTheme;

?>
@extends('manager::template.page')
@section('content')
    @push('scripts.top')
        <script>
            var actions = {
                save: function() {
                    var el = document.getElementById('updated');
                    if (el) {
                        el.style.display = 'none';
                    }
                    el = document.getElementById('updating');
                    if (el) {
                        el.style.display = 'block';
                    }
                    setTimeout('document.sortableListForm.submit()', 1000);
                }, cancel: function() {
                    window.location.href = 'index.php?a=76&tab=4';
                },
            };
        </script>
    @endpush

    <h1>
        <i class="{{ ManagerTheme::getStyle('icon_sort_num_asc') }}"></i>{{ __('global.plugin_priority_title') }}
    </h1>

    {!! ManagerTheme::getStyle('actionbuttons.dynamic.save') !!}

    <div class="tab-page">
        <div class="container container-body">
            <b>{{ __('global.plugin_priority') }}</b>
            <p>{{ __('global.plugin_priority_instructions') }}</p>

            @if($updateMsg)
                <span class="text-success" id="updated">{{ __('global.sort_updated') }}</span>
            @endif

            <span class="text-danger" style="display:none;" id="updating">{{ __('global.sort_updating') }}</span>

            <form action="" method="post" name="sortableListForm">
                @csrf
                @foreach($events as $event)
                    <div class="form-group clearfix">
                        <strong>{{ $event->name }}</strong>
                        <ul id="{{ $event->getKey() }}" class="sortableList">
                            @foreach($event->plugins as $plugin)
                                <li id="item_{{ $plugin->getKey() }}"@if($plugin->disabled) class="disabledPlugin"@endif>
                                    <input type="hidden" name="priority[{{ $event->id }}][]" value="{{ $plugin->id }}">
                                    <i class="{{ ManagerTheme::getStyle('icon_plugin') }}"></i> {{ $plugin->name }}@if($plugin->disabled) (hide) @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </form>
        </div>
    </div>

    <script>
        evo.sortable('.sortableList > li');
    </script>
@endsection

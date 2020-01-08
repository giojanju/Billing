<div class="form-group">
    <label for="{{ $key }}">{{ $title }}</label>
    @if(isset($type) && $type == 'textarea')
        <textarea
            placeholder="{{ $placeholder ?? $title }}"
            name="{{ $key }}"
            id="text"
            rows="6"
            class="form-control{{ $errors->has($error_key ?? $key) ? ' parsley-error' : '' }}"
        >{{ $value ?? '' }}</textarea>
    @else
        <input
            type="{{ $type ?? 'text' }}"
            id="{{ $key }}"
            placeholder="{{ $placeholder ?? $title }}"
            name="{{ $key }}"
            class="form-control{{ isset($date) ? ' datepicker' : '' }}{{ isset($only_date) ? ' date' : '' }}{{ $errors->has($error_key ?? $key) ? ' parsley-error' : '' }}"
            value="{{ $value ?? '' }}"
        >
    @endif
    @if($errors->has($error_key ?? $key))
        <span class="parsley-errors-list filled">
            <strong class="parsley-required">
                {{ $errors->first($error_key ?? $key) }}
            </strong>
        </span>
    @endif
</div>

<div class="d-flex justify-content-center">
    @if (isset($value['show-route']))
        <a href="javascript:void(0)" data-id="{{ $dataId }}" title="Show" data-bs-toggle="tooltip"
            class="{{ $value['data-show-id'] }} btn px-2 text-info fs-3 py-2" data-bs-toggle="tooltip">
            <i class="fas fa-eye"></i>
        </a>
    @endif
    <a title="{{ __('messages.common.edit') }}" data-id="{{ $dataId }}" data-bs-toggle="tooltip"
        class="edit-btn btn px-2 text-primary fs-3 py-2 {{ $editClass ?? '' }}">
        <i class="fa-solid fa-pen-to-square"></i>
    </a>

    <a title="{{ __('messages.common.delete') }}" href="javascript:void(0)" data-bs-toggle="tooltip"
        data-id="{{ $dataId }}" class="btn px-2 text-danger fs-3 py-2 {{ $deleteClass ?? '' }}">
        <i class="fa-solid fa-trash"></i>
    </a>
</div>

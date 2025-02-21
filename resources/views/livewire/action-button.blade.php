<div class="width-80px text-center">
    @if(isset($showRoute))
        <a href="{{ $showRoute }}" title="Show"
           class="btn px-2 text-info fs-3 py-2" data-bs-toggle="tooltip">
            <i class="fas fa-eye"></i>
        </a>
    @endif
    @if(isset($editRoute))
        <a href="{{ $editRoute }}"
           class="btn px-2 text-primary fs-3 py-2 {{ $editRoute ?? '' }}  @isset($isDefaultAdmin) {{$isDefaultAdmin == 1 ? 'd-none' : ''}}"
           @endisset data-bs-toggle="tooltip" title="{{__('messages.common.edit')}}">
            <i class="fa-solid fa-pen-to-square"></i>
        </a>
    @endif
    <a href="javascript:void(0)" data-id="{{ $dataId}}"
       class="delete-btn btn px-2 text-danger fs-3 py-2 {{ $deleteClass ?? '' }}  @isset($isDefaultAdmin) {{$isDefaultAdmin == 1 ? 'd-none' : ''}}"
       @endisset title="{{__('messages.common.delete')}}"
       data-bs-toggle="tooltip" wire:key="delete-{{ $dataId }}">
        <i class="fa-solid fa-trash"></i>
    </a>
</div>

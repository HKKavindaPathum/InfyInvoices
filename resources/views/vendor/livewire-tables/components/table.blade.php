@aware(['component', 'tableName'])

@php
    $customAttributes = [
        'wrapper' => $this->getTableWrapperAttributes(),
        'table' => $this->getTableAttributes(),
        'thead' => $this->getTheadAttributes(),
        'tbody' => $this->getTbodyAttributes(),
    ];
@endphp

@if ($component->isTailwind())
    <div wire:key="{{ $tableName }}-twrap"
        {{ $attributes->merge($customAttributes['wrapper'])->class([
                'shadow overflow-y-auto border-b border-gray-200 dark:border-gray-700 sm:rounded-lg' =>
                    $customAttributes['wrapper']['default'] ?? true,
            ])->except('default') }}>
        <table wire:key="{{ $tableName }}-table"
            {{ $attributes->merge($customAttributes['table'])->class(['min-w-full divide-y divide-gray-200 dark:divide-none' => $customAttributes['table']['default'] ?? true])->except('default') }}>
            <thead wire:key="{{ $tableName }}-thead"
                {{ $attributes->merge($customAttributes['thead'])->class(['bg-gray-50 dark:bg-gray-800' => $customAttributes['thead']['default'] ?? true])->except('default') }}>
                <tr>
                    {{ $thead }}
                </tr>
            </thead>

            <tbody wire:key="{{ $tableName }}-tbody" id="{{ $tableName }}-tbody"
                {{ $attributes->merge($customAttributes['tbody'])->class([
                        'bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-none' =>
                            $customAttributes['tbody']['default'] ?? true,
                    ])->except('default') }}>
                {{ $slot }}
            </tbody>

            @if (isset($tfoot))
                <tfoot wire:key="{{ $tableName }}-tfoot">
                    {{ $tfoot }}
                </tfoot>
            @endif
        </table>
    </div>
@elseif ($component->isBootstrap())
    <div class="d-lg-flex justify-content-between align-items-center mb-sm-7 mb-4">
        @if ($component->searchIsEnabled() && $component->searchVisibilityIsEnabled())
            <x-livewire-tables::tools.toolbar.items.search-field />
        @endif
        <div class="d-sm-flex d-block justify-content-end align-items-center pt-0 mt-0">
            @if ($component->showFilterOnHeader == true)
                @include($component->filterComponent[0], [
                    'filterHeads' => [
                        $component->filterComponent[1],
                        isset($component->filterComponent[2]) ? $component->filterComponent[2] : '',
                    ],
                ])
            @endif
            @if ($component->showButtonOnHeader)
                @include($component->buttonComponent)
            @endif
        </div>
    </div>
    <div wire:key="{{ $tableName }}-twrap"
        {{ $attributes->merge($customAttributes['wrapper'])->class(['table-responsive' => $customAttributes['wrapper']['default'] ?? true])->except('default') }}>
        <table wire:key="{{ $tableName }}-table"
            {{ $attributes->merge($customAttributes['table'])->class(['table table-striped livewire-table' => $customAttributes['table']['default'] ?? true])->except('default') }}>
            <thead wire:key="{{ $tableName }}-thead"
                {{ $attributes->merge($customAttributes['thead'])->class(['' => $customAttributes['thead']['default'] ?? true])->except('default') }}>
                <tr>
                    {{ $thead }}
                </tr>
            </thead>

            <tbody wire:key="{{ $tableName }}-tbody" id="{{ $tableName }}-tbody"
                {{ $attributes->merge($customAttributes['tbody'])->class(['' => $customAttributes['tbody']['default'] ?? true])->except('default') }}>
                {{ $slot }}
            </tbody>

            @if (isset($tfoot))
                <tfoot wire:key="{{ $tableName }}-tfoot">
                    {{ $tfoot }}
                </tfoot>
            @endif
        </table>
    </div>
@endif

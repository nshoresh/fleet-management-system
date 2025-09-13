@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">
        <div class="flex justify-between flex-1 sm:hidden">
            {{-- Previous Button --}}
            @if ($paginator->onFirstPage())
                <span
                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium leading-5 text-gray-500 bg-yellow-200 border border-yellow-300 rounded-md cursor-default">
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <button wire:click.prevent="previousPage"
                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-white transition duration-150 ease-in-out bg-yellow-600 border border-yellow-700 rounded-md hover:bg-yellow-700">
                    {!! __('pagination.previous') !!}
                </button>
            @endif

            {{-- Next Button --}}
            @if ($paginator->hasMorePages())
                <button wire:click.prevent="nextPage"
                    class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-white transition duration-150 ease-in-out border border-yellow-700 rounded-md bg-gold-600 hover:bg-yellow-700">
                    {!! __('pagination.next') !!}
                </button>
            @else
                <span
                    class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium leading-5 text-gray-500 bg-gray-200 border border-gray-300 rounded-md cursor-default">
                    {!! __('pagination.next') !!}
                </span>
            @endif
        </div>

        {{-- Pagination Numbers --}}
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm leading-5 text-gray-700">
                    {!! __('Showing') !!}
                    @if ($paginator->firstItem())
                        <span class="font-medium">{{ $paginator->firstItem() }}</span> - <span
                            class="font-medium">{{ $paginator->lastItem() }}</span>
                    @else
                        {{ $paginator->count() }}
                    @endif
                    {!! __('of') !!}
                    <span class="font-medium">{{ $paginator->total() }}</span> {!! __('results') !!}
                </p>
            </div>

            <div>
                <span class="relative z-0 inline-flex rounded-md shadow-sm">
                    {{-- Previous Page --}}
                    @if ($paginator->onFirstPage())
                        <span
                            class="relative inline-flex items-center px-3 py-2 text-gray-500 bg-gray-200 border border-gray-300 cursor-default rounded-l-md">
                            &laquo;
                        </span>
                    @else
                        <button wire:click.prevent="previousPage"
                            class="relative inline-flex items-center px-3 py-2 text-white transition bg-yellow-600 border border-yellow-700 rounded-l-md hover:bg-yellow-700">
                            &laquo;
                        </button>
                    @endif

                    {{-- Pagination Numbers --}}
                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <span
                                class="relative inline-flex items-center px-4 py-2 leading-5 text-gray-500 bg-gray-200 border border-gray-300 cursor-default">
                                {{ $element }}
                            </span>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span
                                        class="relative inline-flex items-center px-4 py-2 font-semibold leading-5 text-white bg-yellow-600 border border-yellow-700 cursor-default">
                                        {{ $page }}
                                    </span>
                                @else
                                    <button wire:click.prevent="gotoPage({{ $page }})"
                                        class="relative inline-flex items-center px-4 py-2 text-gray-700 transition bg-white border border-gray-500 hover:bg-yellow-400 hover:text-white">
                                        {{ $page }}
                                    </button>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page --}}
                    @if ($paginator->hasMorePages())
                        <button wire:click.prevent="nextPage"
                            class="relative inline-flex items-center px-3 py-2 text-white transition border border-yellow-700 bg-gold-600 rounded-r-md hover:bg-yellow-700">
                            &raquo;
                        </button>
                    @else
                        <span
                            class="relative inline-flex items-center px-3 py-2 text-gray-500 bg-gray-200 border border-gray-300 cursor-default rounded-r-md">
                            &raquo;
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif

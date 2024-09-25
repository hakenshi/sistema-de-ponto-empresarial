<div>
    @if ($paginator->hasPages())
        <nav class="pagination-container" role="navigation" aria-label="Pagination Navigation">
            <span>
                @if ($paginator->onFirstPage())
                    <span class="button-paginate-disabled"> <i class="fa-solid fa-chevron-left"></i> </span> <!-- Disabled on the first page -->
                @else
                    <button class="button-paginate" wire:click="previousPage" wire:loading.attr="disabled" rel="prev">
                         <i class="fa-solid fa-chevron-left"></i>  <!-- Previous page arrow -->
                    </button>
                @endif
            </span>

            <span>
                @if ($paginator->onLastPage())
                    <span class="button-paginate-disabled"><i class="fa-solid fa-chevron-right"></i></span> <!-- Disabled on the last page -->
                @else
                    <button class="button-paginate" wire:click="nextPage" wire:loading.attr="disabled" rel="next">
                        <i class="fa-solid fa-chevron-right"></i> <!-- Next page arrow -->
                    </button>
                @endif
            </span>
        </nav>
    @endif
</div>

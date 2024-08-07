<style>
    /* .pagination li {
        padding: 15px;
    }

    .pagination {

        float: right;
    } */

    .active-dot {
        position: relative;
        border-radius: 100%;
        display: block;
        text-decoration: none;
        background-color: #397fac;
        transform: scale(1);
        padding: 5px;
        width: 7px;
        height: 7px;
        border: 7px solid #fff;
        position: relative;
        border-radius: 100%;
        display: block;
        box-shadow: 0 0 0 1px #397fac;
    }
</style>
<nav class="dots-paging">
    <ul class="pagination">
        <!-- Previous Page Link -->
        {{-- @if ($paginator->onFirstPage())
            <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
        @else
            <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a>
            </li>
        @endif --}}

        <!-- Pagination Elements -->
        @foreach ($elements as $element)
            <!-- "Three Dots" Separator -->
            @if (is_string($element))
                <li class="page-item ppp"><a class="">...</a></li>
            @endif

            <!-- Array Of Links -->
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active-dot"><span style="background-color:unset" class="page-link"></span>
                        </li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}"></a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        <!-- Next Page Link -->
        {{-- @if ($paginator->hasMorePages())
            <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a>
            </li>
        @else
            <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
        @endif --}}
    </ul>
</nav>

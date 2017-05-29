<nav id="pagination-nav" aria-label="Page navigation" class="text-center">
    <ul id="pagination-list" class="pagination">
        <li><span class="anchor clickable" {if $currentPage !== 1} onclick="search({$currentPage - 1})" {/if}
                  aria-hidden="true">&laquo;</span></li>

        {for $i = 1 to $numPages}
            <li {if $currentPage === $i} class="active" {/if} >
                <span class="anchor clickable" onclick="search({$i})">{$i} </span>
            </li>
        {/for}
        <li>
            <span class="anchor clickable"
                    {if $currentPage < $numPages} onclick="search({$currentPage + 1})" {/if}
                  aria-hidden="true">&raquo;</span>
        </li>
    </ul>
</nav>

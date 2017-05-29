<div id="tags-selection" style="margin-bottom: 6px;margin-top: 6px">
        <!-- Inline width is MANDATORY for responsiveness. https://select2.github.io/examples.html#responsive -->
        <select id="tags-select" multiple="multiple" style="width: 100%;">
            {foreach $tags as $tag}
                    <option value="{$tag['id']}">{$tag['name']}</option>
            {/foreach}
        </select>
</div>


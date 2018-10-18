<div class="row content-view-line content-type-article align-items-center">
    {if $node.data_map.image.has_content}
    <div class="col-md-6">
        <div class="attribute-image">
            {attribute_view_gui image_class=articlethumbnail href=$node.url_alias|ezurl attribute=$node.data_map.image}
        </div>
    </div>
    {/if}

    <div class="col-md-6">
        <h2 class="field-title">
            <a href="{$node.url_alias|ezurl( 'no' )}" class="teaser-link">{$node.data_map.title.content|wash()}</a>
        </h2>

        {if $node.data_map.intro.content.is_empty|not}
        <div class="attribute-short">
            {attribute_view_gui attribute=$node.data_map.intro}
        </div>
        {/if}


        <a href="{$node.url_alias|ezurl( 'no' )}" class="read-more">{"Read More"|i18n('design/standard/node')}</a>
    </div>
</div>
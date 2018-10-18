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
            {$node.data_map.title.content|wash()}
        </h2>

        {if $node.data_map.intro.content.is_empty|not}
        <div class="attribute-short">
            {attribute_view_gui attribute=$node.data_map.intro}
        </div>
        {/if}

        {def $nodes=fetch( 'content', 'list',
                hash( 'parent_node_id', 2,
                       'sort_by', array( 'published', false() )
        ) )}

        {foreach $nodes as $node}
            - {$node.name|wash} <br />
        {/foreach}


    </div>
</div>
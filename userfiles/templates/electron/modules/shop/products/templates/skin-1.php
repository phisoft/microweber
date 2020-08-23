<?php

/*

type: layout

name: Product Inner Page - Featured Products

description: Skin 1

*/
?>
<?php


$tn = $tn_size;
if (!isset($tn[0]) or ($tn[0]) == 150) {
    $tn[0] = 350;
}
if (!isset($tn[1])) {
    $tn[1] = $tn[0];
}


?>
<?php if (!empty($data)): ?>
    <?php $count = 0; ?>

    <div class="products-list featured">
        <?php
        foreach ($data as $item):

            $count++;
            ?>

            <div class="col-xs-12 col-sm-4 col-lg-3 product-single">
                <?php if ($show_fields == false or in_array('thumbnail', $show_fields)): ?>
                    <div class="post-thumb">
                        <?php if ($show_fields == false or in_array('price', $show_fields)): ?>
                            <?php if (isset($item['prices']) and is_array($item['prices'])) { ?>
                                <?php
                                $vals2 = array_values($item['prices']);
                                $val1 = array_shift($vals2); ?>
                                <span class="price-holder"><?php print currency_format($val1); ?></span>
                            <?php } ?>
                        <?php endif; ?>

                        <a href="<?php print $item['link'] ?>" class="image" style="background-image: url('<?php print thumbnail($item['image'], $tn[0], $tn[1]); ?>');" itemscope
                           itemtype="<?php print $schema_org_item_type_tag ?>"></a>
                    </div>
                <?php endif; ?>

                <div class="post-info">
                    <?php if ($show_fields == false or in_array('title', $show_fields)): ?>
                        <h2 itemprop="name"><a itemprop="url" class="lead" href="<?php print $item['link'] ?>"><?php print $item['title'] ?></a></h2>
                    <?php endif; ?>
                </div>

                <?php if (is_array($item['prices'])): ?>
                    <?php foreach ($item['prices'] as $k => $v): ?>
                        <div class="clear products-list-proceholder mw-add-to-cart-<?php print $item['id'] . $count ?>">
                            <input type="hidden" name="price" value="<?php print $v ?>"/>
                            <input type="hidden" name="content_id" value="<?php print $item['id'] ?>"/>
                        </div>
                        <?php break; endforeach; ?>
                <?php endif; ?>
            </div>

        <?php endforeach; ?>
    </div>
<?php endif; ?>
<?php if (isset($pages_count) and $pages_count > 1 and isset($paging_param)): ?>
    <?php print paging("num={$pages_count}&paging_param={$paging_param}&current_page={$current_page}") ?>
<?php endif; ?>

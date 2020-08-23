<?php

/*

type: layout

name: Add to cart default

description: Add to cart default

*/


?>
<?php

if (isset($params['content-id'])) {
    $product = get_content_by_id($params["content-id"]);
    $title = $product['title'];
} else {
    $title = _e("Product", true);
}


?>

<br class="mw-add-to-cart-spacer"/>
<module type="custom_fields" data-content-id="<?php print intval($for_id); ?>" data-skip-type="price" id="cart_fields_<?php print $params['id'] ?>"/>
<?php if (is_array($data)): ?>
    <div class="price">
        <table class="table-striped">
            <?php foreach ($data as $key => $v): ?>
                <tr class="mw-price-item">
                    <td class="price-label">
                           <span class="mw-price pull-left"><strong>
                              <?php if (is_string($key) and trim(strtolower($key)) == 'price'): ?>
                                  <?php _e($key); ?>
                              <?php else: ?>
                                  <?php print $key; ?>
                              <?php endif; ?>:</strong> <span class="item-price"><?php print currency_format($v); ?></span>
                        </span>
                    </td>
                    <td class="buy-button">
                        <?php if (!isset($in_stock) or $in_stock == false) : ?>
                            <button class="btn btn-default pull-right" type="button" disabled="disabled"
                                    onclick="Alert('<?php print addslashes(_e("This item is out of stock and cannot be ordered", true)); ?>');"><i
                                        class="icon-shopping-cart glyphicon glyphicon-shopping-cart"></i>
                                <?php _e("Out of stock"); ?>
                            </button>
                        <?php else: ?>
                            <button class="btn btn-default pull-right" type="button"
                                    onclick="mw.cart.add('.mw-add-to-cart-<?php print $params['id'] ?>','<?php print $v ?>', '<?php print $title; ?>');"><i
                                        class="icon-shopping-cart glyphicon glyphicon-shopping-cart"></i>
                                <?php _e($button_text !== false ? $button_text : "Add to cart"); ?>
                            </button>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
<?php endif; ?>

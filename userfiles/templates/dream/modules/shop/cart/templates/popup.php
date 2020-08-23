<?php


/*



type: layout



name: Small



description: Small cart template



*/

?>

<div class="cart-small">

    <?php if (is_array($data)) : ?>


        <?php

        $total_qty = 0;

        $total_price = 0;

        foreach ($data as $item) {

            $total_qty += $item['qty'];
            $picture = $item['picture'];

            $total_price += $item['price'] * $item['qty'];

        }

        ?>


        <?php
        if (!isset($params['checkout-link-enabled'])) {
            $checkout_link_enanbled = get_option('data-checkout-link-enabled', $params['id']);
        } else {
            $checkout_link_enanbled = $params['checkout-link-enabled'];
        }
        ?>

        <?php if ($checkout_link_enanbled != 'n') : ?>
            <?php $checkout_page = get_option('data-checkout-page', $params['id']); ?>
            <?php if ($checkout_page != false and strtolower($checkout_page) != 'default' and intval($checkout_page) > 0) {
                $checkout_page_link = content_link($checkout_page) . '/view:checkout';
            } else {
                $checkout_page_link = checkout_url();
            }
            ?>

            <a href="<?php print $checkout_page_link; ?>" class="mw-cart-small">
                <!--                <span>Items</span>-->
                <?php if (isset($picture)): ?>
                    <span class="picture"><img src="<?php thumbnail($picture); ?>"/></span>
                <?php endif; ?>
                <span class="bag"><?php print $total_qty; ?></span>
            </a>
        <?php endif; ?>
    <?php else : ?>
        <a href="#" class="mw-cart-small">
            <!--            <span>Items</span>-->
            <span class="bag">0</span>
        </a>
    <?php endif; ?>
</div>
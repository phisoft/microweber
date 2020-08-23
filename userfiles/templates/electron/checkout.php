<?php
/*
type: layout
name: Checkout
position: 3
description: Checkout
*/
?>
<?php include template_dir() . "header.php"; ?>

    <div class="edit" field="electron_content" rel="content">
        <div class="container-fluid nodrop">
            <div class="white-wrapper">
                <div class="container p-t-40 p-b-40">
                    <div class="col-xs-12">
                        <div field="checkout_page" rel="content">
                            <module type="shop/checkout" id="cart_checkout" template="checkout-1"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include template_dir() . "footer.php"; ?>
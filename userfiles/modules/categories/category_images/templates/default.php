<?php
/*

  type: layout

  name: Default

  description: Default



*/
?>

<script>mw.require("<?php print $config['url_to_module'];?>style.css");</script>
<br/><br/>
<div class="container">
    <div class="row">
        <?php if ($data != false) {
            foreach ($data as $cat) { ?>
            <div class="col-sm-12 col-md-4 text-center">
                <div class="card boxed bg--white">
                    <div class="card--image">
                        <img src="<?php print thumbnail($cat['picture'], 200, 200); ?>" />
                    </div> 
                    <a href="<?php print $cat['url']; ?>"> <strong><?php print $cat['title']; ?></strong> </a>
                    <br/><br/>
                    <a class="btn btn--primary btn-default" href="<?php print $cat['url']; ?>">
                        <span class="btn__text"> View Products </span>
                    </a>
                </div> 
            </div>
            <?php }
        } ?>
    </div>
</div>
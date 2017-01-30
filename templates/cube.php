<SCRIPT>
    var sources = JSON.parse('<?php echo $data['sources'] ?>'),
        WINDOW_FACTORY = new modal_window_factory(),
        RESOURCE_MODEL = new localResource();
</SCRIPT>
<div class="container-wrapper container">
    <div id="cube">
        <?php $sources = json_decode($data['sources'], true);?>
        <?php for($i=0;$i<6;$i++) {?>
            <?php if (!empty($sources)) { ?>
                <?php $itemKey = key($sources); ?>
                <figure class="<?php echo $data['sides'][$i] ?>" sideId="<?php echo $itemKey ?>">
                    <div class="container">
                        <div class="row">
                            <div class="twelve columns" style="">
                                <h3><?php echo $sources[$itemKey]['title'] ?></h3>
                            </div>
                        </div>
                    </div>
                    <div id="<?php echo $itemKey ?>-list" class="container" category="<?php echo $itemKey ?>">

                    </div>
                </figure>
                <?php unset($sources[$itemKey]) ?>
            <?php } else { ?>
                <figure class="<?php echo $data['sides'][$i] ?>"></figure>
            <?php } ?>
        <?php } ?>
    </div>
</div>
<?php //TODO: Need to use decoder only ones!!! ?>
<?php $sources = json_decode($data['sources'], true);?>
<?php $top = 200;?>
<?php foreach($sources as $name=>$data) { ?>
    <button id="<?php echo $name ?>-side" class="side-button" style="top: <?php echo $top; ?>px;"><?php echo $data['title'] ?></button>
    <script>
        $('#<?php echo $name ?>-side').on('click', function(){
            var rotateClass=$('#cube figure[sideId=<?php echo $name ?>]').attr('class') + '-side';
            $('#cube').removeClass().addClass(rotateClass);
        });
    </script>
    <?php $top += 50; ?>
<?php } ?>

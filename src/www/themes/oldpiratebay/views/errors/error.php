<div class="hero-unit thanks">
    <div class="left-dummy" style="text-align: center !important;">
        <h1>Error <?php echo $data['code']; ?></h1>
        <p>
            <h2><?php echo nl2br(CHtml::encode($data['message'])); ?></h2>
        </p>
        <p>
            Something went terribly terribly wrong. Try it again later, friend.
        </p>
    </div>
    <div class="clearfix"></div>
</div>


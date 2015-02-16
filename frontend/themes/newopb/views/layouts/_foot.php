<?php
use yii\helpers\Url;
?>
        <div class="box-footer">
            <div class="wrapper">
                <footer>
                    <div class="center footer">
                        <div class="txt-center">
                            <?php if (Yii::$app->user->isGuest) : ?>
                                <a href="<?= Url::toRoute('site/login'); ?>" title="Login">Login</a> | <a href="<?= Url::toRoute('site/signup'); ?>" title="Register">Register</a>
                            <?php else: ?>
                                <a href="<?= Url::toRoute('site/logout'); ?>" title="Sign Out" data-method='post'>Sign Out (<?= Yii::$app->user->identity->username; ?>)</a>
                            <?php endif; ?>
                            <?php /* | <a href="#">About</a> | <a href="#">Contact us</a> | <a href="#">Help</a>* /?> | <a href="<?= Url::toRoute('/100k'); ?>">100k for pirates</a>
                            <br/>
                            <?php /*<a href="#">for Developers</a> | <a href="#">for Moderators</a> | <a href="#">for Uploaders</a>*/ ?>
                        </div>
                        <div class="txt-center">
                            <div class="likely pirate">
                                <span class="social fb">
                                <!-- FACEBOOK -->
                                    <style>
                                        .fb-like {
                                            position: relative;
                                            top: -6px;

                                        }
                                        .social.tw, .social.gp {
                                            position: relative;
                                            left: 35px;
                                        }
                                    </style>
                                    <div id="fb-root"></div>
                                    <script>(function(d, s, id) {
                                      var js, fjs = d.getElementsByTagName(s)[0];
                                      if (d.getElementById(id)) return;
                                      js = d.createElement(s); js.id = id;
                                      js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.0";
                                      fjs.parentNode.insertBefore(js, fjs);
                                    }(document, 'script', 'facebook-jssdk'));</script>
                                    <div class="fb-like" data-href="http://oldpiratebay.org" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
                                <!-- /FACEBOOK -->
                                </span>
                                <span class="social tw">
                                    <a href="https://twitter.com/share" class="twitter-share-button" data-url="http://oldpiratebay.org/100k" data-text="Change the future of the torrenting #100kReward">Tweet</a>
                                    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
                                </span>
                                <span class="social gp">
                                    <script src="https://apis.google.com/js/platform.js" async defer></script>
                                    <div class="g-plusone" data-size="medium"></div>
                                </span>
                            </div>
                        </div>
                        <span class="left"> Powered by <a href="http://openbay.isohunt.to">OpenBay</a></span>
                        <span class="right"> <a href="http://isohunt.to/">isoHunt</a> Group</span>
                        <div class="clear"></div>
                    </div>
                </footer>
            </div>
        </div>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>

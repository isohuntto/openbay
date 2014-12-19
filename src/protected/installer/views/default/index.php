<?php
    $cs = Yii::app()->clientScript;
    $baseUrl = $this->module->assetsUrl;

    $cs->registerScriptFile($baseUrl . '/js/index.js', CClientScript::POS_END);
?>
<div class="bs-docs-header" data-role="content">
    <div class="container">
        <h1>Installer</h1>
        <p>Pirate Bay source code is an open source website engine that allows you to create your own copy of Pirate Bay with minimal time and efforts spent.</p>
    </div>
</div>

<div class="container bs-docs-container">
    <div class="row">
        <div class="col-md-9" role="main">
            <form role="form" method="post" action="">
            <div>
                <h1 id="requirements" class="page-header">System requirements <small>Step 1 of 6</small></h1>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h3>PHP Modules</h3>
                        <p><span style="color: darkgreen">Green</span> color shows you the modules that your hosting have. <span style="color: darkred">Red</span> color indicates missing modules of your hosting environment. In case of missing some modules contact your hosting system administrator.</p>
                        <hr>
                        <?php foreach($requirements as $name => $exists): ?>
                            <div class="alert alert-<?= $exists ? 'success' : 'danger' ?>" role="alert">
                                <strong><?= $name ?></strong>
                                <span class="pull-right glyphicon glyphicon-<?= $exists ? 'ok' : 'remove' ?>" aria-hidden="true"></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div>
                <h1 id="general" class="page-header">General <small>Step 2 of 6</small></h1>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <p>Enter name that will be title on every page.</p>
                        <hr>
                        <div class="form-group <?= !isset($errors['name']) ?: 'has-error' ?>">
                            <label for="name">Name</label>
                            <input name="Settings[name]" type="text" class="form-control" id="name" placeholder="My super pirate bay!" >
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <h1 id="database" class="page-header">Database <small>Step 3 of 6</small></h1>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <p>
                            Database is very important. Content on your whole website depends on this choice. We can provide our hosted database by default. or you can enter your own database account data.
                        </p>
                        <hr>
                        <p>
                            Use <b>our</b> database configuration <input name="Settings[dbOurConfig]" type="checkbox" class="db-settings-switcher" data-size="mini" checked>
                        </p>
                        <div class="database-settings" style="display: none;">
                            <hr>
                            <div class="form-group <?= !isset($errors['dbHost']) ?: 'has-error' ?>">
                                <label for="db-host">Host</label>
                                <input name="Settings[dbHost]"  type="text" class="form-control" id="db-host" placeholder="126.0.0.1">
                            </div>
                            <div class="form-group">
                                <label for="db-port <?= !isset($errors['dbPort']) ?: 'has-error' ?>">Port</label>
                                <input name="Settings[dbPort]" type="text" class="form-control" id="db-port" placeholder="3306">
                            </div>
                            <div class="form-group">
                                <label for="db-name <?= !isset($errors['dbName']) ?: 'has-error' ?>">Database</label>
                                <input name="Settings[dbName]" type="text" class="form-control" id="db-name" placeholder="piratebay">
                            </div>
                            <div class="form-group">
                                <label for="db-user <?= !isset($errors['dbUser']) ?: 'has-error' ?>">Username</label>
                                <input name="Settings[dbUser]" type="text" class="form-control" id="db-user" placeholder="root">
                            </div>
                            <div class="form-group">
                                <label for="db-pass <?= !isset($errors['dbPassword']) ?: 'has-error' ?>">Password</label>
                                <input name="Settings[dbPassword]" type="password" class="form-control" id="db-pass" placeholder="rootpass">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <h1 id="sphinx" class="page-header">Sphinx <small>Step 4 of 6</small></h1>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <p>Sphinx is a search engine that finds torrents in the database. You can use our Sphinx by default or enter your own configuration.</p>
                        <hr>
                        <p>
                            Use <b>our</b> sphinx configuration <input name="Settings[sphinxOurConfig]" type="checkbox" class="sphinx-settings-switcher" data-size="mini" checked>
                        </p>
                        <div class="sphinx-settings" style="display: none;">
                            <hr>
                            <div class="bs-callout bs-callout-danger">
                                <h4>Sphinx configuration</h4>
                                <p><a href="https://github.com/isohuntto/openbay/wiki/sphinx" target="_blank">Read instruction here</a></p>
                            </div>
                            <div class="form-group">
                                <label for="sphinx-host <?= !isset($errors['sphinxHost']) ?: 'has-error' ?>">Host</label>
                                <input name="Settings[sphinxHost]" type="text" class="form-control" id="sphinx-host" placeholder="126.0.0.1">
                            </div>
                            <div class="form-group">
                                <label for="sphinx-port <?= !isset($errors['sphinxPort']) ?: 'has-error' ?>">Port</label>
                                <input name="Settings[sphinxPort]" type="text" class="form-control" id="sphinx-port" placeholder="9306">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <h1 id="cache" class="page-header">Cache <small>Step 5 of 6</small></h1>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <p>Cache is a temporary file storage to help your site work faster.</p>
                        <hr>
                        <p>
                            Use file cache <input name="Settings[enableFileCache]" type="checkbox" class="cache-switcher" data-size="mini" checked>
                        </p>
                    </div>
                </div>
            </div>
            <div>
                <h1 id="log" class="page-header">Log <small>Step 6 of 6</small></h1>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <p>
                            Logging saves all the errors that happen on your website to help you trace those issues on github.
                        </p>
                        <hr>
                        <p>
                            Enable log <input name="Settings[enableLog]" type="checkbox" class="log-switcher" data-size="mini" checked>
                        </p>
                    </div>
                </div>
            </div>
            <div>
                <h1 id="log" class="page-header">To finish press button!</h1>
                <p>
                    <button type="submit" class="btn btn-success btn-lg <?= !$disableForm ? '' : 'disabled' ?>">Deploy</button>
                </p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="bs-docs-sidebar hidden-print hidden-xs hidden-sm affix-top" data-spy="affix" data-offset-top="310" data-offset-bottom="200" id="sidebar">
                <ul class="nav bs-docs-nav" >
                    <li>
                        <a href="#requirements">System requirements</a>
                    </li>
                    <li>
                        <a href="#general">General</a>
                    </li>
                    <li>
                        <a href="#database">Database</a>
                    </li>
                    <li>
                        <a href="#sphinx">Sphinx</a>
                    </li>
                    <li>
                        <a href="#cache">Cache</a>
                    </li>
                    <li>
                        <a href="#log">Log</a>
                    </li>
                    <li>
                        <a href="#finish">To finish press button!</a>
                    </li>
                </ul>
            </div>
        </div>
        </form>
    </div>
</div>
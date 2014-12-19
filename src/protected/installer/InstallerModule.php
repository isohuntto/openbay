<?php
class InstallerModule  extends CWebModule
{
    private $_assetsUrl;

    public function init()
    {
        parent::init();
        Yii::setPathOfAlias('installer', dirname(__FILE__));

        Yii::app()->setComponents(array(
            'errorHandler'=>array(
                'class'=>'CErrorHandler',
                'errorAction'=>parent::getId().'/default/error',
            ),
            'widgetFactory' => array(
                'class'=>'CWidgetFactory',
                'widgets' => array()
            )
        ), false);
    }

    public function getAssetsUrl()
    {
        if($this->_assetsUrl===null)
            $this->_assetsUrl=Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('installer.assets'));
        return $this->_assetsUrl;
    }

    public function setAssetsUrl($value)
    {
        $this->_assetsUrl=$value;
    }
}
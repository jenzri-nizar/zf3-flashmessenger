<?php

namespace Zf3\FlashMessenger\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\View\Helper\FlashMessenger;
use Zend\View\Helper\InlineScript;
use Zend\View\Helper\HeadLink;
use Zend\View\Helper\BasePath;
use Zend\View\Helper\Url;
class FlashMsg extends AbstractHelper
{
    private $flashMessenger;
    private $inlineScript;
    private $Url;
    private $headLink;
    public function __construct(FlashMessenger $flashMessenger, InlineScript $inlineScript,HeadLink $headLink,Url $Url)
    {
        
        $this->flashMessenger = $flashMessenger;
        $this->inlineScript   = $inlineScript;
        $this->headLink=$headLink;
        $this->Url=$Url;

    }

    /**
     * Collect all messages from previous and current request
     * clear current messages because we will show it
     * add JS files
     * add JS notifications
     */
    public function __invoke()
    {
        $Url = $this->Url;
        $plugin   = $this->flashMessenger->getPluginFlashMessenger();
        $noty     = [
            'alert'       => array_merge($plugin->getMessages(), $plugin->getCurrentMessages()),
            'information' => array_merge($plugin->getInfoMessages(), $plugin->getCurrentInfoMessages()),
            'success'     => array_merge($plugin->getSuccessMessages(), $plugin->getCurrentSuccessMessages()),
            'warning'     => array_merge($plugin->getWarningMessages(), $plugin->getCurrentWarningMessages()),
            'error'       => array_merge($plugin->getErrorMessages(), $plugin->getCurrentErrorMessages()),
        ];

        $plugin->clearCurrentMessages('default');
        $plugin->clearCurrentMessages('info');
        $plugin->clearCurrentMessages('success');
        $plugin->clearCurrentMessages('warning');
        $plugin->clearCurrentMessages('error');
        
        $this->inlineScript->appendFile($Url('FlashMessenger',array("action"=>"js")));
        
        echo '<link href="'.$Url('FlashMessenger',array("action"=>"css")).'" media="screen" rel="stylesheet" type="text/css">';
        $this->inlineScript->captureStart();
        foreach(array_filter($noty) as $type => $messages){
            $message = implode('<br/><br/>', $messages);
            $message = preg_replace('/\s+/', ' ', $message);
            switch($type){
                case "alert":echo 'toastr.info("'.$message.'");';break;
                case "information":echo 'toastr.info("'.$message.'");';break;
                case "success":echo 'toastr.success("'.$message.'");';break;
                case "warning":echo 'toastr.warning("'.$message.'");';break;
                case "error":echo 'toastr.error("'.$message.'");';break;
            }
            
        }
        $this->inlineScript->captureEnd();
    }
    
   

}
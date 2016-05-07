<?php
use Cake\Core\Configure;
use Cake\Error\Debugger;

$this->layout = 'default';
$this->assign('title', h($error->getMessage()));

if (Configure::read('debug')):
    $this->layout = 'dev_error';

    $this->assign('title', $message);
    $this->assign('templateName', 'error500.ctp');

    $this->start('file');
    ?>
    <?php if (!empty($error->queryString)): ?>
        <p class="notice">
            <strong>SQL Query: </strong>
            <?=h($error->queryString)?>
        </p>
    <?php endif;?>
<?php if (!empty($error->params)): ?>
    <strong>SQL Query Params: </strong>
    <?php Debugger::dump($error->params)?>
<?php endif;?>
<?php if ($error instanceof Error): ?>
    <strong>Error in: </strong>
    <?=sprintf('%s, line %s', str_replace(ROOT, 'ROOT', $error->getFile()), $error->getLine())?>
<?php endif;?>
<?php
echo $this->element('auto_table_warning');

if (extension_loaded('xdebug')):
    xdebug_print_function_stack();
endif;

$this->end();
endif;
?>
<?php
if ($this->request->session()->read('Auth.User')
    && isset($this->request->params['prefix'])
    && $this->request->params['prefix'] === 'admin'):
?>
<div class="row">
    <div class="col-xs-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title"><?=__('Error {0}', $code)?></div>
            </div>
            <div class="card-body">
                <p><?=sprintf(__d('cake', 'The requested address %s was not found on this server.'), "<strong>'{$url}'</strong>")?></p>
                <p>
                    <?=$this->Html->link('<i class="fa fa-caret-left fa-lg"></i>&nbsp;' . __('Back to home'), ['controller' => 'Dashboard', 'action' => 'index'], ['class' => 'btn btn-success', 'escape' => false])?>
                </p>
            </div>
        </div>
    </div>
</div>
<?php
else:
    $this->layout = 'error';
    ?>
    <legend><?=__('Error {0}', $code)?></legend>
    <p class="error-message">
        <?=h($error->getMessage())?>
    </p>
<?php
endif;
?>
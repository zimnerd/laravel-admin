<?php

namespace Encore\Admin\Grid\Tools;

use Encore\Admin\Admin;
use Encore\Admin\Grid;

class ImportButton extends AbstractTool
{
    /**
     * Create a new Import button instance.
     *
     * @param Grid $grid
     */
    public function __construct(Grid $grid)
    {
        $this->grid = $grid;
    }

    /**
     * Set up script for import button.
     */
    protected function setUpScripts()
    {
        $script = <<<'SCRIPT'

$('.import-selected').click(function (e) {
    e.preventDefault();
    
    var rows = selectedRows().join(',');
    if (!rows) {
        return false;
    }
    
    var href = $(this).attr('href').replace('__rows__', rows);
    location.href = href;
});

SCRIPT;

        Admin::script($script);
    }

    /**
     * Render Import button.
     *
     * @return string
     */
    public function render()
    {
        if (!$this->grid->allowImport()) {
            return '';
        }

        $this->setUpScripts();

        $import = trans('admin.import');
        $all = trans('admin.all');
        $currentPage = trans('admin.current_page');
        $selectedRows = trans('admin.selected_rows');

        $page = request('page', 1);

        return <<<EOT

<div class="btn-group pull-right" style="margin-right: 10px">
    <a class="btn btn-sm btn-twitter" href="{$this->grid->importUrl()}"><i class="fa fa-upload"></i> Import CSV</a>
</div>
&nbsp;&nbsp;
EOT;
    }
}
